<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top py-3 shadow-sm custom-navbar">
    <div class="container">
        
        
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo e(route('home')); ?>">
            <?php if(file_exists(public_path('logo.png'))): ?>
                <img src="<?php echo e(asset('logo.png')); ?>" alt="Prieto Eats" height="40" class="rounded-3 shadow-sm">
            <?php else: ?>
                <div class="rounded-3 bg-gradient-primary d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width:40px; height:40px;">
                    PE
                </div>
            <?php endif; ?>
            <div class="lh-1">
                <div class="fw-bold fs-5 text-dark tracking-tight">Prieto<span class="text-primary">Eats</span></div>
                <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">IES Prieto</div>
            </div>
        </a>

        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        
        <div class="collapse navbar-collapse" id="navMain">
            
            
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-semibold">
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo e(request()->routeIs('home') ? 'active text-primary' : ''); ?>" href="<?php echo e(route('home')); ?>">
                        Inicio
                    </a>
                </li>
                
            </ul>

            
            <div class="d-flex align-items-center gap-3">
                <?php if(auth()->guard()->check()): ?>
                    
                    <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-light position-relative rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm text-secondary hover-scale" style="width: 40px; height: 40px;">
                        <i class="bi bi-cart3 fs-5"></i>
                        <?php if(session()->has('cart') && count(session('cart')) > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        <?php endif; ?>
                    </a>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle ps-2" data-bs-toggle="dropdown">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold text-uppercase" style="width: 40px; height: 40px;">
                                <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                            </div>
                            <div class="d-none d-lg-block text-start lh-1">
                                <div class="fw-bold text-dark small"><?php echo e(Auth::user()->name); ?></div>
                                <div class="text-muted" style="font-size: 0.7rem;"><?php echo e(Auth::user()->isAdmin() ? 'Administrador' : 'Cliente'); ?></div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3 mt-3 animate-slide-in p-2" style="min-width: 220px;">
                            <li>
                                <div class="d-flex align-items-center gap-2 p-2 border-bottom mb-2">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-secondary" style="width: 32px; height: 32px;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small text-dark"><?php echo e(Auth::user()->name); ?></div>
                                        <div class="text-muted small text-truncate" style="max-width: 120px;"><?php echo e(Auth::user()->email); ?></div>
                                    </div>
                                </div>
                            </li>
                            
                            
                            <?php if(Auth::user()->isAdmin()): ?>
                                <li><h6 class="dropdown-header text-uppercase small fw-bold mt-2">Gestión</h6></li>
                                <li>
                                    <a class="dropdown-item rounded-2 py-2" href="<?php echo e(route('admin.products.index')); ?>">
                                        <i class="bi bi-grid me-2 text-primary"></i>Productos
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item rounded-2 py-2" href="<?php echo e(route('admin.offers.index')); ?>">
                                        <i class="bi bi-tag me-2 text-primary"></i>Ofertas
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-2"></li>
                            <?php endif; ?>

                            
                            <li>
                                <a class="dropdown-item rounded-2 py-2" href="<?php echo e(route('cart.orders')); ?>">
                                    <i class="bi bi-receipt me-2 text-secondary"></i>Mis Pedidos
                                </a>
                            </li>

                            <li><hr class="dropdown-divider my-2"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item rounded-2 py-2 text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                <?php else: ?>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Entrar</a>
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm hover-scale">Registrarse</a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</nav>
<?php /**PATH C:\ReposDAW2\prieto_eats\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>