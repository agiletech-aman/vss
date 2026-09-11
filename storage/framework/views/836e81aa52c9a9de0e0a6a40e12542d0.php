<?php $__env->startSection('content'); ?>
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Create User</h4>
        <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary">
            Back
        </a>
    </div>

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <strong>Validation Error:</strong>
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">

            <form method="POST" action="<?php echo e(route('users.store')); ?>" id="userForm">
                <?php echo csrf_field(); ?>

                
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input class="form-control"
                           name="name"
                           value="<?php echo e(old('name')); ?>"
                           required>
                </div>

                
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control"
                           name="email"
                           type="email"
                           value="<?php echo e(old('email')); ?>"
                           required>
                </div>

                
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control"
                           name="password"
                           type="password"
                           required>
                </div>

                
                <div class="mb-4">
                    <label class="form-label fw-bold">Assign Roles</label>

                    <div class="row">
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            
                            <?php if($role->name !== 'superadmin'): ?>

                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input role-checkbox"
                                               type="checkbox"
                                               name="roles[]"
                                               value="<?php echo e($role->name); ?>"
                                               id="role_<?php echo e($role->id); ?>"
                                               <?php echo e(in_array($role->name, old('roles', [])) ? 'checked' : ''); ?>>

                                        <label class="form-check-label" for="role_<?php echo e($role->id); ?>">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $role->name))); ?>

                                        </label>
                                    </div>
                                </div>

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                
                <div class="mb-3" id="region-container" style="display: none;">
                    <label class="form-label fw-bold">
                        Assign Region
                        <span class="text-danger" id="region-required">*</span>
                    </label>
                    <select class="form-select" name="region_id" id="region_id">
                        <option value="">-- Select Region --</option>
                        <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($region->id); ?>" <?php echo e(old('region_id') == $region->id ? 'selected' : ''); ?>>
                                <?php echo e($region->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <small class="text-muted">Required for Region Officers</small>
                </div>

                
                <div class="mb-3" id="warehouse-container" style="display: none;">
                    <label class="form-label fw-bold">
                        Assign Warehouse
                        <span class="text-danger" id="warehouse-required">*</span>
                    </label>
                    <select class="form-select" name="warehouse_id" id="warehouse_id">
                        <option value="">-- Select Warehouse --</option>
                        <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($warehouse->id); ?>"
        data-region="<?php echo e($warehouse->region_id); ?>">
    <?php echo e($warehouse->warehouse ?? $warehouse->name ?? 'Unknown'); ?> (<?php echo e($warehouse->region->name ?? 'Unknown Region'); ?>)
</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <small class="text-muted">Required for Warehouse Officers</small>
                </div>

                
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        Direct Permissions (Optional)
                    </label>

                    <div class="row">
                        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="permissions[]"
                                           value="<?php echo e($permission->name); ?>"
                                           id="perm_<?php echo e($permission->id); ?>"
                                           <?php echo e(in_array($permission->name, old('permissions', [])) ? 'checked' : ''); ?>>

                                    <label class="form-check-label" for="perm_<?php echo e($permission->id); ?>">
                                        <?php echo e($permission->name); ?>

                                    </label>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\admin\users\create.blade.php ENDPATH**/ ?>