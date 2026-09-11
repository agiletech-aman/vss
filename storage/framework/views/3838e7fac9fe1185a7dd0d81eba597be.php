

<?php $__env->startSection('title', 'Fire / Smoke / Rodent Alerts'); ?>

<?php $__env->startSection('content'); ?>

<h4 class="fw-bold mb-3">Fire / Smoke / Rodent – Camera Summary</h4>

<!-- FILTER -->
<form method="GET" class="row g-2 mb-3 align-items-center">

    <!-- LOCATION -->
    <div class="col-md-4">
        <input type="text"
               name="location"
               class="form-control"
               placeholder="Search by Location"
               value="<?php echo e(request('location')); ?>">
    </div>

    <!-- FILTER -->
    <div class="col-md-2">
        <button class="btn btn-primary w-100">
            Filter
        </button>
    </div>

    <!-- RESET -->
    <div class="col-md-2">
        <a href="<?php echo e(route('alerts.camera.alerts')); ?>"
           class="btn btn-outline-secondary w-100">
            Reset
        </a>
    </div>

</form>

<div class="text-muted mb-2">
    Showing <?php echo e($alerts->count()); ?> of <?php echo e($total); ?> records
</div>

<!-- TABLE -->
<div class="card">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="min-width:200px;">Location</th>
                        <th style="width:140px;">Total Cameras</th>
                        <th style="width:120px;" class="text-danger">🔥 Fire</th>
                        <th style="width:120px;" class="text-warning">💨 Smoke</th>
                        <th style="width:120px;" class="text-success">🐀 Rodent</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($row['location'] ?? '-'); ?></td>

                            <td class="fw-semibold">
                                <?php echo e($row['totalCameraCount'] ?? 0); ?>

                            </td>

                            <td>
                                <span class="badge bg-danger">
                                    <?php echo e($row['fireCount'] ?? 0); ?>

                                </span>
                            </td>

                            <td>
                                <span class="badge bg-warning text-dark">
                                    <?php echo e($row['smokeCount'] ?? 0); ?>

                                </span>
                            </td>

                            <td>
                                <span class="badge bg-success">
                                    <?php echo e($row['rodentCount'] ?? 0); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No alert data found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- PAGINATION -->
<div class="mt-3">
    <?php echo e($alerts->appends(request()->query())->links('pagination::simple-bootstrap-5')); ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\alerts\camera_alerts.blade.php ENDPATH**/ ?>