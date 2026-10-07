<?php
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../config/auth.php';
if (!empty($_SESSION['user'])) { header("Location: ".base_url("dashboard.php")); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $st = $pdo->prepare("SELECT id,name,email,password,role,status FROM users WHERE email=? LIMIT 1");
    $st->execute([$email]);
    $u = $st->fetch();
    if ($u && $u['status']==='active' && password_verify($password,$u['password'])) {
        unset($u['password']);
        $_SESSION['user']=$u;
        header("Location: ".base_url("dashboard.php")); exit;
    }
    $error='Invalid email or password.';
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>ProStock POS - Login</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="../assets/css/style.css" rel="stylesheet"></head>
<body class="login-bg"><div class="login-card card shadow-lg border-0"><div class="card-body p-4 p-md-5">
<div class="brand text-center mb-4"><div class="brand-mark">P</div><h3 class="fw-bold mb-0">ProStock POS</h3><small class="text-muted">Inventory & Sales Management</small></div>
<?php if($error): ?><div class="alert alert-danger"><?=e($error)?></div><?php endif; ?>
<form method="post"><div class="mb-3"><label class="form-label">Email</label><input class="form-control form-control-lg" type="email" name="email" value="admin@prostock.local" required></div>
<div class="mb-3"><label class="form-label">Password</label><input class="form-control form-control-lg" type="password" name="password" value="Admin123!" required></div>
<button class="btn btn-primary btn-lg w-100">Sign In</button></form>
<div class="text-center mt-3 small text-muted">Demo: admin@prostock.local / Admin123!</div>
</div></div></body></html>
