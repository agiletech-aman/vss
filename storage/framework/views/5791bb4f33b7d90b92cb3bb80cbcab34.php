

<?php $__env->startSection('title', 'All Regions'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">All Regions</h4>
    <a href="<?php echo e(route('add.region')); ?>" class="btn btn-primary">
        <i class="ri-add-line align-middle me-1"></i> Add New Region
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Region Name</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key + 1); ?></td>
                    <td><?php echo e($region->name); ?></td>
                    <td><?php echo e($region->created_at?->format('d M Y') ?? '—'); ?></td>
                    <td>
                        <a href="<?php echo e(route('edit.region', $region->id)); ?>" class="btn btn-warning btn-sm">
                            <i class="ri-edit-2-line"></i>
                        </a>
                        <a href="<?php echo e(route('delete.region', $region->id)); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this region?')">
                            <i class="ri-delete-bin-line"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\admin\region\all_region.blade.php ENDPATH**/ ?>