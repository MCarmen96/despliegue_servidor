

<?php $__env->startSection('content'); ?>
<section class="d-flex align-items-center justify-content-center py-5" style="min-height:80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-8 col-md-7 col-lg-5 col-xl-5">

                <div class="card card-pe shadow-lg border-0">
                    
                    <div class="card-body text-center pt-5 pb-3 px-4" style="background:var(--pe-primary-light); border-bottom:1px solid rgba(0,0,0,0.05);">
                        <img src="<?php echo e(asset('logo.png')); ?>" alt="Logo IES Prieto" height="70" class="rounded-3 mb-3 shadow-sm">
                        <h4 class="fw-800 mb-1" style="color:var(--pe-primary);">Crea tu cuenta</h4>
                        <p class="text-secondary small mb-0 fw-500">Regístrate para reservar tu menú diario</p>
                    </div>

                    
                    <div class="card-body p-4 pt-4">
                        <form method="POST" action="<?php echo e(route('register')); ?>">
                            <?php echo csrf_field(); ?>

                            
                            <div class="mb-3">
                                <label for="regName" class="form-label fw-700 small text-uppercase text-secondary">
                                    <i class="bi bi-person me-1"></i>Nombre completo
                                </label>
                                <input type="text" name="name" id="regName" value="<?php echo e(old('name')); ?>" required
                                       class="form-control form-control-lg bg-light border-0 rounded-3 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="Tu nombre" autofocus>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="mb-3">
                                <label for="regEmail" class="form-label fw-700 small text-uppercase text-secondary">
                                    <i class="bi bi-envelope me-1"></i>Correo electrónico
                                </label>
                                <input type="email" name="email" id="regEmail" value="<?php echo e(old('email')); ?>" required
                                       class="form-control form-control-lg bg-light border-0 rounded-3 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="nombre@ejemplo.com">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="mb-3">
                                <label for="regPassword" class="form-label fw-700 small text-uppercase text-secondary">
                                    <i class="bi bi-lock me-1"></i>Contraseña
                                </label>
                                <input type="password" name="password" id="regPassword" required
                                       class="form-control form-control-lg bg-light border-0 rounded-3 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="Mínimo 8 caracteres">
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="mb-4">
                                <label for="regPasswordConfirm" class="form-label fw-700 small text-uppercase text-secondary">
                                    <i class="bi bi-lock-fill me-1"></i>Confirmar Contraseña
                                </label>
                                <input type="password" name="password_confirmation" id="regPasswordConfirm" required
                                       class="form-control form-control-lg bg-light border-0 rounded-3"
                                       placeholder="Repite tu contraseña">
                            </div>

                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-pe-primary btn-lg rounded-pill fw-bold py-2 shadow-sm">
                                    <i class="bi bi-person-plus me-2"></i>Crear mi cuenta
                                </button>
                            </div>
                        </form>

                        
                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="text-muted small mb-0">¿Ya tienes cuenta?
                                <a href="<?php echo e(route('login')); ?>" class="fw-bold text-decoration-none" style="color:var(--pe-primary);">
                                    Inicia sesión aquí
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ReposDAW2\prieto_eats\resources\views/auth/registerBoost.blade.php ENDPATH**/ ?>