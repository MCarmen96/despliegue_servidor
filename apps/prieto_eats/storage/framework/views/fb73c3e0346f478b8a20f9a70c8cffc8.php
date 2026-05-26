

<?php $__env->startSection('content'); ?>

<div class="container mt-5">

    <div class="text-center mb-5">
        <h2 class="section-title mb-2">Nuestras <span class="accent">Ofertas</span></h2>
        <p class="text-muted fw-500">Selecciona el día y elige tu plato favorito</p>
    </div>

    
    <ul class="nav nav-pills justify-content-center flex-wrap mb-5" id="pills-tab" role="tablist">
        <?php $__currentLoopData = $offersByDate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $offers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo e($loop->first ? 'active' : ''); ?> shadow-sm"
                        id="tab-<?php echo e($loop->index); ?>"
                        data-bs-toggle="pill"
                        data-bs-target="#content-<?php echo e($loop->index); ?>"
                        type="button" role="tab">
                    <i class="bi bi-calendar-event me-2"></i>
                    <?php echo e(\Carbon\Carbon::parse($date)->translatedFormat('d F')); ?>

                </button>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    
    <div class="tab-content pb-5">
        <?php $__currentLoopData = $offersByDate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $offers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?>"
                 id="content-<?php echo e($loop->index); ?>" role="tabpanel">

                <div class="row g-4">
                    <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $offer->productsOffer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-pe h-100">
                                    
                                    <div class="position-relative overflow-hidden">
                                        <div style="height:240px; overflow:hidden;" class="bg-light d-flex align-items-center justify-content-center">
                                            <?php if($item->product->image): ?>
                                                <img src="<?php echo e(asset('storage/' . $item->product->image)); ?>"
                                                     class="card-img-top w-100 h-100"
                                                     style="object-fit:cover; transition: transform 0.5s;"
                                                     alt="<?php echo e($item->product->name); ?>">
                                            <?php else: ?>
                                                <i class="bi bi-image text-secondary fs-1 opacity-25"></i>
                                            <?php endif; ?>
                                        </div>
                                        <span class="badge-price position-absolute top-0 end-0 m-3 shadow">
                                            <?php echo e(number_format($item->product->price, 2)); ?> €
                                        </span>
                                    </div>
                                    
                                    <div class="card-body d-flex flex-column p-4">
                                        <h5 class="fw-800 mb-2 text-dark">
                                            <?php echo e($item->product->name); ?>

                                        </h5>
                                        <p class="text-muted flex-grow-1 mb-4 small line-clamp-3">
                                            <?php echo e($item->product->description); ?>

                                        </p>
                                        
                                        <div class="mt-auto">
                                            <?php if(auth()->guard()->check()): ?>
                                                <form action="<?php echo e(route('cart.add', $item->id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-pe-primary w-100 rounded-pill fw-bold py-2">
                                                        <i class="bi bi-cart-plus me-2"></i>Añadir
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <?php if(auth()->guard()->guest()): ?>
                                                <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-dark w-100 rounded-pill fw-bold py-2">
                                                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesión
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ReposDAW2\prieto_eats\resources\views/home.blade.php ENDPATH**/ ?>