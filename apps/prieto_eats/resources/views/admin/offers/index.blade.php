@extends('layouts.layout')

@section('content')
<div class="container py-5">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                <span class="fw-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-pe shadow-lg border-0 overflow-hidden">

        {{-- Card header --}}
        <div class="admin-card-header p-4 d-flex flex-wrap align-items-center justify-content-between gap-3 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle p-3 d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-tag fs-3"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 text-dark">Gestión de Ofertas</h3>
                    <p class="mb-0 text-muted small">Menús diarios y promociones disponibles</p>
                </div>
            </div>
            <a href="{{ route('admin.offers.create') }}" class="btn btn-primary fw-bold rounded-pill px-4 shadow-sm hover-scale text-white">
                <i class="bi bi-plus-lg me-1"></i>Nueva Oferta
            </a>
        </div>

        <div class="card-body p-0">
            @if(count($offers) > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold">Fecha</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Hora</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Producto</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Foto</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Descripción</th>
                                <th class="py-3 text-secondary text-uppercase small fw-bold">Precio</th>
                                <th class="text-center pe-4 py-3 text-secondary text-uppercase small fw-bold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offers as $offer)
                            <tr class="border-bottom-0">
                                <td class="ps-4">
                                    <span class="badge rounded-pill px-3 py-2 fw-bold text-bg-light border text-secondary">
                                        <i class="bi bi-calendar3 me-1 text-primary"></i>{{ $offer->date_delivery->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td class="fw-bold text-dark">
                                    <div class="d-flex align-items-center text-secondary">
                                        <i class="bi bi-clock me-2 text-warning"></i>
                                        {{ $offer->time_delivery }}
                                    </div>
                                </td>
                                
                                {{-- Assuming one product per offer row based on original code structure --}}
                                                        @foreach($offer->productsOffer as $prod)
                                    <td class="fw-bold text-dark">{{ $prod->product->name }}</td>
                                    <td>
                                        @if($prod->product->image)
                                            <img src="{{ asset('storage/' . $prod->product->image) }}" width="60" height="60"
                                                 class="rounded-3 shadow-sm object-fit-cover" alt="{{ $prod->product->name }}">
                                        @else
                                            <div class="rounded-3 shadow-sm bg-light d-flex align-items-center justify-content-center text-secondary" style="width:60px; height:60px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-muted small text-truncate" style="max-width: 200px;">
                                            {{ $prod->product->description }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success fw-bold px-3 py-2">
                                            {{ $prod->product->price }} €
                                        </span>
                                    </td>
                                @endforeach
                                
                                <td class="text-center pe-4">
                                    <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-circle p-2 d-inline-flex align-items-center justify-content-center shadow-sm hover-scale" 
                                                data-bs-toggle="tooltip" title="Eliminar oferta">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="rounded-circle bg-light d-inline-flex p-4 mb-3">
                        <i class="bi bi-inbox fs-1 text-muted opacity-50"></i>
                    </div>
                    <h4 class="fw-bold text-secondary">No hay ofertas registradas</h4>
                    <p class="text-muted mb-4">Comienza creando el menú del día.</p>
                    <a href="{{ route('admin.offers.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm hover-scale">
                        <i class="bi bi-plus-lg me-1"></i>Crear Primera Oferta
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection