<?php
require_once __DIR__.'/../config/database.php'; require_once __DIR__.'/../config/auth.php';
$id=(int)($_GET['id']??0); $editing=$id>0;
$p=['name'=>'','sku'=>'','category_id'=>'','purchase_price'=>'0','selling_price'=>'0','stock_qty'=>'0','low_stock_level'=>'5','description'=>''];
if($editing){$st=$pdo->prepare("SELECT * FROM products WHERE id=?");$st->execute([$id]);$p=$st->fetch();if(!$p) exit('Product not found');}
if($_SERVER['REQUEST_METHOD']==='POST'){
    $data=[trim($_POST['name']),trim($_POST['sku']),($_POST['category_id']?:null),(float)$_POST['purchase_price'],(float)$_POST['selling_price'],(int)$_POST['stock_qty'],(int)$_POST['low_stock_level'],trim($_POST['description'])];
    if($editing){$st=$pdo->prepare("UPDATE products SET name=?,sku=?,category_id=?,purchase_price=?,selling_price=?,stock_qty=?,low_stock_level=?,description=? WHERE id=?");$st->execute([...$data,$id]);flash('success','Product updated.');}
    else{$st=$pdo->prepare("INSERT INTO products(name,sku,category_id,purchase_price,selling_price,stock_qty,low_stock_level,description) VALUES(?,?,?,?,?,?,?,?)");$st->execute($data);flash('success','Product created.');}
    header("Location: index.php");exit;
}
$cats=$pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll(); $page_title=$editing?'Edit Product':'Add Product'; require __DIR__.'/../partials/header.php'; ?>
<h3 class="fw-bold"><?=$page_title?></h3><div class="card mt-3"><div class="card-body"><form method="post" class="row g-3">
<div class="col-md-6"><label class="form-label">Product Name</label><input required class="form-control" name="name" value="<?=e($p['name'])?>"></div>
<div class="col-md-6"><label class="form-label">SKU</label><input required class="form-control" name="sku" value="<?=e($p['sku'])?>"></div>
<div class="col-md-4"><label class="form-label">Category</label><select class="form-select" name="category_id"><option value="">Select</option><?php foreach($cats as $c): ?><option value="<?=$c['id']?>" <?=$p['category_id']==$c['id']?'selected':''?>><?=e($c['name'])?></option><?php endforeach;?></select></div>
<div class="col-md-4"><label class="form-label">Purchase Price</label><input type="number" step=".01" min="0" class="form-control" name="purchase_price" value="<?=$p['purchase_price']?>"></div>
<div class="col-md-4"><label class="form-label">Selling Price</label><input required type="number" step=".01" min="0" class="form-control" name="selling_price" value="<?=$p['selling_price']?>"></div>
<div class="col-md-6"><label class="form-label">Stock Quantity</label><input type="number" min="0" class="form-control" name="stock_qty" value="<?=$p['stock_qty']?>"></div>
<div class="col-md-6"><label class="form-label">Low Stock Level</label><input type="number" min="0" class="form-control" name="low_stock_level" value="<?=$p['low_stock_level']?>"></div>
<div class="col-12"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="3"><?=e($p['description'])?></textarea></div>
<div class="col-12"><button class="btn btn-primary">Save Product</button> <a class="btn btn-light" href="index.php">Cancel</a></div></form></div></div>
<?php require __DIR__.'/../partials/footer.php'; ?>
