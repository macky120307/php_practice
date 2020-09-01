<?php 
    try {
        $dsn = 'mysql:host=db;dbname=docker_db;';
        $db = new PDO($dsn, 'docker_user', 'docker_pass');
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }