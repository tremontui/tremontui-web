<?php

require_once( './autoload.php' );

DEFINE( "SUPER_ROOT", $_SERVER['DOCUMENT_ROOT'] . '/../' );

$api_ini = parse_ini_file( SUPER_ROOT . 'config/api_config.ini' );

?>