

<?php $__env->startSection('title', 'All Warehouses'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">All Warehouses</h4>
    <a href="<?php echo e(route('add.warehouse')); ?>" class="btn btn-primary">
        <i class="ri-add-line"></i> Add New Warehouse
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered text-center align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Region</th>
                    <th>Warehouse</th>
                    <th>Location</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key + 1); ?></td>
                    <td><?php echo e($warehouse->region->name ?? 'N/A'); ?></td>
                    <td><?php echo e($warehouse->warehouse); ?></td>
                    <td><?php echo e($warehouse->location); ?></td>
                    <td><?php echo e($warehouse->created_at?->format('d M Y') ?? '—'); ?></td>
                    <td>
                        <a href="<?php echo e(route('edit.warehouse', $warehouse->id)); ?>" class="btn btn-warning btn-sm"><i class="ri-edit-2-line"></i></a>
                        <a href="<?php echo e(route('delete.warehouse', $warehouse->id)); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this warehouse?')">
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

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\admin\warehouse\all_warehouse.blade.php ENDPATH**/ ?>