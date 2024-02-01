<?php 
require_once realpath('./vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable('./');

$dotenv -> load();


echo $_ENV['MI_VARIABLE_ENTORNO']

?>