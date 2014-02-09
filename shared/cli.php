<?php

$config_file = $argv[1];
$config = null;

if( file_exists($config_file) == false ){
    echo "Configuration file not found\n\t".$config_file;
    exit(1);
}
$config = json_decode( file_get_contents($config_file) );

include("php/iodocs.php");


