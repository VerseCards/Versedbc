<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Login')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('language-bar'); ?>
    <li class="nav-item ">
        <select name="language" id="language" class="language-dropdown btn btn-primary mr-2 my-2 me-2"
            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);"
            <?php $__currentLoopData = App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <option <?php if($lang == $code): ?> selected <?php endif; ?> value="<?php echo e(route('login', $code)); ?>"><?php echo e(Str::upper($language)); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
    </li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('custom-scripts'); ?>
    <?php if(env('RECAPTCHA_MODULE') == 'yes'): ?>
        <?php echo NoCaptcha::renderJs(); ?>

    <?php endif; ?>
    <script src="<?php echo e(asset('custom/libs/jquery/dist/jquery.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $("#loginForm").submit(function(e) {
                $("#saveBtn").attr("disabled", true);
                return true;
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php
    $logo = asset(Storage::url('uploads/logo/'));
    $company_logo = Utility::getValByName('company_logo');
?>
<?php $__env->startSection('content'); ?>
    <!-- [ auth-signup ] start -->
    <div class="card">
        <div class="row align-items-center">
            <div class="col-xl-6" >
                <div class="card-body" style="background: white;border-radius: 25px">
                    <div class="">
                        <h2 class="mb-3 f-w-600"><?php echo e(__('Login')); ?></h2>
                    </div>
                    <?php echo e(Form::open(['route' => 'login', 'method' => 'post', 'id' => 'loginForm', 'class' => 'login-form'])); ?>

                    <div class="">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Email')); ?></label>
                            <?php echo e(Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Enter Your Email'), 'style'=>'border: none;height: 55px;border-radius: 15px; border: 1px solid #ced4da'])); ?>

                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error invalid-email text-danger" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Password')); ?></label>
                            <?php echo e(Form::password('password', ['class' => 'form-control', 'placeholder' => __('Enter Your Password'), 'id' => 'input-password', 'style'=>'border: none;height: 55px;border-radius: 15px; border: 1px solid #ced4da'])); ?>




                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error invalid-password text-danger" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </div>
                        <?php if(Route::has('password.request')): ?>
                            <div class="form-group mb-4">
                                <a href="<?php echo e(route('password.request')); ?>"
                                    class="small text-dark   text-underline--dashed  border-primary">
                                    <?php echo e(__('Forgot Your Password?')); ?></a>
                            </div>
                        <?php endif; ?>

                        <?php if(env('RECAPTCHA_MODULE') == 'yes'): ?>
                            <div class="form-group col-lg-12 col-md-12 mt-3">
                                <?php echo NoCaptcha::display(); ?>

                                <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="small text-danger" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        <?php endif; ?>
                        <div class="d-grid">
                            <?php echo e(Form::submit(__('Login'), ['class' => 'btn btn-primary btn-block mt-2', 'id' => 'saveBtn', 'style' => 'border-radius:25px; height:55px'])); ?>

                        </div>
                        <?php echo e(Form::close()); ?>

                    </div>

                </div>
            </div>
            <div class="col-xl-6 img-card-side">
                <div class="auth-img-content">
                    <img src="" alt="" class="img-fluid">
                    <h3 class="text-white mb-4 mt-5">Climate Change is REAL</h3>
					<p class="text-white">"We are the first generation to feel the impact of climate change and the last generation that can do something about it - Barrack Obama."</p>
					 <p class="text-white">At FirstBank, We have taken a STAND.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- [ auth-signup ] end -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\versedbc\resources\views/auth/login.blade.php ENDPATH**/ ?>