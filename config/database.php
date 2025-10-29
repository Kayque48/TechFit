<?php
    
    define('HOST', 'localhost');
    define('USER', 'root');
    define('PASS', 'senaisp');
    define('DB', 'techfit');

    $charset = "utf8";
    $conn = mysqli_connect(HOST, USER, PASS, DB)
        or die('Erro de conexão');

?>