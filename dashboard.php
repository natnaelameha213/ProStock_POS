<?php
require_once __DIR__.'/config/database.php'; require_once __DIR__.'/config/auth.php';
$page_title='Dashboard';
$customers=$pdo->query("SELECT COUNT(*) c FROM customers")->fetch()['c'];
$products=$pdo->query("SELECT COUNT(*) c FROM products")->fetch()['c'];
$low=$pdo->query("SELECT COUNT(*) c FROM products WHERE stock_qty<=low_stock_level")->fetch()['c'];
$today=$pdo->query("SELECT COALESCE(SUM(total),0) v FROM sales WHERE DATE(sale_date)=CURDATE() AND status='completed'")->fetch()['v'];
$month=$pdo->query("SELECT COALESCE(SUM(total),0) v FROM sales WHERE MONTH(sale_date)=MONTH(CURDATE()) AND YEAR(sale_date)=YEAR(CURDATE()) AND status='completed'")->fetch()['v'];
$profit=$pdo->query("SELECT COALESCE(SUM((si.unit_price-p.purchase_price)*si.quantity),0) v FROM sale_items si JOIN products p ON p.id=si.product_id JOIN sales s ON s.id=si.sale_id WHERE s.status='completed' AND MONTH(s.sale_date)=MONTH(CURDATE()) AND YEAR(s.sale_date)=YEAR(CURDATE())")->fetch()['v'];
$recent=$pdo->query("SELECT s.*,c.name customer FROM sales s LEFT JOIN customers c ON c.id=s.customer_id ORDER BY s.id DESC LIMIT 7")->fetchAll();
$days=[];$vals=[];
for($i=6;$i>=0;$i--){$d=date('Y-m-d',strtotime("-$i days"));$days[]=date('M d',strtotime($d));$st=$pdo->prepare("SELECT COALESCE(SUM(total),0) v FROM sales WHERE DATE(sale_date)=? AND status='completed'");$st->execute([$d]);$vals[]=(float)$st->fetch()['v'];}
require __DIR__.'/partials/header.php';
?>
<h3 class="fw-bold">Dashboard</h3><p class="text-muted">Overview of your store performance.</p>
<div class="row g-3 mb-4">
<?php foreach([['Customers',$customers,'bi-people'],['Products',$products,'bi-box-seam'],["Today's Sales",'$'.money($today),'bi-cash-stack'],['Low Stock',$low,'bi-exclamation-triangle']] as $k): ?>
<div class="col-6 col-xl-3"><div class="card kpi h-100"><div class="d-flex justify-content-between"><div><div class="text-muted small"><?=$k[0]?></div><div class="stat-number mt-2"><?=$k[1]?></div></div><div class="icon"><i class="bi <?=$k[2]?>"></i></div></div></div></div>
<?php endforeach; ?>
</div>
<div class="row g-3"><div class="col-lg-8"><div class="card p-3"><div class="d-flex justify-content-between"><h6 class="fw-bold">Sales — Last 7 Days</h6><span class="text-muted">This month: $<?=money($month)?></span></div><canvas id="salesChart" height="100"></canvas></div></div>
<div class="col-lg-4"><div class="card p-3 h-100"><h6 class="fw-bold">Monthly Profit</h6><div class="display-6 fw-bold text-success mt-3">$<?=money($profit)?></div><p class="text-muted small">Estimated from completed sales.</p><a href="<?=base_url('reports/index.php')?>" class="btn btn-outline-primary btn-sm">View Reports</a></div></div></div>
<div class="card mt-3"><div class="card-header bg-white"><strong>Recent Sales</strong></div><div class="table-responsive"><table class="table mb-0"><thead><tr><th>Invoice</th><th>Customer</th><th>Total</th><th>Payment</th><th>Date</th></tr></thead><tbody>
<?php foreach($recent as $r): ?><tr><td><a href="<?=base_url('sales/view.php?id='.$r['id'])?>"><?=e($r['invoice_no'])?></a></td><td><?=e($r['customer']??'Walk-in Customer')?></td><td>$<?=money($r['total'])?></td><td><?=e(ucfirst($r['payment_method']))?></td><td><?=e($r['sale_date'])?></td></tr><?php endforeach; ?>
</tbody></table></div></div>
<script>new Chart(document.getElementById('salesChart'),{type:'line',data:{labels:<?=json_encode($days)?>,datasets:[{label:'Sales',data:<?=json_encode($vals)?>,tension:.35,fill:true}]},options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}});</script>
<?php require __DIR__.'/partials/footer.php'; ?>
