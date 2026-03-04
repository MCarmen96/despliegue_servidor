@extends('layouts.layout')

@section('content')
<div class="container py-5">

    @if ($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm border-0 mb-4">
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-exclamation-octagon-fill fs-5 me-2"></i>
                <span class="fw-bold">Por favor corrige los siguientes errores:</span>
            </div>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.offers.index') }}" class="text-decoration-none text-secondary">
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

    <form action="{{ route('admin.offers.store') }}" method="POST" class="row g-4">
        @csrf

        {{-- Columna izquierda: Detalles de entrega + botón --}}
        <div class="col-lg-4">
            <div class="card card-pe shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 text-primary">
                        <i class="bi bi-calendar2-event me-2"></i>Detalles de Entrega
                    </h5>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Fecha de recogida</label>
                        <input type="date" name="date_delivery" value="{{ old('date_delivery') }}"
                               class="form-control form-control-lg bg-light border-0 rounded-3 shadow-sm @error('date_delivery') is-invalid @enderror">
                        @error('date_delivery') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Horario de recogida</label>
                        <input type="text" name="time_delivery" value="{{ old('time_delivery') }}"
                               class="form-control form-control-lg bg-light border-0 rounded-3 shadow-sm @error('time_delivery') is-invalid @enderror"
                               placeholder="Ej. 13:30 - 14:30">
                        @error('time_delivery') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold py-3 shadow-sm hover-scale">
                    <i class="bi bi-floppy me-1"></i>Guardar Oferta
                </button>
                <a href="{{ route('admin.offers.index') }}" class="btn btn-light text-muted fw-semibold rounded-pill py-2">
                    <i class="bi bi-arrow-left me-1"></i>Cancelar y volver
                </a>
            </div>
        </div>

        {{-- Columna derecha: Selector de platos --}}
        <div class="col-lg-8">
            <div class="card card-pe shadow-lg border-0 overflow-hidden">
                <div class="admin-card-header p-4 d-flex align-items-center justify-content-between bg-white">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-check2-square me-2 text-primary"></i>Seleccionar Platos
                    </h5>
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary fw-bold px-3 py-2">
                        {{ count($dishes) }} disponibles
                    </span>
                </div>

                <div class="card-body p-0">
                    @if(count($dishes) > 0)
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
                                    @foreach($dishes as $dish)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="form-check">
                                                <input type="checkbox" name="dish_selected[]" value="{{ $dish->id }}"
                                                       class="form-check-input border-2 border-secondary shadow-sm"
                                                       style="width:1.3em; height:1.3em; cursor:pointer;">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                @if($dish->image)
                                                    <img src="{{ asset('storage/' . $dish->image) }}" width="50" height="50"
                                                         class="rounded-3 shadow-sm object-fit-cover" alt="{{ $dish->name }}">
                                                @else
                                                    <div class="rounded-3 shadow-sm bg-light d-flex align-items-center justify-content-center text-secondary" style="width:50px; height:50px;">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                @endif
                                                <span class="fw-bold text-dark">{{ $dish->name }}</span>
                                            </div>
                                        </td>
                                        <td><span class="fw-bold text-secondary">{{ number_format($dish->price, 2) }} €</span></td>
                                        <td class="text-end pe-4">
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-1 fw-bold">
                                                <i class="bi bi-check-circle-fill me-1"></i>Activo
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-grid fs-1 opacity-25 mb-3"></i>
                            <p class="mb-0 fw-semibold">No hay productos disponibles para añadir.</p>
                        </div>
                    @endif
                </div>
            </div>
            @error('dish_selected')
                <div class="alert alert-danger d-flex align-items-center mt-3 rounded-3 border-0 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>{{ $message }}</div>
                </div>
            @enderror
        </div>

    </form>

</div>
@endsection