<?php
session_start();

// Очистка сессии
$_SESSION = [];
header("Location: /guest.php");
