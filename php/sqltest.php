<?php
require('db_connection.php');

$serial = getSerialKey();

echo $serial;
echo '<br>';

if(empty($serial)){
    echo "no serial key";
}else{
    echo "serial key=".$serial;
}