<?php
require __DIR__ . '/../vendor/autoload.php';

// Cargar rutas y despacharlas
$klein = require __DIR__ . '/routes/api.php';
$klein->dispatch();

