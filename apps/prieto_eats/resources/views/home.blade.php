@extends('layouts.layout')

@section('content')

<div class="container mt-5">

    <div class="text-center mb-5">
        <h2 class="section-title mb-2">Nuestras <span class="accent">Ofertas</span></h2>
        <p class="text-muted fw-500">Selecciona el día y elige tu plato favorito</p>
    </div>

    {{-- Pestañas de Fechas --}}
    <ul class="nav nav-pills justify-content-center flex-wrap mb-5" id="pills-tab" role="tablist">
        @foreach($offersByDate as $date => $offers)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $loop->first ? 'active' : '' }} shadow-sm"
                        id="tab-{{ $loop->index }}"
                        data-bs-toggle="pill"
                        data-bs-target="#content-{{ $loop->index }}"
                        type="button" role="tab">
                    <i class="bi bi-calendar-event me-2"></i>
                    {{ \Carbon\Carbon::parse($date)->translatedFormat('d F') }}
                </button>
            </li>
        @endforeach
    </ul>

    {{-- Contenido de pestañas --}}
    <div class="tab-content pb-5">
        @foreach($offersByDate as $date => $offers)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                 id="content-{{ $loop->index }}" role="tabpanel">

                <div class="row g-4">
                    @foreach($offers as $offer)
                        @foreach($offer->productsOffer as $item)
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-pe h-100">
                                    {{-- Imagen --}}
                                    <div class="position-relative overflow-hidden">
                                        <div style="height:240px; overflow:hidden;" class="bg-light d-flex align-items-center justify-content-center">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                                     class="card-img-top w-100 h-100"
                                                     style="object-fit:cover; transition: transform 0.5s;"
                                                     alt="{{ $item->product->name }}">
                                            @else
                                                <i class="bi bi-image text-secondary fs-1 opacity-25"></i>
                                            @endif
                                        </div>
                                        <span class="badge-price position-absolute top-0 end-0 m-3 shadow">
                                            {{ number_format($item->product->price, 2) }} €
                                        </span>
                                    </div>
                                    {{-- Body --}}
                                    <div class="card-body d-flex flex-column p-4">
                                        <h5 class="fw-800 mb-2 text-dark">
                                            {{ $item->product->name }}
                                        </h5>
                                        <p class="text-muted flex-grow-1 mb-4 small line-clamp-3">
                                            {{ $item->product->description }}
                                        </p>
                                        
                                        <div class="mt-auto">
                                            @auth
                                                <form action="{{ route('cart.add', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-pe-primary w-100 rounded-pill fw-bold py-2">
                                                        <i class="bi bi-cart-plus me-2"></i>Añadir
                                                    </button>
                                                </form>
                                            @endauth
                                            @guest
                                                <a href="{{ route('login') }}" class="btn btn-outline-dark w-100 rounded-pill fw-bold py-2">
                                                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesión
                                                </a>
                                            @endguest
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>

            </div>
        @endforeach
    </div>

</div>
@endsection
