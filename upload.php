<?php
    function getDir($key){
        include 'openDB.php';
        $query = $db->prepare('select dir from dirs where key=:key');
        $query->bindValue(':key', $key, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['dir'];
        include 'closeDB.php';
    }

    function insertFile($filePath){
        include 'openDB.php';
        $key = hash('sha256', $filePath );
        $user = $_SESSION['user'];
        $insert = $db->prepare("insert into files (file, key, users) values ('$filePath', '$key', '$user')" );
        $insert->execute();
        include 'closeDB.php';
    }

    session_start();
    if(isset($_SESSION['user']) && isset($_POST['dir']) ){
        include 'config.php';
        include 'auth.php';
        $uploadDir = getDir($_POST['dir']);
        if(!auth('dir', $_SESSION['user'], $uploadDir)) header('Location: /logout.php');
        $errors = array();
        $file_name = $_FILES['uploadFile']['name'];
        $file_size =$_FILES['uploadFile']['size'];
        $file_tmp =$_FILES['uploadFile']['tmp_name'];
        $file_type=$_FILES['uploadFile']['type'];
    
        if($file_size > $maxUploadSize) $errors[] ="File is too large";

        if(empty($errors)==true){
            move_uploaded_file($file_tmp, $uploadDir . $file_name);
            insertFile($uploadDir . $file_name);
        
        }
    }
    header("Location: /files.php");
?>
