<?php
require_once __DIR__.'/../config/database.php'; require_once __DIR__.'/../config/auth.php';
$page_title='Products'; $q=trim($_GET['q']??'');
$sql="SELECT p.*,c.name category FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.name LIKE ? OR p.sku LIKE ? ORDER BY p.id DESC";
$st=$pdo->prepare($sql);$st->execute(["%$q%","%$q%"]);$rows=$st->fetchAll();
require __DIR__.'/../partials/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3"><div><h3 class="fw-bold">Products</h3><p class="text-muted mb-0">Manage products and stock.</p></div><a class="btn btn-primary" href="form.php"><i class="bi bi-plus-lg"></i> Add Product</a></div>
<div class="card"><div class="card-body"><form class="row g-2 mb-3"><div class="col-md-5"><input class="form-control" name="q" value="<?=e($q)?>" placeholder="Search name or SKU"></div><div class="col-auto"><button class="btn btn-outline-secondary">Search</button></div></form>
<div class="table-responsive"><table class="table align-middle"><thead><tr><th>Product</th><th>SKU</th><th>Category</th><th>Buy</th><th>Sell</th><th>Stock</th><th></th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr class="<?=($r['stock_qty']<=$r['low_stock_level']?'low-stock':'')?>"><td><strong><?=e($r['name'])?></strong></td><td><?=e($r['sku'])?></td><td><?=e($r['category']??'-')?></td><td>$<?=money($r['purchase_price'])?></td><td>$<?=money($r['selling_price'])?></td><td><span class="badge <?=$r['stock_qty']<=0?'text-bg-danger':($r['stock_qty']<=$r['low_stock_level']?'text-bg-warning':'text-bg-success')?>"><?=$r['stock_qty']?></span></td><td class="text-end"><a class="btn btn-sm btn-outline-primary" href="form.php?id=<?=$r['id']?>">Edit</a> <a class="btn btn-sm btn-outline-danger" onclick="return confirmDelete()" href="delete.php?id=<?=$r['id']?>">Delete</a></td></tr><?php endforeach; ?>
</tbody></table></div></div></div>
<?php require __DIR__.'/../partials/footer.php'; ?>
