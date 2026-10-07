<?php
require_once __DIR__.'/../config/database.php'; require_once __DIR__.'/../config/auth.php';
$id=(int)($_GET['id']??0);
try{$pdo->prepare("DELETE FROM products WHERE id=?")->execute([$id]);flash('success','Product deleted.');}catch(Exception $e){flash('danger','Cannot delete a product already used in sales.');}
header("Location: index.php");exit;
