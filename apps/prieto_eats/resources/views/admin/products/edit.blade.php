@extends('layouts.layout')

@section('content')
<div class="container py-5">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.products.index') }}" class="text-decoration-none text-secondary">
                    <i class="bi bi-grid me-1"></i>Productos
                </a>
            </li>
            <li class="breadcrumb-item active text-primary fw-semibold">Editar: {{ $product->name }}</li>
        </ol>
    </nav>

    <div class="mb-4">
        <h1 class="fw-bold mb-1 text-secondary">Editar <span class="text-primary">Producto</span></h1>
        <p class="text-muted">Modifica los datos del plato seleccionado</p>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="row g-4">
    @csrf
    @method('PUT')

        {{-- Columna izquierda: Información --}}
        <div class="col-lg-8">
            <div class="card card-pe shadow-lg border-0 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 text-primary d-flex align-items-center">
                        <i class="bi bi-pencil-square me-2 fs-4"></i>Información del Plato
                    </h5>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Nombre del plato</label>
                        <input type="text" name="name" value="{{ $product->name }}"
                               class="form-control form-control-lg bg-light border-0 rounded-3 shadow-sm @error('name') is-invalid @enderror"
                               placeholder="Ej. Solomillo al Whisky">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Descripción del contenido</label>
                        <textarea name="description" rows="7"
                                  class="form-control bg-light border-0 rounded-3 shadow-sm @error('description') is-invalid @enderror"
                                  placeholder="Detalla los ingredientes...">{{ old('description', $product->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Columna derecha --}}
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
                            <input type="number" step="0.01" name="price" value="{{ $product->price }}"
                                   class="form-control form-control-lg bg-light border-0 @error('price') is-invalid @enderror"
                                   placeholder="0.00">
                        </div>
                        @error('price') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Imagen Actual</label>
                        @if($product->image)
                            <div class="mb-3 position-relative">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen actual"
                                     class="img-thumbnail rounded-3 shadow-sm w-100 object-fit-cover" style="max-height: 200px;">
                                <div class="position-absolute bottom-0 start-0 w-100 p-2 bg-dark bg-opacity-50 text-white text-center rounded-bottom-3 small">
                                    Imagen actual
                                </div>
                            </div>
                        @else
                            <div class="mb-3 p-4 bg-light rounded-3 text-center text-muted border border-dashed">
                                <i class="bi bi-image fs-1 opacity-25"></i>
                                <p class="small mb-0 mt-2">Sin imagen registrada</p>
                            </div>
                        @endif
                        
                        <label class="form-label small text-secondary fw-bold mt-2">Cambiar imagen</label>
                        <input type="file" name="image"
                               class="form-control bg-light border-0 rounded-3 shadow-sm @error('image') is-invalid @enderror">
                        <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i>Deja vacío para conservar la actual</div>
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold py-3 shadow-sm hover-scale">
                    <i class="bi bi-floppy me-1"></i>Actualizar Producto
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light text-muted fw-semibold rounded-pill py-2">
                    <i class="bi bi-arrow-left me-1"></i>Cancelar y volver
                </a>
            </div>
        </div>

    </form>

</div>
@endsection