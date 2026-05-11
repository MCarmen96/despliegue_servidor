
<?php $__env->startSection('content'); ?>
<div class="container mt-5 mb-5" style="min-height: 60vh;">

    
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-5">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle p-3 shadow-sm bg-white text-primary">
                <i class="bi bi-receipt fs-3" style="color:var(--pe-primary);"></i>
            </div>
            <div>
                <h2 class="section-title mb-0">Mis <span class="accent">Pedidos</span></h2>
                <p class="text-muted mb-0 small">Historial de tus reservas de menú</p>
            </div>
        </div>
        <a href="<?php echo e(url('/')); ?>" class="btn btn-outline-secondary rounded-pill fw-bold px-4">
            <i class="bi bi-arrow-left me-1"></i>Volver a la tienda
        </a>
    </div>

    <?php if($orders->count() > 0): ?>
        <div class="accordion shadow-sm border-0" id="accordionOrders" style="border-radius:16px; overflow:hidden;">
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header" id="heading<?php echo e($order->id); ?>">
                        <button class="accordion-button collapsed fw-600 py-4 bg-white" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse<?php echo e($order->id); ?>"
                                aria-expanded="false"
                                aria-controls="collapse<?php echo e($order->id); ?>">
                            <div class="d-flex w-100 justify-content-between align-items-center me-3 flex-wrap gap-3">
                                <span class="d-flex align-items-center gap-3">
                                    <span class="rounded-pill px-3 py-1 d-inline-flex align-items-center justify-content-center shadow-sm"
                                          style="background:var(--pe-primary-light);color:var(--pe-primary);font-weight:700;font-size:.85rem;">
                                        #<?php echo e($order->id); ?>

                                    </span>
                                    <span class="text-secondary small fw-500">
                                        <i class="bi bi-clock me-1"></i><?php echo e($order->created_at->format('d/m/Y H:i')); ?>

                                    </span>
                                </span>
                                <span class="fw-800 text-dark" style="font-size:1.1rem;">
                                    <?php echo e(number_format($order->total, 2)); ?> €
                                </span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse<?php echo e($order->id); ?>"
                         class="accordion-collapse collapse"
                         aria-labelledby="heading<?php echo e($order->id); ?>"
                         data-bs-parent="#accordionOrders">
                        <div class="accordion-body p-0 bg-light">
                            <table class="table table-borderless align-middle mb-0">
                                <thead>
                                    <tr class="border-bottom">
                                        <th class="ps-4 text-secondary text-uppercase py-3" style="font-size:0.75rem;">Producto</th>
                                        <th class="text-center text-secondary text-uppercase py-3" style="font-size:0.75rem;">Cantidad</th>
                                        <th class="text-end text-secondary text-uppercase py-3" style="font-size:0.75rem;">Precio Unit.</th>
                                        <th class="text-end pe-4 text-secondary text-uppercase py-3" style="font-size:0.75rem;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $order->order_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            // Obtenemos el producto real a través del productOffer
                                            $productOffer = $item->productOffer; 
                                            // En tu código actual, ProductOrder se relaciona con ProductOffer, y este con Product
                                            $product = $productOffer ? $productOffer->product : null;
                                            
                                            // Precio unitario del producto en ese momento (o actual si no se guardó historial de precios)
                                            $price = $product ? $product->price : 0;
                                            $subtotal = $price * $item->quantity;
                                        ?>
                                        
                                        <?php if($product): ?>
                                            <tr class="border-bottom border-light">
                                                <td class="ps-4 fw-600 text-dark py-3">
                                                    <?php echo e($product->name); ?>

                                                </td>
                                                <td class="text-center py-3">
                                                    <span class="badge rounded-pill px-3 py-1 bg-white border shadow-sm text-dark"><?php echo e($item->quantity); ?></span>
                                                </td>
                                                <td class="text-end py-3 text-secondary"><?php echo e(number_format($price, 2)); ?> €</td>
                                                <td class="text-end pe-4 fw-700 py-3" style="color:var(--pe-primary);">
                                                    <?php echo e(number_format($subtotal, 2)); ?> €
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <div class="mb-3" style="font-size:4rem; color:var(--pe-secondary); opacity:.1;">
                <i class="bi bi-bag-x"></i>
            </div>
            <h4 class="fw-bold text-dark">Todavía no has realizado ningún pedido</h4>
            <p class="text-muted mb-4">¡Echa un vistazo a nuestros menús del día!</p>
            <a href="<?php echo e(url('/')); ?>" class="btn btn-pe-primary rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-arrow-left me-1"></i>Ver Ofertas
            </a>
        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ReposDAW2\prieto_eats\resources\views/cart/orders.blade.php ENDPATH**/ ?>