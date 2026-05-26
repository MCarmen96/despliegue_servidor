

<footer class="footer-prieto pt-4 pb-3">
    <div class="container">
        <div class="row gy-3 align-items-center">

            {{-- Logo + nombre --}}
            <div class="col-12 col-md-6 d-flex align-items-center gap-3">
                @if(file_exists(public_path('logo.png')))
                    <img src="{{ asset('logo.png') }}" alt="Logo Instituto" height="40" class="rounded-2 flex-shrink-0">
                @endif
                <div class="lh-sm">
                    <p class="fw-bold fs-6 mb-0 text-dark">Prieto<span class="text-primary">Eats</span></p>
                    <p class="mb-0 text-muted small" style="font-size:.75rem;">Departamento de Cocina &middot; IES Prieto</p>
                </div>
            </div>

            {{-- Copyright --}}
            <div class="col-12 col-md-6 text-md-end">
                <p class="mb-0 text-muted" style="font-size:.75rem;">
                    &copy; {{ date('Y') }} IES Prieto. Todos los derechos reservados.
                </p>
            </div>

        </div>
    </div>
</footer>


