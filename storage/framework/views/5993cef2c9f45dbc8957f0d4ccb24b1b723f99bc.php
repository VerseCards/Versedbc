<?php
	$users = \Auth::user();
    $cardLogo = \App\Models\Utility::get_file('card_logo/');
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('All Business Cards')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('All Business Cards')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <?php if($users->type == 'techsupport'): ?>
        <div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-between justify-content-md-end"
            data-bs-placement="top">
            <a href="#" data-size="xl" data-url="<?php echo e(route('business.create')); ?>" data-ajax-popup="true"
                data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create New Business')); ?>"
                class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i>
            </a>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('#')); ?></th>
                                <th><?php echo e(__('Profile Picture')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Created')); ?></th>
                                <th class="text-end"><?php echo e(__('Operations')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $business; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->index + 1); ?></td>
                                    <td>
                                        <div class="avatar">
                                            
                                            <img style="width: 55px;height: 55px;" class="rounded-circle "
                                                src="<?php echo e(isset($val->logo) && !empty($val->logo) ? $cardLogo.'/'.$val->logo : asset('custom/img/logo-placeholder-image-21.png')); ?>"
                                                alt="">
                                        </div>
                                    </td>

                                    <td class="">
                                        <a class=""
                                            href="<?php echo e(route('business.edit', $val->id)); ?>"><b><?php echo e(ucFirst($val->title)); ?></b></a>
                                    </td>
                                    <td><span
                                            class="badge fix_badge <?php if($val->status == 'locked'): ?> bg-danger <?php else: ?> bg-info <?php endif; ?> p-2 px-3 rounded"><?php echo e(ucFirst($val->status)); ?></span>
                                    </td>
                                    <?php
                                        $now = $val->created_at;
                                        $date = $now->format('Y-m-d');
                                        $time = $now->format('H:i:s');
                                    ?>
                                    <td><?php echo e($val->created_at); ?></td>

                                    <td class="text-end">
                                        <?php if($val->status != 'lock'): ?>
										<button type="button" class="btn"
											data-bs-toggle="dropdown" aria-haspopup="true"
											aria-expanded="false">
											<i class="feather icon-more-vertical"></i>
										</button>
									<div class="dropdown-menu dropdown-menu-end">
                                    
                                    
									<a href="<?php echo e(route('business.edit', $val->id)); ?>"
                                            class="dropdown-item user-drop">
                                            <i class="ti ti-edit"></i>
                                            <span class="ml-2"> <?php echo e(__('Edit Card Details')); ?></span>
                                        </a>
									
										<a href="<?php echo e(route('business.analytics', $val->id)); ?>"
                                            class="dropdown-item user-drop">
                                            <i class="ti ti-brand-google-analytics"></i>
                                            <span class="ml-2"> <?php echo e(__('View Analytics')); ?></span>
                                        </a>
									
									
										<a href="<?php echo e(route('business.contacts.show', $val->id)); ?>"
                                            class="dropdown-item user-drop">
                                            <i class="ti ti-phone"></i>
                                            <span class="ml-2"> <?php echo e(__('View Contacts')); ?></span>
                                        </a>
										
										
									
									
										<a href="<?php echo e(route('appointment.calendar', $val->id)); ?>"
                                            class="dropdown-item user-drop">
                                            <i class="ti ti-calendar"></i>
                                            <span class="ml-2"> <?php echo e(__('My Calender')); ?></span>
                                        </a>
									
										
									
									
									<a href="#"
                                            class="dropdown-item user-drop cp_link" data-link="<?php echo e(url('/' . $val->slug)); ?>" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Click to copy card link')); ?>">
                                            <i class="ti ti-copy"></i>
                                            <span class="ml-2"> <?php echo e(__('Copy Link')); ?></span>
                                        </a>
									
									<?php if($users->type == 'techsupport'): ?>
                                        <a href="#" class="bs-pass-para dropdown-item user-drop"  data-confirm="<?php echo e(__('Are You Sure?')); ?>" data-text="<?php echo e(__('This action will delete all business card details permanently. Continue?')); ?>" data-confirm-yes="delete-form-<?php echo e($val->id); ?>" title="<?php echo e(__('Delete')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"><i class="ti ti-trash"></i><span class="ml-2"><?php echo e(__('Delete')); ?></span></a>
										
										<?php echo Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['business.destroy', $val->id],
                                                    'id' => 'delete-form-' . $val->id,
                                                ]); ?>

                                                <?php echo Form::close(); ?>

                                    <?php else: ?>
                                                <span class="edit-icon align-middle bg-gray"><i
                                                        class="fas fa-lock text-white"></i></span>
                                    <?php endif; ?>
                                                
                                <?php endif; ?>
                            </div>
                                            
                                            
                                            
                                        
                                      
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
<?php $__env->startPush('custom-scripts'); ?>
    <script type="text/javascript">
        $('.cp_link').on('click', function() {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            toastrs('<?php echo e(__('Success')); ?>', '<?php echo e(__('Link Copy on Clipboard')); ?>', 'success');
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cloveafr/versedbc.clove.africa/resources/views/business/index.blade.php ENDPATH**/ ?>