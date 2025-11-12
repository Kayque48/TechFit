<?php 

    require_once('../../config/database.php');
    $result = $conn->query('SELECT * FROM aulas');


    while ($row = $result->fetch_assoc()) {
        
    }