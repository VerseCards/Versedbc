<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('NFC History')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('NFC History')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
        <div class=" mt-2 " id="multiCollapseExample1" style="">
            <div class="card">
                <div class="card-body">
                    <?php echo e(Form::open(['route' => ['loadTaps'], 'method' => 'get', 'id' => 'userlog_filter'])); ?>

                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                <?php echo e(Form::label('month', __('Month'), ['class' => 'form-label'])); ?>

                                <input type="month" name="month" class="form-control" value="<?php echo e(isset($_GET['month']) ? $_GET['month'] : ''); ?>" placeholder ="">
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">
                                <?php echo e(Form::label('user', __('User'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::select('user', $userList, isset($_GET['user']) ? $_GET['user'] : '', ['class' => 'form-control select ', 'id' => 'employee_id'])); ?>

                            </div>
                        </div>
                        <div class="col-auto float-end ms-2 mt-4">
                            <a href="#" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('userlog_filter').submit(); return false;"
                                data-bs-toggle="tooltip" title="" data-bs-original-title="apply">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="<?php echo e(route('userlogs.index')); ?>" class="btn btn-sm btn-danger"
                                data-bs-toggle="tooltip" title="" data-bs-original-title="Reset">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                            </a>
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style ">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <th>#</th>
                            <th><?php echo e(__('Business Card')); ?> </th>
                           
							<th><?php echo e(__('OS Name')); ?> </th>
                            <th><?php echo e(__('Browser')); ?> </th>
							<th><?php echo e(__('Date')); ?> </th>
                            
                           
                            <th width="200px"><?php echo e(__('Action')); ?> </th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $userlogdetail->reverse(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userlogs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                            <tr>
                                <td><?php echo e($loop->index + 1); ?></td>
                                <td><?php echo e($userlogs->url); ?></td>
                               
                                <td><?php echo e($userlogs->platform); ?></td>
                                <td><?php echo e($userlogs->browser); ?></td>
                                <td><?php echo e($userlogs->created_at); ?></td>
                                <td>
                                    
                                    <div class="action-btn bg-danger ms-2">
                                        <a href="#" class="bs-pass-para mx-3 btn btn-sm d-inline-flex align-items-center" data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="delete-form-<?php echo e($userlogs->id); ?>"
                                        title="<?php echo e(__('Delete')); ?>" data-bs-toggle="tooltip"
                                        data-bs-placement="top"><span class="text-white"><i
                                                class="ti ti-trash"></i></span></a>
                                    </div>
                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['userlogs.destroy', $userlogs->id],'id'=>'delete-form-'.$userlogs->id]); ?>

                                    <?php echo Form::close(); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\versedbc\resources\views/tap_history/index.blade.php ENDPATH**/ ?>