<?php
    include 'config.php';
    try{
        $db = new PDO("sqlite:" . $databaseLocation);
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
?>
