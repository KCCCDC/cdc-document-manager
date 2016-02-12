<?php
    function getFile($key){
        include 'openDB.php';
        $query = $db->prepare('select file from files where key=:key');
        $query->bindValue(':key', $key, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['file'];
        include 'closeDB.php';
    }

    session_start();
    include 'auth.php';
    if(isset($_SESSION['user']) && isset($_POST['file']) ){
        $file = getFile($_POST['file']);
        if(!auth('file', $_SESSION['user'], $file)) header('Location: /logout.php');
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }else{
        header('Location: /files.php');
    }
?>
