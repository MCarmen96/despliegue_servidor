@extends('layouts.layout')

@section('content')
<section class="d-flex align-items-center justify-content-center py-5" style="min-height:80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-8 col-md-7 col-lg-5 col-xl-5">

                <div class="card card-pe shadow-lg border-0">
                    {{-- Header con logo --}}
                    <div class="card-body text-center pt-5 pb-3 px-4" style="background:var(--pe-primary-light); border-bottom:1px solid rgba(0,0,0,0.05);">
                        <img src="{{ asset('logo.png') }}" alt="Logo IES Prieto" height="70" class="rounded-3 mb-3 shadow-sm">
                        <h4 class="fw-800 mb-1" style="color:var(--pe-primary);">Crea tu cuenta</h4>
                        <p class="text-secondary small mb-0 fw-500">Regístrate para reservar tu menú diario</p>
                    </div>

                    {{-- Formulario --}}
                    <div class="card-body p-4 pt-4">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Nombre --}}
                            <div class="mb-3">
                                <label for="regName" class="form-label fw-700 small text-uppercase text-secondary">
                                    <i class="bi bi-person me-1"></i>Nombre completo
                                </label>
                                <input type="text" name="name" id="regName" value="{{ old('name') }}" required
                                       class="form-control form-control-lg bg-light border-0 rounded-3 @error('name') is-invalid @enderror"
                                       placeholder="Tu nombre" autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="regEmail" class="form-label fw-700 small text-uppercase text-secondary">
                                    <i class="bi bi-envelope me-1"></i>Correo electrónico
                                </label>
                                <input type="email" name="email" id="regEmail" value="{{ old('email') }}" required
                                       class="form-control form-control-lg bg-light border-0 rounded-3 @error('email') is-invalid @enderror"
                                       placeholder="nombre@ejemplo.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Contraseña --}}
                            <div class="mb-3">
                                <label for="regPassword" class="form-label fw-700 small text-uppercase text-secondary">
                                    <i class="bi bi-lock me-1"></i>Contraseña
                                </label>
                                <input type="password" name="password" id="regPassword" required
                                       class="form-control form-control-lg bg-light border-0 rounded-3 @error('password') is-invalid @enderror"
                                       placeholder="Mínimo 8 caracteres">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirmar Contraseña --}}
                            <div class="mb-4">
                                <label for="regPasswordConfirm" class="form-label fw-700 small text-uppercase text-secondary">
                                    <i class="bi bi-lock-fill me-1"></i>Confirmar Contraseña
                                </label>
                                <input type="password" name="password_confirmation" id="regPasswordConfirm" required
                                       class="form-control form-control-lg bg-light border-0 rounded-3"
                                       placeholder="Repite tu contraseña">
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-pe-primary btn-lg rounded-pill fw-bold py-2 shadow-sm">
                                    <i class="bi bi-person-plus me-2"></i>Crear mi cuenta
                                </button>
                            </div>
                        </form>

                        {{-- Link a login --}}
                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="text-muted small mb-0">¿Ya tienes cuenta?
                                <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color:var(--pe-primary);">
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
@endsection
