<?php
    function  printFiles($parentPath){
        $directory = array_diff(scandir($parentPath), array('..', '.'));
        $leftNode[] = NULL;
        global $dirList;
        echo("<form action='download.php' method='post'> ");
        $hasFiles=0;
        foreach($directory as $child){
            if(!is_dir($parentPath . $child)){
                if(auth('file', $_SESSION['user'], $parentPath . $child )){
                    if(!$hasFiles) echo("-----" . basename($parentPath) . "-----<br>");
                    echo($child . "<input type='radio' name='file' value='" . hash('sha256', $parentPath . $child) . "'>" . "<br>");
                    $hasFiles=1;
                }
            }else{
                array_push($leftNode, $child);
            }
        }
        if($hasFiles) echo("<input type='submit' value='Download''>");
        echo("</form>");
        foreach($leftNode as $dir){
            if($dir!=NULL){
                array_push($dirList, $parentPath . $dir . '/');
                printFiles($parentPath . $dir . '/');
            
            }
        }
    }
    function printUpload($dirArray){
        echo("<br><br>-----Upload-----");
        echo("<form action='upload.php' method='post' enctype='multipart/form-data'> ");
        echo("<select name='dir'> ");
        foreach($dirArray as $dir){
            if(auth('dir', $_SESSION['user'], $dir)){
                echo("<option value='" . $dir . "'> " . basename($dir) . "</option>");
            }
        }
        echo("</select><br>");
        echo("<input type='file' name='uploadFile'><br>");
        echo("<input type='submit' value='Upload'> ");
        echo("</form>");
    }


    
    session_start();
    include 'config.php';
    include 'auth.php';
    $fileStorage = $fileStorageDirectory;
    if(isset($_SESSION['user'])){
        echo('Welcome ' . $_SESSION['user'] . "<br>");
        echo("You are Logged In!" . "<br>");
        echo("<br> Available Files: <br>");
        $dirList[] = NULL;
        printFiles($fileStorage);
        printUpload($dirList);
    }else{
        header('Location: /index.php');
    }
?>
