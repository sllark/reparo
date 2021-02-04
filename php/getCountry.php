<?php


print_r($_SERVER);

$ip=null; // the IP address to query
if (!empty($_REQUEST['REMOTE_ADDR'])) {
    $ip = $_REQUEST['REMOTE_ADDR'];
};

$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
if($query && $query['status'] == 'success') {
    echo $query['country'];
} else {
    echo 0;
}

?>