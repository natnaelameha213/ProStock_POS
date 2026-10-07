<?php require_once __DIR__.'/../config/auth.php'; require_login(); ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=e($page_title ?? 'ProStock POS')?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<link href="<?=base_url('assets/css/style.css')?>" rel="stylesheet"></head><body>
<div class="app-shell"><aside class="sidebar"><div class="brand px-3 py-3"><div class="brand-mark">P</div><div><strong>ProStock</strong><small>POS & Inventory</small></div></div>
<nav class="nav flex-column px-2 gap-1">
<a href="<?=base_url('dashboard.php')?>" class="nav-link"><i class="bi bi-grid-1x2"></i> Dashboard</a>
<a href="<?=base_url('sales/pos.php')?>" class="nav-link"><i class="bi bi-cart3"></i> POS / New Sale</a>
<a href="<?=base_url('products/index.php')?>" class="nav-link"><i class="bi bi-box-seam"></i> Products</a>
<a href="<?=base_url('categories/index.php')?>" class="nav-link"><i class="bi bi-tags"></i> Categories</a>
<a href="<?=base_url('inventory/index.php')?>" class="nav-link"><i class="bi bi-arrow-left-right"></i> Inventory</a>
<a href="<?=base_url('customers/index.php')?>" class="nav-link"><i class="bi bi-people"></i> Customers</a>
<a href="<?=base_url('sales/index.php')?>" class="nav-link"><i class="bi bi-receipt"></i> Sales</a>
<a href="<?=base_url('reports/index.php')?>" class="nav-link"><i class="bi bi-bar-chart"></i> Reports</a>
<?php if(($_SESSION['user']['role']??'')==='admin'): ?><a href="<?=base_url('users/index.php')?>" class="nav-link"><i class="bi bi-person-gear"></i> Users</a><?php endif; ?>
<a href="<?=base_url('settings/index.php')?>" class="nav-link"><i class="bi bi-gear"></i> Settings</a>
</nav><div class="sidebar-bottom px-3"><div class="small text-muted">Signed in as</div><strong><?=e($_SESSION['user']['name'])?></strong><div class="mt-2"><a class="btn btn-sm btn-outline-light w-100" href="<?=base_url('auth/logout.php')?>">Logout</a></div></div>
</aside><main class="main-content"><header class="topbar"><button class="btn btn-light d-lg-none" id="menuBtn"><i class="bi bi-list"></i></button><div class="ms-auto d-flex align-items-center gap-3"><span class="badge text-bg-light"><?=e(ucfirst($_SESSION['user']['role']))?></span><a href="<?=base_url('sales/pos.php')?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> New Sale</a></div></header><div class="container-fluid p-4"><?php show_flash(); ?>
