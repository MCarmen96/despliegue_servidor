@extends('layouts.layout')

@section('content')
<section class="d-flex align-items-center justify-content-center py-5" style="min-height:80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">

                <div class="card card-pe shadow-lg border-0">
                    {{-- Header con logo --}}
                    <div class="card-body text-center pt-5 pb-3 px-4" style="background:var(--pe-primary-light); border-bottom:1px solid rgba(0,0,0,0.05);">
                        <img src="{{ asset('logo.png') }}" alt="Logo IES Prieto" height="70" class="rounded-3 mb-3 shadow-sm">
                        <h4 class="fw-800 mb-1" style="color:var(--pe-primary);">Bienvenido</h4>
                        <p class="text-secondary small mb-0 fw-500">Inicia sesión en Prieto Eats</p>
                    </div>

                    {{-- Formulario --}}
                    <div class="card-body p-4 pt-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label fw-700 small text-uppercase text-secondary">
                                    <i class="bi bi-envelope me-1"></i>Correo electrónico
                                </label>
                                <input type="email" name="email" id="loginEmail" value="{{ old('email') }}"
                                       class="form-control form-control-lg bg-light border-0 rounded-3 @error('email') is-invalid @enderror"
                                       placeholder="nombre@ejemplo.com" autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label fw-700 small text-uppercase text-secondary">
                                    <i class="bi bi-lock me-1"></i>Contraseña
                                </label>
                                <input type="password" name="password" id="loginPassword"
                                       class="form-control form-control-lg bg-light border-0 rounded-3 @error('password') is-invalid @enderror"
                                       placeholder="Tu contraseña">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Remember + Forgot --}}
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe"
                                           style="accent-color:var(--pe-primary);">
                                    <label class="form-check-label small text-secondary" for="rememberMe">Recuérdame</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="small fw-600 text-decoration-none" style="color:var(--pe-accent);">
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                @endif
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-pe-primary btn-lg rounded-pill fw-bold py-2 shadow-sm">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                                </button>
                            </div>
                        </form>

                        {{-- Link a registro --}}
                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="text-muted small mb-0">¿No tienes cuenta?
                                <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color:var(--pe-primary);">
                                    ¡Regístrate gratis!
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
