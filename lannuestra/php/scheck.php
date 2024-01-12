<?php
session_start();
if(isset($_SESSION["admin"])){
	echo $_SESSION["admin"];
}
else {
	echo 0;
	}
?>