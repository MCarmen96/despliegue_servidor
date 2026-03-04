

<?php $__env->startSection('content'); ?>
<div class="container mt-5 mb-5" style="min-height:60vh;">

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i><strong>¡Error!</strong> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session('exito')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle me-2"></i><?php echo e(session('exito')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card card-pe shadow-lg border-0">

        
        <div class="admin-card-header p-4 d-flex flex-wrap align-items-center justify-content-between gap-3 bg-white border-bottom">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle p-3 shadow-sm bg-light text-primary">
                    <i class="bi bi-grid fs-4 text-primary"></i>
                </div>
                <div>
                    <h3 class="fw-800 mb-0 text-dark">Gestión de Productos</h3>
                    <p class="mb-0 small text-secondary">Catálogo del menú del departamento</p>
                </div>
            </div>
            
            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-pe-primary rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-plus-lg me-1"></i>Nuevo Producto
            </a>
        </div>

        <div class="card-body p-0">
            <?php if(count($dishes) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-pe align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 text-secondary text-uppercase py-3">Imagen</th>
                                <th class="text-secondary text-uppercase py-3">Nombre del Plato</th>
                                <th class="text-secondary text-uppercase py-3">Precio</th>
                                <th class="text-secondary text-uppercase py-3 text-center">Editar</th>
                                <th class="text-secondary text-uppercase py-3 text-center pe-4">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $dishes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dish): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="ps-4 py-3">
                                    <?php if($dish->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $dish->image)); ?>" width="72" height="72"
                                             class="rounded-3 shadow-sm object-fit-cover" alt="<?php echo e($dish->name); ?>">
                                    <?php else: ?>
                                        <div class="rounded-3 shadow-sm bg-light d-flex align-items-center justify-content-center text-secondary" style="width:72px; height:72px;">
                                            <i class="bi bi-image fs-4"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3">
                                    <span class="fw-bold text-dark"><?php echo e($dish->name); ?></span>
                                </td>
                                <td class="py-3">
                                    <span class="badge rounded-pill bg-light text-dark border px-3 py-2 fw-bold"><?php echo e($dish->price); ?> €</span>
                                </td>
                                <td class="text-center py-3">
                                    <a href="<?php echo e(route('admin.products.edit', $dish->id)); ?>"
                                       class="btn btn-sm btn-light text-primary rounded-pill px-3 fw-bold border">
                                        <i class="bi bi-pencil me-1"></i>Editar
                                    </a>
                                </td>
                                <td class="text-center pe-4 py-3">
                                    <form action="<?php echo e(route('admin.products.destroy', $dish->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-link text-danger p-0 opacity-75 hover-opacity-100">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="mb-3" style="font-size:4rem; color:var(--pe-secondary); opacity:.1;">
                        <i class="bi bi-grid"></i>
                    </div>
                    <h4 class="fw-bold text-dark">No hay productos registrados</h4>
                    <p class="text-muted mb-4">Crea el primer plato del catálogo.</p>
                    <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-pe-primary rounded-pill px-4 fw-bold shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i>Crear Producto
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ReposDAW2\prieto_eats\resources\views/admin/products/index.blade.php ENDPATH**/ ?>