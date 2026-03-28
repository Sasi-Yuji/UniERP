<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'University ERP' ?></title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <!-- External Dependencies -->
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <a href="<?= base_url('/') ?>" class="nav-logo">
            <?= get_icon('academic') ?>
            <span>UniERP</span>
        </a>
        <ul class="nav-links">
            <li><a href="<?= base_url('/') ?>">Dashboard</a></li>
            <li><a href="<?= base_url('/student') ?>">Students</a></li>
            <li><a href="<?= base_url('/employee') ?>">Employees</a></li>
            <li><a href="<?= base_url('/course') ?>">Courses</a></li>
            <li><a href="<?= base_url('/product') ?>">Products</a></li>
            <li><a href="<?= base_url('/incident') ?>">Incidents</a></li>
        </ul>
    </div>
</nav>
