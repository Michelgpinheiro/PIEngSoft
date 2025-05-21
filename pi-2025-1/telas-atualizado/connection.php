<?php 

    require_once __DIR__ . '/../php/abstracts/abstract-user.php';
    require_once __DIR__ . '/../php/abstracts/abstract-product.php';
    require_once __DIR__ . '/../php/interfaces/interface-user.php';
    require_once __DIR__ . '/../php/users/admin.php';
    require_once __DIR__ . '/../php/users/physical-person.php';
    require_once __DIR__ . '/../php/users/legal-entity.php';
    require_once __DIR__ . '/../php/functions/functions.php';

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pi-plataforma-leilao";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

?>