

<?php $__env->startSection('content'); ?>
<div class="container py-5">

    
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo e(route('admin.products.index')); ?>" class="text-decoration-none text-secondary">
                    <i class="bi bi-grid me-1"></i>Productos
                </a>
            </li>
            <li class="breadcrumb-item active text-primary fw-semibold">Editar: <?php echo e($product->name); ?></li>
        </ol>
    </nav>

    <div class="mb-4">
        <h1 class="fw-bold mb-1 text-secondary">Editar <span class="text-primary">Producto</span></h1>
        <p class="text-muted">Modifica los datos del plato seleccionado</p>
    </div>

    <form action="<?php echo e(route('admin.products.update', $product)); ?>" method="POST" enctype="multipart/form-data" class="row g-4">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

        
        <div class="col-lg-8">
            <div class="card card-pe shadow-lg border-0 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 text-primary d-flex align-items-center">
                        <i class="bi bi-pencil-square me-2 fs-4"></i>Información del Plato
                    </h5>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Nombre del plato</label>
                        <input type="text" name="name" value="<?php echo e($product->name); ?>"
                               class="form-control form-control-lg bg-light border-0 rounded-3 shadow-sm <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Ej. Solomillo al Whisky">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Descripción del contenido</label>
                        <textarea name="description" rows="7"
                                  class="form-control bg-light border-0 rounded-3 shadow-sm <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  placeholder="Detalla los ingredientes..."><?php echo e(old('description', $product->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
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
        </div>

        
        <div class="col-lg-4">
            <div class="card card-pe mb-4 shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 text-primary d-flex align-items-center">
                        <i class="bi bi-tag me-2 fs-4"></i>Precio e Imagen
                    </h5>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Precio</label>
                        <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-0 text-muted"><i class="bi bi-currency-euro"></i></span>
                            <input type="number" step="0.01" name="price" value="<?php echo e($product->price); ?>"
                                   class="form-control form-control-lg bg-light border-0 <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="0.00">
                        </div>
                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1 fw-bold"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Imagen Actual</label>
                        <?php if($product->image): ?>
                            <div class="mb-3 position-relative">
                                <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="Imagen actual"
                                     class="img-thumbnail rounded-3 shadow-sm w-100 object-fit-cover" style="max-height: 200px;">
                                <div class="position-absolute bottom-0 start-0 w-100 p-2 bg-dark bg-opacity-50 text-white text-center rounded-bottom-3 small">
                                    Imagen actual
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="mb-3 p-4 bg-light rounded-3 text-center text-muted border border-dashed">
                                <i class="bi bi-image fs-1 opacity-25"></i>
                                <p class="small mb-0 mt-2">Sin imagen registrada</p>
                            </div>
                        <?php endif; ?>
                        
                        <label class="form-label small text-secondary fw-bold mt-2">Cambiar imagen</label>
                        <input type="file" name="image"
                               class="form-control bg-light border-0 rounded-3 shadow-sm <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i>Deja vacío para conservar la actual</div>
                        <?php $__errorArgs = ['image'];
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
                    <i class="bi bi-floppy me-1"></i>Actualizar Producto
                </button>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-light text-muted fw-semibold rounded-pill py-2">
                    <i class="bi bi-arrow-left me-1"></i>Cancelar y volver
                </a>
            </div>
        </div>

    </form>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ReposDAW2\prieto_eats\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>