
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-sm-12 mb-3">
                <label class="form-label">Department <span class="text-danger">*</span></label>
                <select name="department_id" class="form-select" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}"
                            {{ old('department_id', $designation->department_id ?? '') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-lg-6 col-sm-12 mb-3">
                <label class="form-label">Designation Name <span class="text-danger">*</span></label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name', $designation->name ?? '') }}"
                       placeholder="Enter designation name"
                       required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-lg-6 col-sm-12 mb-3">
                <label class="form-label">Designation Code</label>
                <input type="text"
                       name="code"
                       class="form-control"
                       value="{{ old('code', $designation->code ?? '') }}"
                       placeholder="Example: SRDOC">
                @error('code')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-lg-12 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description"
                          class="form-control"
                          rows="4"
                          placeholder="Enter designation description">{{ old('description', $designation->description ?? '') }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-lg-6 mb-3">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ old('is_active', $designation->is_active ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $designation->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">
                {{ isset($designation) ? 'Update Designation' : 'Save Designation' }}
            </button>

            <a href="{{ route('hospital.designations.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </div>
</div>
