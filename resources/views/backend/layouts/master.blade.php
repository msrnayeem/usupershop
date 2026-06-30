<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>U Super Shop — Admin</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend') }}/images/favicon.ico">

    {{-- Inter Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/fontawesome-free/css/all.min.css" />

    {{-- Plugin CSS (kept intact for compatibility) --}}
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/jqvmap/jqvmap.min.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/summernote/summernote-lite.min.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/css/chosen.min.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/sweetalert/sweetalert.css" />

    {{-- Calendar --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/calendar/calendar-win2k-cold-1.css" title="win2k-cold-1">

    {{-- jQuery (must be early for inline scripts) --}}
    <script src="{{ asset('backend') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('js/notify.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('backend') }}/sweetalert/sweetalert.js"></script>

    {{-- Modern Admin Design System --}}
    <style>
        :root {
            --bg-base:       #f1f4f9;
            --bg-surface:    #ffffff;
            --bg-card:       #ffffff;
            --bg-card-hover: #f8fafc;
            --sidebar-w:     260px;
            --topbar-h:      60px;
            --accent:        #6366f1;
            --accent-hover:  #4f46e5;
            --accent-light:  rgba(99,102,241,0.1);
            --green:         #10b981;
            --green-light:   rgba(16,185,129,0.1);
            --amber:         #f59e0b;
            --amber-light:   rgba(245,158,11,0.1);
            --red:           #ef4444;
            --red-light:     rgba(239,68,68,0.1);
            --blue:          #3b82f6;
            --blue-light:    rgba(59,130,246,0.1);
            --purple:        #8b5cf6;
            --purple-light:  rgba(139,92,246,0.1);
            --text-primary:  #0f172a;
            --text-secondary:#334155;
            --text-muted:    #64748b;
            --border:        #e2e8f0;
            --border-strong: #cbd5e1;
            --radius:        12px;
            --radius-sm:     8px;
            --shadow:        0 4px 24px rgba(0,0,0,0.08);
            --shadow-sm:     0 2px 8px rgba(0,0,0,0.05);
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0; padding: 0;
            background: var(--bg-base);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── LAYOUT ── */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        #sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 1000;
            transition: transform 0.28s cubic-bezier(.4,0,.2,1), width 0.28s cubic-bezier(.4,0,.2,1);
            overflow: hidden;
        }

        #sidebar.collapsed {
            transform: translateX(calc(-1 * var(--sidebar-w)));
        }

        .sidebar-brand {
            height: var(--topbar-h);
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 20px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
            text-decoration: none;
        }
        .sidebar-brand-icon {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--accent), var(--purple));
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; color: #fff; flex-shrink: 0;
        }
        .sidebar-brand-text {
            font-weight: 700;
            font-size: 15px;
            color: var(--text-primary);
            white-space: nowrap;
        }
        .sidebar-brand-text span { color: var(--accent); }

        /* User panel inside sidebar */
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }
        .sidebar-user-avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent);
            flex-shrink: 0;
        }
        .sidebar-user-name {
            font-weight: 600;
            font-size: 13px;
            color: #0f172a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-user-role {
            font-size: 11px;
            color: var(--text-muted);
        }

        /* Sidebar scroll area */
        .sidebar-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 12px 0 24px;
        }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: var(--border-strong); border-radius: 2px; }

        /* Nav sections */
        .sidebar-section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: #94a3b8;
            text-transform: uppercase;
            padding: 16px 20px 6px;
        }

        /* Nav items */
        .nav-group { list-style: none; margin: 0; padding: 0 10px; }
        .nav-group .nav-item { margin-bottom: 2px; }

        .nav-group .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            color: #475569;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
            position: relative;
            cursor: pointer;
        }
        .nav-group .nav-link:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .nav-group .nav-link.active {
            background: var(--accent-light);
            color: var(--accent);
            font-weight: 600;
        }
        .nav-group .nav-link .nav-icon {
            width: 18px;
            text-align: center;
            font-size: 14px;
            flex-shrink: 0;
            opacity: 0.8;
        }
        .nav-group .nav-link.active .nav-icon { opacity: 1; }
        .nav-group .nav-link p {
            margin: 0; flex: 1;
            display: flex; align-items: center; gap: 6px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .nav-group .nav-link .right {
            margin-left: auto;
            transition: transform 0.2s;
            font-size: 11px;
        }

        /* Submenu */
        .nav-treeview {
            list-style: none;
            padding: 0 0 0 28px;
            margin: 0;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.25s ease;
        }
        .nav-item.menu-open > .nav-treeview { max-height: 600px; }
        .nav-item.menu-open > .nav-link .right { transform: rotate(-90deg); }

        .nav-treeview .nav-link {
            font-size: 13px;
            padding: 7px 10px;
            color: #64748b;
            border-radius: var(--radius-sm);
        }
        .nav-treeview .nav-link:hover { color: #0f172a; background: #f1f5f9; }
        .nav-treeview .nav-link.active { color: var(--accent); background: var(--accent-light); }
        .nav-treeview .nav-icon { font-size: 6px; color: #94a3b8; }
        .nav-treeview .nav-link.active .nav-icon { color: var(--accent); }

        /* Badges */
        .badge { display: inline-flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 20px; line-height: 1.4; }
        .badge-danger  { background: #fee2e2; color: #dc2626; }
        .badge-success { background: #d1fae5; color: #059669; }
        .badge-warning { background: #fef3c7; color: #d97706; }
        .badge-primary { background: var(--accent-light); color: var(--accent); }
        .badge-secondary { background: #f1f5f9; color: #64748b; }

        /* ── TOPBAR ── */
        #topbar {
            position: fixed;
            top: 0; right: 0;
            left: var(--sidebar-w);
            height: var(--topbar-h);
            background: #ffffff;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 999;
            transition: left 0.28s cubic-bezier(.4,0,.2,1);
        }
        #topbar.sidebar-collapsed { left: 0; }

        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }

        #sidebar-toggle {
            background: none; border: none; padding: 8px;
            color: #64748b; cursor: pointer;
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; transition: background 0.15s, color 0.15s;
        }
        #sidebar-toggle:hover { background: #f1f5f9; color: #0f172a; }

        .topbar-brand-sm {
            font-weight: 700; font-size: 15px; color: var(--text-primary);
            display: none;
        }

        /* Topbar user dropdown */
        .topbar-user {
            position: relative;
        }
        .topbar-user-btn {
            display: flex; align-items: center; gap: 10px;
            background: #f8fafc; border: 1px solid var(--border);
            border-radius: 40px; padding: 6px 14px 6px 8px;
            cursor: pointer; transition: background 0.15s, border-color 0.15s;
        }
        .topbar-user-btn:hover { background: #f1f5f9; border-color: var(--border-strong); }
        .topbar-user-btn img {
            width: 28px; height: 28px; border-radius: 50%; object-fit: cover;
        }
        .topbar-user-btn .user-name {
            font-size: 13px; font-weight: 600; color: #0f172a; white-space: nowrap;
        }
        .topbar-dropdown {
            position: absolute; top: calc(100% + 8px); right: 0;
            background: #ffffff;
            border: 1px solid var(--border-strong);
            border-radius: var(--radius);
            min-width: 180px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            overflow: hidden;
            display: none;
            z-index: 2000;
        }
        .topbar-dropdown.open { display: block; animation: fadeInDown 0.15s ease; }
        .topbar-dropdown a {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 16px;
            color: #475569;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: background 0.12s, color 0.12s;
        }
        .topbar-dropdown a:hover { background: #f8fafc; color: #0f172a; }
        .topbar-dropdown a.danger:hover { background: #fee2e2; color: #dc2626; }
        .topbar-dropdown .divider { height: 1px; background: var(--border); margin: 4px 0; }

        /* Store link pill */
        .topbar-store-link {
            display: flex; align-items: center; gap: 6px;
            background: var(--green-light); color: var(--green);
            padding: 6px 14px; border-radius: 40px;
            font-size: 12px; font-weight: 600;
            text-decoration: none;
            transition: background 0.15s;
        }
        .topbar-store-link:hover { background: rgba(16,185,129,0.25); color: var(--green); }

        /* ── CONTENT AREA ── */
        #main-content {
            margin-left: var(--sidebar-w);
            margin-top: var(--topbar-h);
            min-height: calc(100vh - var(--topbar-h));
            padding: 24px;
            transition: margin-left 0.28s cubic-bezier(.4,0,.2,1);
            background: var(--bg-base);
        }
        #main-content.sidebar-collapsed { margin-left: 0; }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
        }
        .page-header h1 {
            font-size: 22px; font-weight: 700;
            color: var(--text-primary); margin: 0;
        }
        .breadcrumb {
            display: flex; align-items: center; gap: 6px;
            list-style: none; margin: 0; padding: 0;
        }
        .breadcrumb-item { font-size: 13px; color: var(--text-muted); }
        .breadcrumb-item a { color: var(--text-muted); text-decoration: none; }
        .breadcrumb-item a:hover { color: var(--accent); }
        .breadcrumb-item + .breadcrumb-item::before { content: '/'; margin-right: 6px; color: var(--text-muted); }
        .breadcrumb-item.active { color: var(--text-secondary); }

        /* ── CARDS ── */
        .card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 1px 4px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.04);
            overflow: visible;
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: 10px;
            background: #ffffff;
        }
        .card-title {
            font-size: 15px; font-weight: 600;
            color: #0f172a; margin: 0;
        }
        .card-body { padding: 20px; }
        .card-footer {
            padding: 12px 20px;
            border-top: 1px solid var(--border);
        }

        /* ── TABLES ── */
        .table {
            width: 100%; border-collapse: collapse; color: #0f172a;
        }
        .table th {
            background: #f8fafc;
            color: #64748b;
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.06em;
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        .table td {
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
            vertical-align: middle;
        }
        .table tr:last-child td { border-bottom: none; }
        .table tbody tr:hover td { background: #f8fafc; }
        .table-striped tbody tr:nth-of-type(odd) td { background: #fafbfc; }

        /* ── FORMS ── */
        .form-control, .form-select, select, input[type="text"], input[type="email"], input[type="password"], input[type="number"], textarea {
            background: #ffffff !important;
            border: 1px solid #d1d5db !important;
            border-radius: var(--radius-sm) !important;
            color: #0f172a !important;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            padding: 9px 12px;
            transition: border-color 0.15s, box-shadow 0.15s;
            width: 100%;
        }
        .form-control:focus, select:focus, input:focus, textarea:focus {
            outline: none;
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12) !important;
        }
        .form-control::placeholder, input::placeholder, textarea::placeholder { color: #94a3b8 !important; }
        label, .form-label { color: #374151; font-size: 13px; font-weight: 500; margin-bottom: 6px; display: block; }
        .form-group { margin-bottom: 18px; }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 8px 18px;
            border-radius: var(--radius-sm);
            font-size: 13px; font-weight: 600;
            border: none; cursor: pointer;
            text-decoration: none;
            transition: opacity 0.15s, transform 0.1s, box-shadow 0.15s;
            line-height: 1.4;
        }
        .btn:hover { opacity: 0.88; transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }
        .btn-primary   { background: var(--accent); color: #fff; }
        .btn-success   { background: var(--green);  color: #fff; }
        .btn-danger    { background: var(--red);    color: #fff; }
        .btn-warning   { background: var(--amber);  color: #000; }
        .btn-secondary { background: rgba(100,116,139,0.2); color: var(--text-secondary); border: 1px solid var(--border-strong); }
        .btn-info      { background: var(--blue);   color: #fff; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }
        .btn-xs { padding: 3px 8px; font-size: 11px; border-radius: 5px; }
        .btn-outline-primary { background: transparent; border: 1px solid var(--accent); color: var(--accent); }
        .btn-outline-primary:hover { background: var(--accent-light); }

        /* ── ALERTS / FLASH ── */
        .alert {
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            font-size: 13px;
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 16px;
            border: 1px solid;
        }
        .alert-success { background: #f0fdf4; border-color: #86efac; color: #15803d; }
        .alert-danger  { background: #fef2f2; border-color: #fca5a5; color: #dc2626; }
        .alert-warning { background: #fffbeb; border-color: #fcd34d; color: #b45309; }
        .alert-info    { background: #eff6ff; border-color: #93c5fd; color: #1d4ed8; }

        /* ── PAGINATION ── */
        .pagination { display: flex; gap: 4px; list-style: none; margin: 0; padding: 0; }
        .page-item .page-link {
            background: #ffffff; border: 1px solid var(--border);
            color: #475569; padding: 6px 12px; border-radius: 6px;
            font-size: 13px; text-decoration: none;
            transition: background 0.12s, color 0.12s;
        }
        .page-item.active .page-link { background: var(--accent); border-color: var(--accent); color: #fff; }
        .page-item .page-link:hover { background: #f8fafc; color: #0f172a; }

        /* ── FOOTER ── */
        #main-footer {
            margin-left: var(--sidebar-w);
            border-top: 1px solid var(--border);
            padding: 14px 24px;
            display: flex; align-items: center; justify-content: space-between;
            font-size: 12px; color: #64748b;
            background: #ffffff;
            transition: margin-left 0.28s cubic-bezier(.4,0,.2,1);
        }
        #main-footer.sidebar-collapsed { margin-left: 0; }

        /* ── OVERLAY (mobile) ── */
        #sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 999;
        }
        @media (max-width: 768px) {
            #sidebar { transform: translateX(calc(-1 * var(--sidebar-w))); }
            #sidebar.mobile-open { transform: translateX(0); }
            #topbar { left: 0 !important; }
            #main-content { margin-left: 0 !important; }
            #main-footer { margin-left: 0 !important; }
            #sidebar-overlay.active { display: block; }
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.3s ease both; }

        /* ── CONTENT WRAPPER compat (for AdminLTE extends) ── */
        .content-wrapper { background: transparent; }
        .content { padding: 0; }
        .content-header { padding: 0 0 20px; }
        .container-fluid { padding: 0; }

        /* Select2 light theme override */
        .select2-container--bootstrap4 .select2-selection {
            background: #ffffff !important;
            border-color: #d1d5db !important;
            color: #0f172a !important;
        }
        .select2-dropdown {
            background: #ffffff !important;
            border-color: #d1d5db !important;
        }
        .select2-results__option { color: #0f172a !important; }
        .select2-results__option--highlighted { background: var(--accent-light) !important; color: var(--accent) !important; }

        /* DataTables light override */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background: #ffffff !important;
            border-color: #d1d5db !important;
            color: #0f172a !important;
        }
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label { color: #64748b !important; }

        /* Summernote light */
        .note-editor { border-color: #d1d5db !important; }
        .note-toolbar { background: #f8fafc !important; border-bottom-color: var(--border) !important; }
        .note-editable { background: #ffffff !important; color: #0f172a !important; }

        /* Bootstrap compat */
        .row { display: flex; flex-wrap: wrap; margin: 0 -10px; }
        .col, [class*="col-"] { padding: 0 10px; width: 100%; }
        .col-12 { flex: 0 0 100%; max-width: 100%; }
        .col-6 { flex: 0 0 50%; max-width: 50%; }

        @media (min-width: 768px) {
            .col-md-4 { flex: 0 0 33.333%; max-width: 33.333%; }
            .col-md-6 { flex: 0 0 50%; max-width: 50%; }
            .col-md-12 { flex: 0 0 100%; max-width: 100%; }
        }

        @media (min-width: 992px) {
            .col-lg-3 { flex: 0 0 25%; max-width: 25%; }
            .col-lg-4 { flex: 0 0 33.333%; max-width: 33.333%; }
            .col-lg-6 { flex: 0 0 50%; max-width: 50%; }
            .col-lg-8 { flex: 0 0 66.667%; max-width: 66.667%; }
            .col-lg-9 { flex: 0 0 75%; max-width: 75%; }
            .col-lg-12 { flex: 0 0 100%; max-width: 100%; }
        }

        @media (max-width: 480px) {
            .col-6 { flex: 0 0 100%; max-width: 100%; }
        }

        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 16px; }
        .mb-4 { margin-bottom: 24px; }
        .mt-2 { margin-top: 8px; }
        .mt-3 { margin-top: 16px; }
        .mt-4 { margin-top: 24px; }
        .me-2, .mr-2 { margin-right: 8px; }
        .ms-auto, .ml-auto { margin-left: auto; }
        .d-flex { display: flex; }
        .align-items-center { align-items: center; }
        .justify-content-between { justify-content: space-between; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .text-center { text-align: center; }
        .float-right, .float-sm-right { float: right; }
        .w-100 { width: 100%; }

        /* Notifyjs dark */
        .notifyjs-corner { z-index: 10000 !important; }

        /* Bootstrap modal styling */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            display: none;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
        }
        .modal-open {
            overflow: hidden;
        }
        .modal-open .modal {
            overflow-x: hidden;
            overflow-y: auto;
        }
        .modal-dialog {
            position: relative;
            width: auto;
            margin: 1.75rem auto;
            pointer-events: none;
            max-width: 500px;
        }
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 3.5rem);
        }
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: translate(0, -50px);
        }
        .modal.show .modal-dialog {
            transform: none;
        }
        .modal-content {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            outline: 0;
            box-shadow: var(--shadow);
        }
        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            border-top-left-radius: var(--radius);
            border-top-right-radius: var(--radius);
        }
        .modal-header .close {
            padding: 1rem;
            margin: -1rem -1rem -1rem auto;
            background: transparent;
            border: 0;
            font-size: 1.5rem;
            line-height: 1;
            color: var(--text-muted);
            opacity: 0.5;
            cursor: pointer;
            outline: none;
            transition: opacity 0.2s;
        }
        .modal-header .close:hover {
            opacity: 1;
        }
        .modal-body {
            position: relative;
            flex: 1 1 auto;
            padding: 20px;
        }
        .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 16px 20px;
            border-top: 1px solid var(--border);
            border-bottom-right-radius: var(--radius);
            border-bottom-left-radius: var(--radius);
            gap: 12px;
        }
        .modal-backdrop {
            display: none !important;
        }

        /* Bootstrap dropdown styling */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            left: auto;
            z-index: 1060;
            display: none;
            min-width: 160px;
            padding: 6px 0;
            margin: 4px 0 0;
            font-size: 13px;
            color: var(--text-primary);
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            box-shadow: var(--shadow);
        }
        .dropdown-menu.show {
            display: block;
        }
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 8px 16px;
            clear: both;
            font-weight: 500;
            color: var(--text-secondary);
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.15s, color 0.15s;
        }
        .dropdown-item:hover, .dropdown-item:focus {
            color: var(--text-primary);
            background-color: var(--bg-card-hover);
            text-decoration: none;
        }
        .dropdown-divider {
            height: 0;
            margin: 6px 0;
            overflow: hidden;
            border-top: 1px solid var(--border);
        }
    </style>
    @yield('admin_css')
</head>

<body>
<div id="sidebar-overlay"></div>

{{-- ═══════════════════════════════════════
     SIDEBAR
═══════════════════════════════════════ --}}
<aside id="sidebar">
    {{-- Brand --}}
    <a href="{{ route('home') }}" class="sidebar-brand">
        <div class="sidebar-brand-icon"><i class="fas fa-store"></i></div>
        <div class="sidebar-brand-text">U <span>Super</span> Shop</div>
    </a>

    {{-- User panel --}}
    <div class="sidebar-user">
        <img src="{{ !empty(Auth::user()->image) ? url('public/upload/user_images/' . Auth::user()->image) : url('public/upload/profile.jpg') }}"
             class="sidebar-user-avatar" alt="User">
        <div>
            <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
            <div class="sidebar-user-role">{{ ucfirst(Auth::user()->role ?? Auth::user()->usertype ?? 'Admin') }}</div>
        </div>
    </div>

    {{-- Nav --}}
    <div class="sidebar-scroll">
        @include('backend.layouts.sidebar')
    </div>
</aside>

{{-- ═══════════════════════════════════════
     TOPBAR
═══════════════════════════════════════ --}}
<header id="topbar">
    <div class="topbar-left">
        <button id="sidebar-toggle" title="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <span class="topbar-brand-sm">U Super Shop</span>
    </div>
    <div class="topbar-right">
        <a href="{{ url('/') }}" target="_blank" class="topbar-store-link">
            <i class="fas fa-external-link-alt"></i> View Store
        </a>
        <div class="topbar-user" id="topbar-user">
            <button class="topbar-user-btn" id="user-menu-btn">
                <img src="{{ !empty(Auth::user()->image) ? url('public/upload/user_images/' . Auth::user()->image) : url('public/upload/profile.jpg') }}" alt="User">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <i class="fas fa-chevron-down" style="font-size:10px; color:var(--text-muted);"></i>
            </button>
            <div class="topbar-dropdown" id="user-dropdown">
                <a href="{{ route('profiles.view') }}"><i class="fas fa-user-circle"></i> My Profile</a>
                <a href="{{ route('profiles.password.view') }}"><i class="fas fa-key"></i> Change Password</a>
                <div class="divider"></div>
                <a href="{{ route('logout') }}" class="danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
</header>

{{-- ═══════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════ --}}
<main id="main-content" class="fade-in">
    {{-- Flash messages --}}
    @if (session()->has('success'))
        <div class="alert alert-success mb-3">
            <i class="fas fa-check-circle"></i> {{ session()->get('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger mb-3">
            <i class="fas fa-exclamation-circle"></i> {{ session()->get('error') }}
        </div>
    @endif

    @yield('content')
</main>

{{-- Footer --}}
<footer id="main-footer">
    <span>Copyright &copy; {{ date('Y') }} <strong>U Super Shop</strong>. All rights reserved.</span>
    <span>Design &amp; Developed by U Super Shop</span>
</footer>

{{-- ═══════════════════════════════════════
     SCRIPTS
═══════════════════════════════════════ --}}
<script src="{{ asset('backend') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
    if ($.widget) $.widget.bridge("uibutton", $.ui.button);
</script>
<script src="{{ asset('backend') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

@if(request()->routeIs('home'))
<script src="{{ asset('backend') }}/plugins/chart.js/Chart.min.js"></script>
<script src="{{ asset('backend') }}/plugins/sparklines/sparkline.js"></script>
<script src="{{ asset('backend') }}/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{ asset('backend') }}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="{{ asset('backend') }}/plugins/jquery-knob/jquery.knob.min.js"></script>
@endif

<script src="{{ asset('backend') }}/plugins/moment/moment.min.js"></script>
<script src="{{ asset('backend') }}/plugins/daterangepicker/daterangepicker.js"></script>
<script src="{{ asset('backend') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="{{ asset('backend') }}/plugins/summernote/summernote-lite.min.js"></script>
<script src="{{ asset('backend') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="{{ asset('backend') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('backend') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('backend') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('backend') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('backend') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('backend') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('backend') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('backend') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('backend') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="{{ asset('backend') }}/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="{{ asset('backend') }}/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="{{ asset('backend') }}/plugins/select2/js/select2.full.min.js"></script>
<script src="{{ asset('backend') }}/js/chosen.jquery.min.js"></script>
<script src="{{ asset('backend') }}/js/ace.min.js"></script>
<script src="{{ asset('backend') }}/calendar/calendar.js"></script>
<script src="{{ asset('backend') }}/calendar/calendar-en.js"></script>
<script src="{{ asset('backend') }}/calendar/calendar-setup.js"></script>

<script>
$(document).ready(function () {
    /* ── Sidebar toggle ── */
    var $sidebar  = $('#sidebar');
    var $topbar   = $('#topbar');
    var $content  = $('#main-content');
    var $footer   = $('#main-footer');
    var $overlay  = $('#sidebar-overlay');
    var isMobile  = () => window.innerWidth <= 768;

    $('#sidebar-toggle').on('click', function () {
        if (isMobile()) {
            $sidebar.toggleClass('mobile-open');
            $overlay.toggleClass('active');
        } else {
            $sidebar.toggleClass('collapsed');
            $topbar.toggleClass('sidebar-collapsed');
            $content.toggleClass('sidebar-collapsed');
            $footer.toggleClass('sidebar-collapsed');
        }
    });

    $overlay.on('click', function () {
        $sidebar.removeClass('mobile-open');
        $overlay.removeClass('active');
    });

    /* ── Topbar user dropdown ── */
    $('#user-menu-btn').on('click', function (e) {
        e.stopPropagation();
        $('#user-dropdown').toggleClass('open');
    });
    $(document).on('click', function () { $('#user-dropdown').removeClass('open'); });

    /* ── Sidebar submenu accordion ── */
    $(document).on('click', '.nav-group .nav-link[data-toggle="treeview"]', function (e) {
        e.preventDefault();
        var $item = $(this).closest('.nav-item');
        if ($item.hasClass('menu-open')) {
            $item.removeClass('menu-open');
        } else {
            $item.siblings('.menu-open').removeClass('menu-open');
            $item.addClass('menu-open');
        }
    });

    /* ── Select2 ── */
    $('.select2').select2();

    /* ── Summernote ── */
    if ($('#summernote').length)  { $('#summernote').summernote(); }
    if ($('.summernote').length)  { $('.summernote').summernote(); }

    /* ── SweetAlert delete confirm ── */
    $(document).on('click', '#delete', function () {
        var actionTo = $(this).attr('href');
        var token    = $(this).attr('data-token');
        var id       = $(this).attr('data-id');
        swal({
            title: 'Are you sure?', type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'Cancel',
            closeOnConfirm: false, closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: actionTo, type: 'post',
                    data: { id: id, _token: token },
                    success: function () {
                        swal({ title: 'Deleted!', type: 'success' }, function () { $('.' + id).fadeOut(); });
                    }
                });
            } else {
                swal('Cancelled', '', 'error');
            }
        });
        return false;
    });

    /* ── SweetAlert approve confirm ── */
    $(document).on('click', '#approve', function () {
        var actionTo = $(this).attr('href');
        var token    = $(this).attr('data-token');
        var id       = $(this).attr('data-id');
        swal({
            title: 'Are you sure?', type: 'info',
            showCancelButton: true,
            confirmButtonClass: 'btn-primary',
            confirmButtonText: 'Yes', cancelButtonText: 'No',
            closeOnConfirm: false, closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: actionTo, type: 'post',
                    data: { id: id, _token: token },
                    success: function () {
                        swal({ title: 'Approved!', type: 'success' }, function () { $('.' + id).fadeOut(); });
                    }
                });
            } else {
                swal('Cancelled', '', 'error');
            }
        });
        return false;
    });

    /* ── Notify flash ── */
    @if (session()->has('success'))
        $.notify("{{ session()->get('success') }}", { globalPosition: 'top right', className: 'success' });
    @endif
    @if (session()->has('error'))
        $.notify("{{ session()->get('error') }}", { globalPosition: 'top right', className: 'error' });
    @endif
});
</script>

@yield('custom_js')
@stack('scripts')
</body>
</html>
