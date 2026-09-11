

<?php $__env->startSection('title', 'Add Region'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Add New Region</h4>
    <a href="<?php echo e(route('all.region')); ?>" class="btn btn-dark">
        <i class="ri-arrow-go-back-line"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?php echo e(route('store.region')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label">Region Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter region name" required>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="ri-check-line"></i> Save Region
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\admin\region\add_region.blade.php ENDPATH**/ ?>