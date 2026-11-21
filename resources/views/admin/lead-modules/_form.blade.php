
@php
    $isEdit = isset($leadModule);
@endphp

<div class="card">
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Module Name <span class="text-danger">*</span></label>
            <input type="text"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $leadModule->name ?? '') }}"
                   placeholder="Enter module name"
                   required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Module Slug</label>
            <input type="text"
                   name="slug"
                   class="form-control @error('slug') is-invalid @enderror"
                   value="{{ old('slug', $leadModule->slug ?? '') }}"
                   placeholder="Example: doctor">
            <small class="text-muted">Leave blank to generate from the module name.</small>
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       class="form-check-input"
                       id="is_active"
                       {{ old('is_active', $leadModule->is_active ?? 1) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.lead-modules.index') }}" class="btn btn-light">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                {{ $isEdit ? 'Update Module' : 'Create Module' }}
            </button>
        </div>

    </div>
</div>
