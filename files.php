<?php
    function  printFiles($parentPath){
        $directory = array_diff(scandir($parentPath), array('..', '.'));
        $leftNode[] = NULL;
        echo("<form action='download.php' method='post'> ");
        foreach($directory as $child){
            if(!is_dir($parentPath . $child)){
                echo($child . "<input type='radio' name='file' value=' " . $parentPath . $child . " ' >" . "<br>");
            }else{
                array_push($leftNode, $child);
            }
        }
        echo("<input type='submit' value='Download''>");
        echo("</form>");
        foreach($leftNode as $dir){
            if($dir!=NULL){
                echo("-----" . $dir . "-----<br>");
                printFiles($parentPath . $dir . '/');
            
            }
        }
    }
    
    session_start();
    $fileStorage = '/srv/files/';
    if(isset($_SESSION['user'])){
        echo('Welcome ' . $_SESSION['user'] . "<br>");
        echo("You are Logged In!" . "<br>");
        echo("<br> Available Files: <br>");
        printFiles($fileStorage);
    }else{
        header('Location: /index.php');
    }
?>
