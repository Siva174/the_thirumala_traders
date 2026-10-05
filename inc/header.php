<?php
require_once __DIR__ . '/functions.php';
$base = $base ?? '';
$page = $page ?? '';
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title ?? SHOP_NAME) ?> | <?= e(SHOP_NAME) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= $base ?>assets/style.css">
</head>
<body>
<header class="site-head">
  <a class="brand" href="<?= $base ?>index.php"><img src="<?= $base ?>assets/logo.svg" alt="" width="44" height="44"><span><?= e(SHOP_NAME) ?></span></a>
  <button class="menu-btn" aria-label="Menu" onclick="document.body.classList.toggle('nav-open')">☰</button>
  <nav>
    <a href="<?= $base ?>index.php" class="<?= $page==='home'?'on':'' ?>">Home</a>
    <a href="<?= $base ?>products.php" class="<?= $page==='products'?'on':'' ?>">Products</a>
    <a href="<?= $base ?>about.php" class="<?= $page==='about'?'on':'' ?>">About us</a>
  </nav>
</header>
<main>
