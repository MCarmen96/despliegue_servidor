

<?php $__env->startSection('content'); ?>
<div class="container mt-5 mb-5" style="min-height: 60vh;">

    
    <div class="d-flex align-items-center gap-2 mb-4">
        <div class="rounded-circle p-3 shadow-sm bg-white text-primary">
            <i class="bi bi-cart3 fs-3" style="color:var(--pe-primary);"></i>
        </div>
        <div>
            <h2 class="section-title mb-0">Mi <span class="accent">Carrito</span></h2>
            <p class="text-muted mb-0 small">Revisa tu pedido antes de confirmar</p>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card card-pe border-0 shadow-lg">
        <div class="card-body p-0">

            <?php if(empty($cart)): ?>
                
                <div class="text-center py-5 px-3">
                    <div class="mb-3" style="font-size:4rem; color:var(--pe-secondary); opacity:.2;">
                        <i class="bi bi-cart-x"></i>
                    </div>
                    <h4 class="fw-bold mb-2 text-dark">Tu carrito está vacío</h4>
                    <p class="text-muted mb-4">¡Echa un vistazo a nuestros menús para añadir algo rico!</p>
                    <a href="<?php echo e(url('/')); ?>" class="btn btn-pe-primary rounded-pill px-4 fw-bold shadow-sm">
                        <i class="bi bi-arrow-left me-1"></i>Ver nuestras Ofertas
                    </a>
                </div>

            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-pe align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Fecha Oferta</th>
                                <th>Imagen</th>
                                <th>Producto</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th class="text-center">Cantidad</th>
                                <th>Total</th>
                                <th class="text-center pe-4">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalAcumulado = 0; ?>

                            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offerId => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    // Obtenemos la oferta usando el ID
                                    $offer = $offersById[$offerId] ?? null;
                                ?>

                                <?php if($offer): ?>
                                    
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productOfferId => $qty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            // Buscamos el producto-oferta y su producto relacionado
                                            $po = $productOffersById[$productOfferId] ?? null;
                                            $prod = $po ? $po->product : null;
                                            
                                            // Calculamos subtotales
                                            $lineaTotal = 0;
                                            if ($prod) {
                                                $lineaTotal = $prod->price * (int)$qty;
                                                $totalAcumulado += $lineaTotal;
                                            }
                                        ?>

                                        <?php if($prod): ?>
                                            <tr>
                                                
                                                <td class="ps-4 align-middle">
                                                    <span class="badge rounded-pill px-3 py-2 fw-bold" style="background:var(--pe-primary-light); color:var(--pe-primary);">
                                                        <i class="bi bi-calendar3 me-1"></i><?php echo e($offer->date_delivery->format('d/m/Y')); ?>

                                                    </span>
                                                </td>

                                                
                                                <td>
                                                    <?php if($prod->image): ?>
                                                        <img src="<?php echo e(asset('storage/' . $prod->image)); ?>" width="72" height="72"
                                                             class="rounded-3 shadow-sm object-fit-cover" alt="<?php echo e($prod->name); ?>">
                                                    <?php else: ?>
                                                        <div class="rounded-3 shadow-sm bg-light d-flex align-items-center justify-content-center text-secondary" style="width:72px; height:72px;">
                                                            <i class="bi bi-image"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                
                                                
                                                <td class="fw-bold text-dark"><?php echo e($prod->name); ?></td>
                                                <td class="text-muted small"><?php echo e(Str::limit($prod->description, 50)); ?></td>
                                                
                                                
                                                <td class="fw-600"><?php echo e(number_format($prod->price, 2)); ?> €</td>

                                                
                                                <td class="text-center" style="width:140px;">
                                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                                        
                                                        <form action="<?php echo e(route('cart.decrease', $productOfferId)); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PUT'); ?>
                                                            <button class="btn btn-sm btn-light rounded-circle fw-bold shadow-sm"
                                                                    style="width:32px;height:32px;padding:0;"
                                                                    <?php echo e($qty <= 1 ? 'disabled' : ''); ?>>-</button>
                                                        </form>

                                                        <span class="px-2 fw-bold"><?php echo e($qty); ?></span>

                                                        
                                                        <form action="<?php echo e(route('cart.increase', $productOfferId)); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PUT'); ?>
                                                            <button class="btn btn-sm btn-light rounded-circle fw-bold shadow-sm"
                                                                    style="width:32px;height:32px;padding:0;">+</button>
                                                        </form>
                                                    </div>
                                                </td>

                                                
                                                <td class="fw-bold" style="color:var(--pe-primary);"><?php echo e(number_format($lineaTotal, 2)); ?> €</td>

                                                
                                                <td class="text-center pe-4">
                                                    <form action="<?php echo e(route('cart.remove', $productOfferId)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button class="btn btn-sm btn-link text-danger p-0">
                                                            <i class="bi bi-trash fs-5"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="6" class="text-end fw-bold text-uppercase ps-4 py-4 text-secondary">Total Pedido</td>
                                <td colspan="2" class="fw-800 py-4 pe-4" style="color:var(--pe-primary); font-size:1.5rem;">
                                    <?php echo e(number_format($totalAcumulado, 2)); ?> €
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 p-4 bg-white rounded-bottom-4">

                    <form action="<?php echo e(route('cart.clear')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-outline-danger rounded-pill fw-bold px-4">
                            <i class="bi bi-trash3 me-1"></i>Vaciar Carrito
                        </button>
                    </form>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?php echo e(url('/')); ?>" class="btn btn-light rounded-pill fw-bold px-4 text-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Seguir comprando
                        </a>
                        <form action="<?php echo e(route('cart.order')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-pe-primary rounded-pill fw-bold px-5 shadow-lg">
                                <i class="bi bi-bag-check me-1"></i>Confirmar pedido
                            </button>
                        </form>
                    </div>

                </div>
            <?php endif; ?>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ReposDAW2\prieto_eats\resources\views/cart/index.blade.php ENDPATH**/ ?>