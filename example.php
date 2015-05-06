<?php
set_include_path(" ");


require_once 'Catchr/Autoloader.php';
Catchr_Autoloader::register();


$handler = new Catchr_Handler();
$handler->handleErrors();

echo 'before error<br>';
echo $undefined;
echo 'after error';
?>