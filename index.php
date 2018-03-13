<?php
// PSR15 - CSRF
use Gc7\Functions;
use PHPUnit\Framework\TestSuite;

require 'vendor/autoload.php';

//echo \Gc7\Math::double(21);


echo 'Page title: ' . Functions::pageTitle() . '<hr>';

$d = explode('\\', __DIR__);
$d = end($d);
?><h2><a href="//<?= $d ?>/cov" target="_blank">Coverage</a></h2>
