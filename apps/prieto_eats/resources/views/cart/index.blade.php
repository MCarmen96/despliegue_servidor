@extends('layouts.layout')

@section('content')
<div class="container mt-5 mb-5" style="min-height: 60vh;">

    {{-- Page header --}}
    <div class="d-flex align-items-center gap-2 mb-4">
        <div class="rounded-circle p-3 shadow-sm bg-white text-primary">
            <i class="bi bi-cart3 fs-3" style="color:var(--pe-primary);"></i>
        </div>
        <div>
            <h2 class="section-title mb-0">Mi <span class="accent">Carrito</span></h2>
            <p class="text-muted mb-0 small">Revisa tu pedido antes de confirmar</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-pe border-0 shadow-lg">
        <div class="card-body p-0">

            @if(empty($cart))
                {{-- Carrito vacío --}}
                <div class="text-center py-5 px-3">
                    <div class="mb-3" style="font-size:4rem; color:var(--pe-secondary); opacity:.2;">
                        <i class="bi bi-cart-x"></i>
                    </div>
                    <h4 class="fw-bold mb-2 text-dark">Tu carrito está vacío</h4>
                    <p class="text-muted mb-4">¡Echa un vistazo a nuestros menús para añadir algo rico!</p>
                    <a href="{{ url('/') }}" class="btn btn-pe-primary rounded-pill px-4 fw-bold shadow-sm">
                        <i class="bi bi-arrow-left me-1"></i>Ver nuestras Ofertas
                    </a>
                </div>

            @else
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
                            @php $totalAcumulado = 0; @endphp

                            @foreach($cart as $offerId => $items)
                                @php
                                    // Obtenemos la oferta usando el ID
                                    $offer = $offersById[$offerId] ?? null;
                                @endphp

                                @if($offer)
                                    {{-- Recorremos los productos de esta oferta --}}
                                    @foreach($items as $productOfferId => $qty)
                                        @php
                                            // Buscamos el producto-oferta y su producto relacionado
                                            $po = $productOffersById[$productOfferId] ?? null;
                                            $prod = $po ? $po->product : null;
                                            
                                            // Calculamos subtotales
                                            $lineaTotal = 0;
                                            if ($prod) {
                                                $lineaTotal = $prod->price * (int)$qty;
                                                $totalAcumulado += $lineaTotal;
                                            }
                                        @endphp

                                        @if($prod)
                                            <tr>
                                                {{-- Fecha de la oferta --}}
                                                <td class="ps-4 align-middle">
                                                    <span class="badge rounded-pill px-3 py-2 fw-bold" style="background:var(--pe-primary-light); color:var(--pe-primary);">
                                                        <i class="bi bi-calendar3 me-1"></i>{{ $offer->date_delivery->format('d/m/Y') }}
                                                    </span>
                                                </td>

                                                {{-- Imagen --}}
                                                <td>
                                                    @if($prod->image)
                                                        <img src="{{ asset('storage/' . $prod->image) }}" width="72" height="72"
                                                             class="rounded-3 shadow-sm object-fit-cover" alt="{{ $prod->name }}">
                                                    @else
                                                        <div class="rounded-3 shadow-sm bg-light d-flex align-items-center justify-content-center text-secondary" style="width:72px; height:72px;">
                                                            <i class="bi bi-image"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                
                                                {{-- Nombre y Descripción --}}
                                                <td class="fw-bold text-dark">{{ $prod->name }}</td>
                                                <td class="text-muted small">{{ Str::limit($prod->description, 50) }}</td>
                                                
                                                {{-- Precio Unitario --}}
                                                <td class="fw-600">{{ number_format($prod->price, 2) }} €</td>

                                                {{-- Cantidad --}}
                                                <td class="text-center" style="width:140px;">
                                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                                        {{-- Botón Restar --}}
                                                        <form action="{{ route('cart.decrease', $productOfferId) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button class="btn btn-sm btn-light rounded-circle fw-bold shadow-sm"
                                                                    style="width:32px;height:32px;padding:0;"
                                                                    {{ $qty <= 1 ? 'disabled' : '' }}>-</button>
                                                        </form>

                                                        <span class="px-2 fw-bold">{{ $qty }}</span>

                                                        {{-- Botón Sumar --}}
                                                        <form action="{{ route('cart.increase', $productOfferId) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button class="btn btn-sm btn-light rounded-circle fw-bold shadow-sm"
                                                                    style="width:32px;height:32px;padding:0;">+</button>
                                                        </form>
                                                    </div>
                                                </td>

                                                {{-- Total Linea --}}
                                                <td class="fw-bold" style="color:var(--pe-primary);">{{ number_format($lineaTotal, 2) }} €</td>

                                                {{-- Eliminar --}}
                                                <td class="text-center pe-4">
                                                    <form action="{{ route('cart.remove', $productOfferId) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-link text-danger p-0">
                                                            <i class="bi bi-trash fs-5"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="6" class="text-end fw-bold text-uppercase ps-4 py-4 text-secondary">Total Pedido</td>
                                <td colspan="2" class="fw-800 py-4 pe-4" style="color:var(--pe-primary); font-size:1.5rem;">
                                    {{ number_format($totalAcumulado, 2) }} €
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Actions --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 p-4 bg-white rounded-bottom-4">

                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger rounded-pill fw-bold px-4">
                            <i class="bi bi-trash3 me-1"></i>Vaciar Carrito
                        </button>
                    </form>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ url('/') }}" class="btn btn-light rounded-pill fw-bold px-4 text-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Seguir comprando
                        </a>
                        <form action="{{ route('cart.order') }}" method="POST">
                            @csrf
                            <button class="btn btn-pe-primary rounded-pill fw-bold px-5 shadow-lg">
                                <i class="bi bi-bag-check me-1"></i>Confirmar pedido
                            </button>
                        </form>
                    </div>

                </div>
            @endif

        </div>
    </div>

</div>
@endsection
