<?php $__env->startSection('content'); ?>
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">User Management</h4>

        <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary">
            + Create User
        </a>
    </div>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div><?php echo e($error); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="20%">Name</th>
                            <th width="20%">Email</th>
                            <th width="15%">Roles</th>
                            <th width="20%">Assignment</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->email); ?></td>

                                
                                <td>
                                    <?php $__empty_2 = true; $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>

                                        <?php if($role->name === 'superadmin'): ?>
                                            <span class="badge bg-danger">
                                                SuperAdmin
                                            </span>

                                        <?php elseif($role->name === 'admin'): ?>
                                            <span class="badge bg-warning text-dark">
                                                Admin
                                            </span>

                                        <?php elseif($role->name === 'region_officer'): ?>
                                            <span class="badge bg-purple text-white" style="background-color: #6f42c1;">
                                                Region Officer
                                            </span>

                                        <?php elseif($role->name === 'warehouse_officer'): ?>
                                            <span class="badge bg-info text-white">
                                                Warehouse Officer
                                            </span>

                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $role->name))); ?>

                                            </span>
                                        <?php endif; ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span class="text-muted">No Role</span>
                                    <?php endif; ?>
                                </td>

                                
                                <td>
                                    <?php if($user->hasRole('region_officer') && $user->region): ?>
                                        <small class="text-muted d-block">Region:</small>
                                        <strong><?php echo e($user->region->name); ?></strong>
                                    <?php elseif($user->hasRole('warehouse_officer') && $user->warehouse): ?>
                                        <small class="text-muted d-block">Warehouse:</small>
                                        <strong><?php echo e($user->warehouse->name); ?></strong>
                                        <br>
                                        <small class="text-muted">(<?php echo e($user->warehouse->region->name); ?>)</small>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                
                                <td>

                                    
                                    <?php if($user->hasRole('superadmin')): ?>

                                        <span class="badge bg-secondary">
                                            Protected
                                        </span>

                                    <?php else: ?>

                                        
                                        <a href="<?php echo e(route('users.edit', $user->id)); ?>"
                                           class="btn btn-sm btn-warning me-1">
                                            Edit
                                        </a>

                                        
                                        <?php if(auth()->id() !== $user->id): ?>

                                            <form action="<?php echo e(route('users.destroy', $user->id)); ?>"
                                                  method="POST"
                                                  style="display:inline-block;"
                                                  onsubmit="return confirm('Are you sure you want to delete this user?')">

                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>

                                        <?php else: ?>
                                            <span class="text-muted small">
                                                (You)
                                            </span>
                                        <?php endif; ?>

                                    <?php endif; ?>

                                </td>
                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No users found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\ATS\vss\resources\views\admin\users\index.blade.php ENDPATH**/ ?>