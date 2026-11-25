<?php

namespace App\Http\Controllers\StaffApp;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Staff;
use App\Models\StaffDailyReport;
use App\Models\StaffDailyReportActivity;
use App\Models\StaffDailyReportReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class StaffDailyReportController extends Controller
{
    private function staff()
    {
        return Auth::guard('staff')->user();
    }

    private function reportForStaff($id, $staff)
    {
        return StaffDailyReport::where('hospital_id', $staff->hospital_id)
            ->where('staff_id', $staff->id)
            ->findOrFail($id);
    }

    private function canEditReport($report): bool
    {
        return in_array($report->status, ['draft', 'revision_requested'], true);
    }

    /**
     * List logged-in staff member's reports.
     */
    public function index(Request $request)
    {
        try {
            $staff = $this->staff();

            if (!$staff || !$staff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $reports = StaffDailyReport::with([
                'activities',
                'reviews',
            ])
                ->where('hospital_id', $staff->hospital_id)
                ->where('staff_id', $staff->id)
                ->when($request->filled('status'), function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->when($request->filled('from_date'), function ($query) use ($request) {
                    $query->whereDate('report_date', '>=', $request->from_date);
                })
                ->when($request->filled('to_date'), function ($query) use ($request) {
                    $query->whereDate('report_date', '<=', $request->to_date);
                })
                ->latest('report_date')
                ->paginate(50);

            return response()->json([
                'success' => 1,
                'message' => 'Daily reports fetched successfully.',
                'data' => $reports,
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to fetch daily reports.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get today's report.
     */
    public function today()
    {
        try {
            $staff = $this->staff();

            if (!$staff || !$staff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $report = StaffDailyReport::with(['activities', 'reviews'])
                ->where('hospital_id', $staff->hospital_id)
                ->where('staff_id', $staff->id)
                ->whereDate('report_date', today())
                ->first();

            return response()->json([
                'success' => 1,
                'message' => 'Today report fetched successfully.',
                'data' => $report,
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to fetch today report.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create daily report.
     * One report per staff member per date.
     */
    public function store(Request $request)
    {
        try {
            $staff = $this->staff();

            if (!$staff || !$staff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'report_date' => [
                    'nullable',
                    'date',
                    'before_or_equal:today',
                ],
                'working_status' => [
                    'nullable',
                    Rule::in(['present', 'half_day', 'leave']),
                ],
                'start_time' => ['nullable', 'date_format:H:i'],
                'end_time' => ['nullable', 'date_format:H:i'],
                'work_summary' => ['nullable', 'string'],
                'achievements' => ['nullable', 'string'],
                'challenges' => ['nullable', 'string'],
                'pending_work' => ['nullable', 'string'],
                'tomorrow_plan' => ['nullable', 'string'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $validator->validated();
            $reportDate = $data['report_date'] ?? today()->toDateString();

            $report = StaffDailyReport::where('hospital_id', $staff->hospital_id)
                ->where('staff_id', $staff->id)
                ->whereDate('report_date', $reportDate)
                ->first();

            if ($report) {
                if (!$this->canEditReport($report)) {
                    return response()->json([
                        'success' => 0,
                        'message' => 'A submitted report already exists for this date.',
                        'data' => $report,
                    ], 422);
                }

                $report->update(collect($data)->except('report_date')->all());
            } else {
                $report = StaffDailyReport::create([
                    'hospital_id' => $staff->hospital_id,
                    'staff_id' => $staff->id,
                    'report_date' => $reportDate,
                    'working_status' => $data['working_status'] ?? 'present',
                    'start_time' => $data['start_time'] ?? null,
                    'end_time' => $data['end_time'] ?? null,
                    'work_summary' => $data['work_summary'] ?? null,
                    'achievements' => $data['achievements'] ?? null,
                    'challenges' => $data['challenges'] ?? null,
                    'pending_work' => $data['pending_work'] ?? null,
                    'tomorrow_plan' => $data['tomorrow_plan'] ?? null,
                    'status' => 'draft',
                ]);
            }

            $report->load(['activities', 'reviews']);

            return response()->json([
                'success' => 1,
                'message' => 'Daily report saved successfully.',
                'data' => $report,
            ], 201);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to save daily report.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update report header before submission or after revision.
     */
    public function update(Request $request, $id)
    {
        try {
            $staff = $this->staff();

            if (!$staff || !$staff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $report = $this->reportForStaff($id, $staff);

            if (!$this->canEditReport($report)) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Only draft or revision-requested reports can be updated.',
                ], 422);
            }

            $validator = Validator::make($request->all(), [
                'working_status' => [
                    'sometimes',
                    Rule::in(['present', 'half_day', 'leave']),
                ],
                'start_time' => ['nullable', 'date_format:H:i'],
                'end_time' => ['nullable', 'date_format:H:i'],
                'work_summary' => ['nullable', 'string'],
                'achievements' => ['nullable', 'string'],
                'challenges' => ['nullable', 'string'],
                'pending_work' => ['nullable', 'string'],
                'tomorrow_plan' => ['nullable', 'string'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $report->update($validator->validated());

            return response()->json([
                'success' => 1,
                'message' => 'Daily report updated successfully.',
                'data' => $report->fresh(['activities', 'reviews']),
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to update daily report.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add daily activity.
     */
    public function storeActivity(Request $request, $reportId)
    {
        try {
            $staff = $this->staff();

            if (!$staff || !$staff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $report = $this->reportForStaff($reportId, $staff);

            if (!$this->canEditReport($report)) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Activities cannot be added after report submission.',
                ], 422);
            }

            $validator = Validator::make($request->all(), [
                'activity_type' => [
                    'required',
                    Rule::in([
                        'lead_call',
                        'lead_follow_up',
                        'hospital_visit',
                        'meeting',
                        'new_lead',
                        'other',
                    ]),
                ],
                'lead_id' => [
                    'nullable',
                    'integer',
                    Rule::exists('leads', 'id')->where(function ($query) use ($staff) {
                        $query->where('hospital_id', $staff->hospital_id);
                    }),
                ],
                'organization_name' => ['nullable', 'string', 'max:255'],
                'contact_person' => ['nullable', 'string', 'max:255'],
                'mobile' => ['nullable', 'string', 'max:20'],
                'description' => ['nullable', 'string'],
                'outcome' => ['nullable', 'string'],
                'next_follow_up_at' => ['nullable', 'date'],
                'activity_at' => ['nullable', 'date'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $activity = StaffDailyReportActivity::create([
                'hospital_id' => $staff->hospital_id,
                'staff_daily_report_id' => $report->id,
                'staff_id' => $staff->id,
                ...$validator->validated(),
            ]);

            return response()->json([
                'success' => 1,
                'message' => 'Activity added successfully.',
                'data' => $activity,
            ], 201);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to add activity.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an activity.
     */
    public function updateActivity(Request $request, $reportId, $activityId)
    {
        try {
            $staff = $this->staff();

            if (!$staff || !$staff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $report = $this->reportForStaff($reportId, $staff);

            if (!$this->canEditReport($report)) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Submitted report activities cannot be changed.',
                ], 422);
            }

            $activity = StaffDailyReportActivity::where('hospital_id', $staff->hospital_id)
                ->where('staff_daily_report_id', $report->id)
                ->where('staff_id', $staff->id)
                ->findOrFail($activityId);

            $validator = Validator::make($request->all(), [
                'activity_type' => [
                    'sometimes',
                    Rule::in([
                        'lead_call',
                        'lead_follow_up',
                        'hospital_visit',
                        'meeting',
                        'new_lead',
                        'other',
                    ]),
                ],
                'lead_id' => [
                    'nullable',
                    'integer',
                    Rule::exists('leads', 'id')->where(function ($query) use ($staff) {
                        $query->where('hospital_id', $staff->hospital_id);
                    }),
                ],
                'organization_name' => ['nullable', 'string', 'max:255'],
                'contact_person' => ['nullable', 'string', 'max:255'],
                'mobile' => ['nullable', 'string', 'max:20'],
                'description' => ['nullable', 'string'],
                'outcome' => ['nullable', 'string'],
                'next_follow_up_at' => ['nullable', 'date'],
                'activity_at' => ['nullable', 'date'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $activity->update($validator->validated());

            return response()->json([
                'success' => 1,
                'message' => 'Activity updated successfully.',
                'data' => $activity,
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to update activity.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete an activity.
     */
    public function destroyActivity($reportId, $activityId)
    {
        try {
            $staff = $this->staff();

            if (!$staff || !$staff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $report = $this->reportForStaff($reportId, $staff);

            if (!$this->canEditReport($report)) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Submitted report activities cannot be deleted.',
                ], 422);
            }

            $activity = StaffDailyReportActivity::where('hospital_id', $staff->hospital_id)
                ->where('staff_daily_report_id', $report->id)
                ->where('staff_id', $staff->id)
                ->findOrFail($activityId);

            $activity->delete();

            return response()->json([
                'success' => 1,
                'message' => 'Activity deleted successfully.',
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to delete activity.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Submit report to manager and Hospital Admin.
     */
    public function submit($id)
    {
        try {
            $staff = $this->staff();

            if (!$staff || !$staff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            DB::transaction(function () use ($id, $staff) {
                $report = StaffDailyReport::where('hospital_id', $staff->hospital_id)
                    ->where('staff_id', $staff->id)
                    ->lockForUpdate()
                    ->findOrFail($id);

                if (!$this->canEditReport($report)) {
                    abort(422, 'This report has already been submitted.');
                }

                if (!$report->activities()->exists()) {
                    abort(422, 'Add at least one daily activity before submitting.');
                }

                if (
                    $report->working_status !== 'leave' &&
                    (!$report->start_time || !$report->end_time)
                ) {
                    abort(422, 'Please provide work start time and end time.');
                }

                // if ($staff->added_by_type !== 'staff' || !$staff->added_by) {
                //     abort(422, 'Reporting manager is not configured for this staff member.');
                // }

                // $manager = Staff::where('hospital_id', $staff->hospital_id)
                //     ->where('id', $staff->added_by)
                //     ->first();

                // if (!$manager) {
                //     abort(422, 'Reporting manager was not found.');
                // }

                // $reviewers = [
                //     [
                //         'reviewer_id' => $manager->id,
                //         'reviewer_type' => 'staff',
                //     ],
                //     [
                //         'reviewer_id' => $staff->hospital_id,
                //         'reviewer_type' => 'hospital',
                //     ],
                // ];

                // foreach ($reviewers as $reviewer) {
                //     StaffDailyReportReview::updateOrCreate(
                //         [
                //             'hospital_id' => $staff->hospital_id,
                //             'staff_daily_report_id' => $report->id,
                //             'reviewer_id' => $reviewer['reviewer_id'],
                //             'reviewer_type' => $reviewer['reviewer_type'],
                //         ],
                //         [
                //             'status' => 'pending',
                //             'remarks' => null,
                //             'reviewed_at' => null,
                //         ]
                //     );
                // }

                $report->update([
                    'status' => 'submitted',
                    'submitted_at' => now(),
                    'approved_at' => null,
                ]);
            });

            return response()->json([
                'success' => 1,
                'message' => 'Daily report submitted successfully.',
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * View own report details.
     */
    public function show($id)
    {
        try {
            $staff = $this->staff();

            if (!$staff || !$staff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $report = $this->reportForStaff($id, $staff);

            $report->load([
                'staff:id,name,mobile',
                'activities.lead',
                'reviews',
            ]);

            return response()->json([
                'success' => 1,
                'message' => 'Daily report fetched successfully.',
                'data' => $report,
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to fetch report.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Manager: list reports from staff members added by this login.
     */
    public function teamReports(Request $request)
    {
        try {
            $staff = $this->staff();

            if (!$staff || !$staff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $reports = StaffDailyReport::with([
                'staff:id,name,mobile,designation_id,added_by,added_by_type',
                'staff.designation:id,name,slug',
                'activities',
                'reviews',
            ])
                ->where('hospital_id', $staff->hospital_id)
                ->whereHas('staff', function ($query) use ($staff) {
                    $query->where('added_by', $staff->id)
                        ->where('added_by_type', 'staff');
                })
                ->when($request->filled('status'), function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->when($request->filled('report_date'), function ($query) use ($request) {
                    $query->whereDate('report_date', $request->report_date);
                })
                ->latest('report_date')
                ->paginate(15);

            return response()->json([
                'success' => 1,
                'message' => 'Team daily reports fetched successfully.',
                'data' => $reports,
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to fetch team reports.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Manager: view one report submitted by their staff member.
     */
    public function teamReportShow($id)
    {
        try {
            $staff = $this->staff();

            if (!$staff || !$staff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $report = StaffDailyReport::with([
                'staff:id,name,mobile,designation_id,added_by,added_by_type',
                'staff.designation:id,name,slug',
                'activities.lead',
                'reviews',
            ])
                ->where('hospital_id', $staff->hospital_id)
                ->whereHas('staff', function ($query) use ($staff) {
                    $query->where('added_by', $staff->id)
                        ->where('added_by_type', 'staff');
                })
                ->findOrFail($id);

            return response()->json([
                'success' => 1,
                'message' => 'Team report fetched successfully.',
                'data' => $report,
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to fetch team report.',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Manager: approve or request revision.
     */
    public function managerReview(Request $request, $id)
    {
        try {
            $staff = $this->staff();

            if (!$staff || !$staff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'status' => [
                    'required',
                    Rule::in(['approved', 'revision_requested']),
                ],
                'remarks' => [
                    Rule::requiredIf($request->status === 'revision_requested'),
                    'nullable',
                    'string',
                ],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $report = StaffDailyReport::where('hospital_id', $staff->hospital_id)
                ->whereHas('staff', function ($query) use ($staff) {
                    $query->where('added_by', $staff->id)
                        ->where('added_by_type', 'staff');
                })
                ->findOrFail($id);

            if ($report->status !== 'submitted') {
                return response()->json([
                    'success' => 0,
                    'message' => 'Only submitted reports can be reviewed.',
                ], 422);
            }

            $review = StaffDailyReportReview::where('hospital_id', $staff->hospital_id)
                ->where('staff_daily_report_id', $report->id)
                ->where('reviewer_id', $staff->id)
                ->where('reviewer_type', 'staff')
                ->firstOrFail();

            if ($review->status !== 'pending') {
                return response()->json([
                    'success' => 0,
                    'message' => 'You have already reviewed this report.',
                ], 422);
            }

            $this->saveReview($report, $review, $validator->validated());

            return response()->json([
                'success' => 1,
                'message' => 'Manager review saved successfully.',
                'data' => $report->fresh(['reviews']),
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to review report.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update review and calculate overall report status.
     */
    private function saveReview($report, $review, array $data): void
    {
        DB::transaction(function () use ($report, $review, $data) {
            $review->update([
                'status' => $data['status'],
                'remarks' => $data['remarks'] ?? null,
                'reviewed_at' => now(),
            ]);

            if ($data['status'] === 'revision_requested') {
                $report->update([
                    'status' => 'revision_requested',
                    'approved_at' => null,
                ]);

                return;
            }

            $reviews = $report->reviews()->get();

            if (
                $reviews->count() === 2 &&
                $reviews->every(fn($item) => $item->status === 'approved')
            ) {
                $report->update([
                    'status' => 'approved',
                    'approved_at' => now(),
                ]);
            }
        });
    }
}
