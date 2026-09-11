

<?php $__env->startSection('title', 'Edit Warehouse'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-title-box d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Edit Warehouse</h4>
    <a href="<?php echo e(route('all.warehouse')); ?>" class="btn btn-dark">
        <i class="ri-arrow-go-back-line me-1"></i> Back
    </a>
</div>

<div class="card shadow">
    <div class="card-body">

        <form action="<?php echo e(route('update.warehouse', $warehouse->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="row">

                <!-- Region -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Region</label>
                    <select name="region_id" class="form-select" required>
                        <option value="">-- Select Region --</option>

                        <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($region->id); ?>"
                                <?php echo e($warehouse->region_id == $region->id ? 'selected' : ''); ?>>
                                <?php echo e($region->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Location -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control"
                           value="<?php echo e($warehouse->location); ?>" required>
                </div>

                <!-- Warehouse Name -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Warehouse Name</label>
                    <input type="text" name="warehouse" class="form-control"
                           value="<?php echo e($warehouse->warehouse); ?>" required>
                </div>

            </div>

            <button type="submit" class="btn btn-primary mt-3">
                Update Warehouse
            </button>

        </form>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\admin\warehouse\edit_warehouse.blade.php ENDPATH**/ ?>