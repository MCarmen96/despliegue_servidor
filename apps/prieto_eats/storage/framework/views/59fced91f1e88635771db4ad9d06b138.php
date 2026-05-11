

<?php $__env->startSection('content'); ?>
<div class="container py-5">

    <?php if($errors->any()): ?>
        <div class="alert alert-danger rounded-3 shadow-sm border-0 mb-4">
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-exclamation-octagon-fill fs-5 me-2"></i>
                <span class="fw-bold">Por favor corrige los siguientes errores:</span>
            </div>
            <ul class="mb-0 small">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo e(route('admin.offers.index')); ?>" class="text-decoration-none text-secondary">
                    <i class="bi bi-tag me-1"></i>Ofertas
                </a>
            </li>
            <li class="breadcrumb-item active text-primary fw-semibold">Nueva Oferta</li>
        </ol>
    </nav>

    <div class="mb-4">
        <h1 class="fw-bold mb-1 text-secondary">Registrar <span class="text-primary">Oferta</span></h1>
        <p class="text-muted">Configura la fecha, hora y los platos disponibles para el menú del día</p>
    </div>

    <form action="<?php echo e(route('admin.offers.store')); ?>" method="POST" class="row g-4">
        <?php echo csrf_field(); ?>

        
        <div class="col-lg-4">
            <div class="card card-pe shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 text-primary">
                        <i class="bi bi-calendar2-event me-2"></i>Detalles de Entrega
                    </h5>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Fecha de recogida</label>
                        <input type="date" name="date_delivery" value="<?php echo e(old('date_delivery')); ?>"
                               class="form-control form-control-lg bg-light border-0 rounded-3 shadow-sm <?php $__errorArgs = ['date_delivery'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['date_delivery'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Horario de recogida</label>
                        <input type="text" name="time_delivery" value="<?php echo e(old('time_delivery')); ?>"
                               class="form-control form-control-lg bg-light border-0 rounded-3 shadow-sm <?php $__errorArgs = ['time_delivery'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Ej. 13:30 - 14:30">
                        <?php $__errorArgs = ['time_delivery'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold py-3 shadow-sm hover-scale">
                    <i class="bi bi-floppy me-1"></i>Guardar Oferta
                </button>
                <a href="<?php echo e(route('admin.offers.index')); ?>" class="btn btn-light text-muted fw-semibold rounded-pill py-2">
                    <i class="bi bi-arrow-left me-1"></i>Cancelar y volver
                </a>
            </div>
        </div>

        
        <div class="col-lg-8">
            <div class="card card-pe shadow-lg border-0 overflow-hidden">
                <div class="admin-card-header p-4 d-flex align-items-center justify-content-between bg-white">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-check2-square me-2 text-primary"></i>Seleccionar Platos
                    </h5>
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary fw-bold px-3 py-2">
                        <?php echo e(count($dishes)); ?> disponibles
                    </span>
                </div>

                <div class="card-body p-0">
                    <?php if(count($dishes) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3" style="width:50px;"></th>
                                        <th class="py-3 text-secondary small fw-bold text-uppercase">Producto</th>
                                        <th class="py-3 text-secondary small fw-bold text-uppercase">Precio</th>
                                        <th class="py-3 text-end pe-4 text-secondary small fw-bold text-uppercase">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $dishes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dish): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="form-check">
                                                <input type="checkbox" name="dish_selected[]" value="<?php echo e($dish->id); ?>"
                                                       class="form-check-input border-2 border-secondary shadow-sm"
                                                       style="width:1.3em; height:1.3em; cursor:pointer;">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <?php if($dish->image): ?>
                                                    <img src="<?php echo e(asset('storage/' . $dish->image)); ?>" width="50" height="50"
                                                         class="rounded-3 shadow-sm object-fit-cover" alt="<?php echo e($dish->name); ?>">
                                                <?php else: ?>
                                                    <div class="rounded-3 shadow-sm bg-light d-flex align-items-center justify-content-center text-secondary" style="width:50px; height:50px;">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <span class="fw-bold text-dark"><?php echo e($dish->name); ?></span>
                                            </div>
                                        </td>
                                        <td><span class="fw-bold text-secondary"><?php echo e(number_format($dish->price, 2)); ?> €</span></td>
                                        <td class="text-end pe-4">
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-1 fw-bold">
                                                <i class="bi bi-check-circle-fill me-1"></i>Activo
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-grid fs-1 opacity-25 mb-3"></i>
                            <p class="mb-0 fw-semibold">No hay productos disponibles para añadir.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php $__errorArgs = ['dish_selected'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="alert alert-danger d-flex align-items-center mt-3 rounded-3 border-0 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div><?php echo e($message); ?></div>
                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

    </form>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ReposDAW2\prieto_eats\resources\views/admin/offers/create.blade.php ENDPATH**/ ?>