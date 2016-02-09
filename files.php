<?php
    function  printFiles($parentPath){
        #include 'auth.php';
        $directory = array_diff(scandir($parentPath), array('..', '.'));
        $leftNode[] = NULL;
        global $dirList;
        echo("<form action='download.php' method='post'> ");
        foreach($directory as $child){
            if(!is_dir($parentPath . $child)){
                if(auth('file', $_SESSION['user'], $parentPath . $child )) echo($child . "<input type='radio' name='file' value='" . hash('sha256', $parentPath . $child) . "'>" . "<br>");
            }else{
                array_push($leftNode, $child);
            }
        }
        echo("<input type='submit' value='Download''>");
        echo("</form>");
        foreach($leftNode as $dir){
            if($dir!=NULL){
                array_push($dirList, $parentPath . $dir . '/');
                echo("-----" . $dir . "-----<br>");
                printFiles($parentPath . $dir . '/');
            
            }
        }
    }
    function printUpload($dirArray){
        echo("<form action='upload.php' method='post'> ");
        echo("<select name='dir'> ");
        foreach($dirArray as $dir){
            echo("<option value='" . $dir . "'> " . basename($dir) . "</option>");
        }
        echo("</select>");
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
