<?php
require_once __DIR__.'/config/auth.php';
if (!empty($_SESSION['user'])) { header("Location: ".base_url("dashboard.php")); exit; }
header("Location: ".base_url("auth/login.php"));
exit;
