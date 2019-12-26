<?php

require_once __DIR__ . '/../vendor/autoload.php';
# Move config.php.example to config.php
require_once __DIR__ . '/config.php';

use Kelkoo\Product;

$product = new Product(KELKOO_KEY,KELKOO_TRACKING_ID,KELKOO_COUNTRY);

$parameters = [
	'query' => 'apple ipad',
	'results' => 10,
	'show_subcategories' => 1,
	'show_products' => 1,
	'show_refinements' => 1,
];

$product->search($parameters,'json');