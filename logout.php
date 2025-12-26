<?php
session_start();
session_unset(); // Menghapus variabel session
session_destroy(); // Menghancurkan session
header("Location: login.php");
exit();
?>