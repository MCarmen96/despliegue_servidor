<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <title>Prieto Eats </title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Modern Vibrant Palette */
            --pe-primary:       #f97316; /* Modern Orange */
            --pe-primary-dark:  #ea580c;
            --pe-primary-light: #ffedd5;
            
            --pe-secondary:     #1e293b; /* Slate 800 */
            --pe-secondary-light: #f1f5f9;
            --pe-text:          #334155;
            
            --pe-bg:            #f8fafc; /* Very light slate */
            --pe-card-bg:       #ffffff;
            
            --pe-accent:        #eab308; /* Yellow-500 */
            
            /* Bootstrap overrides */
            --bs-primary:       #f97316;
            --bs-primary-rgb:   249, 115, 22;
            --bs-body-bg:       #f8fafc;
        }

        body {
            font-family: 'Poppins', 'Nunito', sans-serif;
            background-color: var(--pe-bg);
            color: var(--pe-text);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .navbar-prieto {
            background-color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
        .navbar-prieto .navbar-brand {
            font-weight: 800;
            color: var(--pe-primary) !important;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }
        .navbar-prieto .navbar-brand span {
            color: var(--pe-secondary);
        }
        .navbar-prieto .nav-link {
            color: var(--pe-secondary) !important;
            font-weight: 600;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            margin: 0 4px;
            transition: all 0.2s ease;
        }
        .navbar-prieto .nav-link:hover,
        .navbar-prieto .nav-link.active {
            color: var(--pe-primary) !important;
            background-color: var(--pe-primary-light);
        }
        .navbar-prieto .navbar-toggler {
            border: none;
            padding: 0.25rem 0.5rem;
        }
        .navbar-prieto .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23334155' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .navbar-prieto .dropdown-menu {
            border: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            padding: 0.5rem;
            margin-top: 10px;
        }
        .navbar-prieto .dropdown-item {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            color: var(--pe-text);
        }
        .navbar-prieto .dropdown-item:hover {
            background-color: var(--pe-primary-light);
            color: var(--pe-primary);
        }

        /* Cart badge pill */
        .cart-link {
            background-color: var(--pe-primary);
            color: #fff !important;
            border-radius: 9999px;
            padding: 6px 16px !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.3);
            transition: transform 0.2s, background-color 0.2s;
        }
        .cart-link:hover {
            background-color: var(--pe-primary-dark);
            transform: translateY(-2px);
        }

        /* ── Buttons ── */
        .btn-pe-primary {
            background-color: var(--pe-primary);
            color: #fff;
            border: none;
            padding: 0.6rem 1.4rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s;
            box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.3);
        }
        .btn-pe-primary:hover {
            background-color: var(--pe-primary-dark);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(249, 115, 22, 0.4);
        }

        .btn-pe-accent {
            background-color: var(--pe-secondary);
            color: #fff;
            border: none;
            padding: 0.6rem 1.4rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-pe-accent:hover {
            background-color: #0f172a;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
        }

        /* ── Cards ── */
        .card-pe {
            border: none;
            border-radius: 16px;
            background: var(--pe-card-bg);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
        }
        .card-pe:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .card-pe .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
            font-weight: 700;
            color: var(--pe-secondary);
        }
        .card-pe .card-header h4, .card-pe .card-header h3 {
             margin-bottom: 0; 
        }
        .card-pe .card-body {
            padding: 1.5rem;
        }

        /* ── Section headings ── */
        .section-title {
            color: var(--pe-secondary);
            font-weight: 800;
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
            letter-spacing: -0.025em;
        }
        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: var(--pe-primary);
            margin-top: 0.5rem;
            border-radius: 9999px;
        }
        .section-title .accent { color: var(--pe-primary); }

        /* ── Tab pills (home) ── */
        .nav-pills .nav-link {
            color: var(--pe-secondary);
            background-color: #fff;
            border-radius: 9999px;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            margin-right: 12px;
            margin-bottom: 12px;
            border: 1px solid #e2e8f0;
            transition: all .2s;
        }
        .nav-pills .nav-link.active,
        .nav-pills .nav-link:hover {
            background-color: var(--pe-primary);
            color: #fff;
            border-color: var(--pe-primary);
            box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.3);
        }

        /* ── Price badge ── */
        .badge-price {
            background-color: var(--pe-secondary);
            color: #fff;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            font-weight: 700;
            font-size: .875rem;
        }

        /* ── Footer ── */
        .footer-prieto {
            background-color: #fff;
            color: var(--pe-text);
            border-top: 1px solid #e2e8f0;
            margin-top: auto;
            padding-top: 4rem;
            padding-bottom: 2rem;
        }
        .footer-prieto h5 {
            color: var(--pe-primary);
            font-weight: 800;
            margin-bottom: 1.2rem;
            font-size: 1.25rem;
        }
        .footer-prieto p {
            font-size: 0.95rem;
            line-height: 1.6;
        }
        .footer-prieto a {
            color: var(--pe-text);
            text-decoration: none;
            transition: color 0.2s;
            display: block;
            margin-bottom: 0.6rem;
            font-weight: 500;
        }
        .footer-prieto a:hover { color: var(--pe-primary); transform: translateX(3px); display: inline-block; }

        /* ── Admin Tables & Layout ── */
        .admin-card-header {
            background: #fff;
            color: var(--pe-secondary);
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table-pe {
            --bs-table-bg: transparent;
            border-collapse: separate;
            border-spacing: 0 8px;
        }
        .table-pe thead th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            border: none;
            padding: 1rem;
            font-weight: 700;
        }
        .table-pe tbody tr {
            background-color: #fff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s;
            border-radius: 8px;
        }
        .table-pe tbody tr:hover {
            transform: scale(1.01);
            z-index: 10;
        }
        .table-pe td {
            border: none;
            padding: 1.25rem 1rem;
            vertical-align: middle;
            color: var(--pe-secondary);
            font-weight: 500;
        }
        .table-pe td:first-child { border-top-left-radius: 8px; border-bottom-left-radius: 8px; }
        .table-pe td:last-child { border-top-right-radius: 8px; border-bottom-right-radius: 8px; }

        /* ── Form Controls ── */
        .form-control {
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            padding: 0.75rem 1rem;
            background-color: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
            border-color: var(--pe-primary);
        }
        .form-check-input:checked {
            background-color: var(--pe-primary);
            border-color: var(--pe-primary);
        }

        /* ── Misc ── */
        main { flex: 1; }

        /* ── Breadcrumbs ── */
        .breadcrumb-item + .breadcrumb-item::before { color: #94a3b8; }
        .breadcrumb-item a { color: var(--pe-primary); text-decoration: none; }
        .breadcrumb-item.active { color: var(--pe-secondary); }

        /* ── Accordion ── */
        .accordion-button:not(.collapsed) {
             background-color: var(--pe-primary-light);
             color: var(--pe-primary) !important;
             box-shadow: none; 
        }
        .accordion-button:focus { box-shadow: 0 0 0 .2rem rgba(249, 115, 22, 0.15); }

        /* ── Alert custom ── */
        .alert { border: none; border-radius: 12px; font-weight: 500; }
        .alert-success { background-color: #dcfce7; color: #166534; border-left: 5px solid #16a34a; }
        .alert-danger  { background-color: #fee2e2; color: #991b1b; border-left: 5px solid #dc2626; }
        
        /* ── Responsive fixes ── */
        @media (max-width: 767.98px) {
            .admin-card-header { padding: 1rem !important; }
            .badge-price { font-size: .78rem; padding: 4px 10px; }
            .section-title { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

    @include('layouts.navbar')

    <main class="py-2">
        @yield('content')
    </main>

    @include('layouts.footer')

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
