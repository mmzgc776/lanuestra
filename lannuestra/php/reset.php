<?php
$ip = $_POST['ip'];
require_once 'db.php';
//Se vuelve a escribir como no editado para que check.php lo restablesca...
updateCustomstatus($ip,1);
require_once("bqos.php");
//Contestamos...
echo "1";
?>