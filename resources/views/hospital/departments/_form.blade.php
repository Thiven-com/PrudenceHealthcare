<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-sm-12 mb-3">
                <label class="form-label">Department Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $department->name ?? '') }}"
                    placeholder="Enter department name" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-lg-6 col-sm-12 mb-3">
                <label class="form-label">Department Code</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', $department->code ?? '') }}"
                    placeholder="Example: CARD">
                @error('code')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-lg-12 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"
                    placeholder="Enter department description">{{ old('description', $department->description ?? '') }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-lg-6 mb-3">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ old('is_active', $department->is_active ?? 1) == 1 ? 'selected' : '' }}>Active
                    </option>
                    <option value="0" {{ old('is_active', $department->is_active ?? 1) == 0 ? 'selected' : '' }}>Inactive
                    </option>
                </select>
            </div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">
                {{ isset($department) ? 'Update Department' : 'Save Department' }}
            </button>

            <a href="{{ route('hospital.departments.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </div>
</div>