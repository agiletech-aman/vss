

<?php $__env->startSection('title', 'Add Warehouse'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Add New Warehouse</h4>
    <a href="<?php echo e(route('all.warehouse')); ?>" class="btn btn-dark">
        <i class="ri-arrow-go-back-line"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?php echo e(route('store.warehouse')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Select Region</label>
                    <select name="region_id" class="form-control" required>
                        <option value="">-- Select Region --</option>
                        <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($region->id); ?>"><?php echo e($region->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Warehouse Name</label>
                    <input type="text" name="warehouse" class="form-control" placeholder="Enter warehouse name" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" placeholder="Enter warehouse location" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success"><i class="ri-check-line"></i> Save Warehouse</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\admin\warehouse\add_warehouse.blade.php ENDPATH**/ ?>