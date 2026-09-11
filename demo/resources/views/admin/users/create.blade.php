@extends('layout.master')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Create User</h4>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    {{-- Success / Error Messages --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Validation Error:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <form method="POST" action="{{ route('users.store') }}" id="userForm">
                @csrf

                {{-- NAME --}}
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input class="form-control"
                           name="name"
                           value="{{ old('name') }}"
                           required>
                </div>

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control"
                           name="email"
                           type="email"
                           value="{{ old('email') }}"
                           required>
                </div>

                {{-- PASSWORD --}}
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control"
                           name="password"
                           type="password"
                           required>
                </div>

                {{-- ROLES --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Assign Roles</label>

                    <div class="row">
                        @foreach($roles as $role)

                            {{-- Hide SuperAdmin role --}}
                            @if($role->name !== 'superadmin')

                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input role-checkbox"
                                               type="checkbox"
                                               name="roles[]"
                                               value="{{ $role->name }}"
                                               id="role_{{ $role->id }}"
                                               {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="role_{{ $role->id }}">
                                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                        </label>
                                    </div>
                                </div>

                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- REGION SELECTION (for Region Officers) --}}
                <div class="mb-3" id="region-container" style="display: none;">
                    <label class="form-label fw-bold">
                        Assign Region
                        <span class="text-danger" id="region-required">*</span>
                    </label>
                    <select class="form-select" name="region_id" id="region_id">
                        <option value="">-- Select Region --</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Required for Region Officers</small>
                </div>

                {{-- WAREHOUSE SELECTION (for Warehouse Officers) --}}
                <div class="mb-3" id="warehouse-container" style="display: none;">
                    <label class="form-label fw-bold">
                        Assign Warehouse
                        <span class="text-danger" id="warehouse-required">*</span>
                    </label>
                    <select class="form-select" name="warehouse_id" id="warehouse_id">
                        <option value="">-- Select Warehouse --</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}"
        data-region="{{ $warehouse->region_id }}">
    {{ $warehouse->warehouse ?? $warehouse->name ?? 'Unknown' }} ({{ $warehouse->region->name ?? 'Unknown Region' }})
</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Required for Warehouse Officers</small>
                </div>

                {{-- DIRECT PERMISSIONS --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        Direct Permissions (Optional)
                    </label>

                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="permissions[]"
                                           value="{{ $permission->name }}"
                                           id="perm_{{ $permission->id }}"
                                           {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>

                                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="text-end">
                    <button class="btn btn-success px-4">
                        Create User
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleCheckboxes = document.querySelectorAll('.role-checkbox');
    const regionContainer = document.getElementById('region-container');
    const warehouseContainer = document.getElementById('warehouse-container');
    const regionSelect = document.getElementById('region_id');
    const warehouseSelect = document.getElementById('warehouse_id');

    function updateVisibility() {
        const checkedRoles = Array.from(roleCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        // Show region field if Region Officer is selected
        if (checkedRoles.includes('region_officer')) {
            regionContainer.style.display = 'block';
        } else {
            regionContainer.style.display = 'none';
            regionSelect.value = '';
        }

        // Show warehouse field if Warehouse Officer is selected
        if (checkedRoles.includes('warehouse_officer')) {
            warehouseContainer.style.display = 'block';
        } else {
            warehouseContainer.style.display = 'none';
            warehouseSelect.value = '';
        }
    }

    // Filter warehouses by region
    regionSelect.addEventListener('change', function() {
        const selectedRegion = this.value;
        const options = warehouseSelect.querySelectorAll('option');

        options.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
                return;
            }

            const warehouseRegion = option.getAttribute('data-region');
            if (!selectedRegion || warehouseRegion === selectedRegion) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });

        // Reset warehouse selection if it doesn't match region
        const currentWarehouse = warehouseSelect.querySelector('option:checked');
        if (currentWarehouse && currentWarehouse.getAttribute('data-region') !== selectedRegion && selectedRegion !== '') {
            warehouseSelect.value = '';
        }
    });

    roleCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateVisibility);
    });

    // Initial check
    updateVisibility();
});
</script>

@endsection
