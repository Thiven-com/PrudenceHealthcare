<?php

namespace App\Http\Controllers\StaffApp;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\LeadFollowUp;
use App\Models\PerformanceTarget;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PerformanceController extends Controller
{
    public function index(): JsonResponse
    {
        $staff = Auth::guard('staff')->user();

        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $today = Carbon::today();

        // Get active targets for this staff member's designation and hospital.
        // NULL start_date/end_date are allowed.
        $targets = PerformanceTarget::where('status', 'active')
            ->where('designation_id', $staff->designation_id)
            ->where(function ($query) use ($staff) {
                $query->whereNull('hospital_id')
                    ->orWhere('hospital_id', $staff->hospital_id);
            })
            ->where(function ($query) use ($today) {
                $query->whereNull('start_date')
                    ->orWhereDate('start_date', '<=', $today);
            })
            ->where(function ($query) use ($today) {
                $query->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', $today);
            })
            ->orderByDesc('id')
            ->get();

        $performance = [];

        foreach ($targets as $target) {
            [$startDate, $endDate] = $this->getPeriodDates(
                $target->target_period,
                $today
            );

            // Restrict the period to the target's configured dates, when present.
            if ($target->start_date) {
                $targetStart = Carbon::parse($target->start_date)->startOfDay();

                if ($targetStart->greaterThan($startDate)) {
                    $startDate = $targetStart;
                }
            }

            if ($target->end_date) {
                $targetEnd = Carbon::parse($target->end_date)->endOfDay();

                if ($targetEnd->lessThan($endDate)) {
                    $endDate = $targetEnd;
                }
            }

            $achieved = $this->getAchievedCount(
                $target->target_type,
                $staff,
                $startDate,
                $endDate
            );

            $targetQuantity = (int) ($target->target_quantity ?? 0);

            $performance[] = [
                'target_id'       => $target->id,
                'task'             => $target->target_name,
                'target_type'      => $target->target_type,
                'target_period'    => $target->target_period,
                'target'            => $targetQuantity,
                'achieved'          => $achieved,
                'remaining'         => max($targetQuantity - $achieved, 0),
                'percentage'        => $targetQuantity > 0
                    ? round(($achieved / $targetQuantity) * 100, 2)
                    : 0,
                'period_start'      => $startDate->toDateString(),
                'period_end'        => $endDate->toDateString(),
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Task vs performance fetched successfully.',
            'data' => [
                'staff_id'       => $staff->id,
                'designation_id' => $staff->designation_id,
                'hospital_id'    => $staff->hospital_id,
                'performance'    => $performance,
            ],
        ]);
    }

    private function getPeriodDates(?string $period, Carbon $date): array
    {
        switch (strtolower($period ?? 'monthly')) {
            case 'daily':
                return [
                    $date->copy()->startOfDay(),
                    $date->copy()->endOfDay(),
                ];

            case 'weekly':
                return [
                    $date->copy()->startOfWeek(),
                    $date->copy()->endOfWeek(),
                ];

            case 'monthly':
            default:
                return [
                    $date->copy()->startOfMonth(),
                    $date->copy()->endOfMonth(),
                ];
        }
    }

    private function getAchievedCount(
        ?string $targetType,
        $staff,
        Carbon $startDate,
        Carbon $endDate
    ): int {
        $staffId = $staff->id;
        $hospitalId = $staff->hospital_id;

        // Supports "staff" or the staff model's class name in type columns.
        $staffTypes = ['staff', get_class($staff)];

        switch ($targetType) {
            case 'lead_generation':
                return Lead::where('hospital_id', $hospitalId)
                    ->where('created_by', $staffId)
                    ->whereIn('created_by_type', $staffTypes)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count();

            case 'follow_ups':
                return LeadFollowUp::where('hospital_id', $hospitalId)
                    ->where('followed_up_by', $staffId)
                    ->whereIn('followed_up_by_type', $staffTypes)
                    ->whereBetween('follow_up_date', [$startDate, $endDate])
                    ->whereIn('follow_up_status', ['completed', 'done'])
                    ->count();

            case 'conversions':
                return Lead::where('hospital_id', $hospitalId)
                    ->where('created_by', $staffId)
                    ->whereIn('created_by_type', $staffTypes)
                    ->whereNotNull('converted_at')
                    ->whereBetween('converted_at', [$startDate, $endDate])
                    ->count();

            case 'customer_calls':
                return $this->countActivities(
                    $staffId,
                    $staffTypes,
                    $hospitalId,
                    ['call', 'customer_call'],
                    $startDate,
                    $endDate
                );

            case 'hospital_visits':
                return $this->countActivities(
                    $staffId,
                    $staffTypes,
                    $hospitalId,
                    ['visit', 'hospital_visit'],
                    $startDate,
                    $endDate
                );

            case 'meetings':
                return $this->countActivities(
                    $staffId,
                    $staffTypes,
                    $hospitalId,
                    ['meeting'],
                    $startDate,
                    $endDate
                );

            default:
                return 0;
        }
    }

    private function countActivities(
        int $staffId,
        array $staffTypes,
        ?int $hospitalId,
        array $activityTypes,
        Carbon $startDate,
        Carbon $endDate
    ): int {
        return LeadActivity::where('hospital_id', $hospitalId)
            ->where('performed_by', $staffId)
            ->whereIn('performed_by_type', $staffTypes)
            ->whereIn('activity_type', $activityTypes)
            ->whereBetween('performed_at', [$startDate, $endDate])
            ->count();
    }
}