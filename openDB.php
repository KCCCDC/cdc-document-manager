<?php
    try{
        $db = new PDO("sqlite:fileServer.db");
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
?>
