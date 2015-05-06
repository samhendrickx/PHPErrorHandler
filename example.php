<?php
set_include_path(" ");


require_once 'PHPErrorHandler/Autoloader.php';
PHPErrorHandler_Autoloader::register();


$handler = new PHPErrorHandler_Handler();
$handler->handleErrors();

echo 'before error<br>';
echo $undefined;
echo 'after error';
?>