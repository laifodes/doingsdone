<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'siyrtbym_m1');

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else {
    mysqli_set_charset($con, "utf8");
}
