<html>
    <head>
        <style>

            body{
                background-color:#005399;
                font-family: sans-serif;
            }
            h3{
                text-align:left;
            }

            .pheader{
                color:#F0B010;
                text-decoration: underline;
                width: 100%;
                font-weight: bold;
                font-size:  175%;
            }
            
            .pitems{
                color: #F0B010;
                font-size: 100%;

            }

            .middleBox{
                margin: 0 0;    
                background-color:rgb(0, 47, 86);
            }
            
            .textBackground{
                background-color:rgb(0, 47, 86); 
            }

            .container{
                overflow: hidden;
                text-align: center;
            }
            .banner{
                float: right;
                width: auto;
                height: 50px;
            }

        </style>
    </head>
</html>
<?php
    function  printFiles($parentPath){
        $directory = array_diff(scandir($parentPath), array('..', '.'));
        $leftNode[] = NULL;
        global $dirList;
        echo("<div class='textBackground'>");
        echo("<form action='download.php' method='post' class='form'>");
        $hasFiles=0;
        foreach($directory as $child){
            if(!is_dir($parentPath . $child)){
                if(auth('file', $_SESSION['user'], $parentPath . $child )){
                    if(!$hasFiles) echo("<p class='pheader'>" . basename($parentPath) . "</p>");
                    echo("<p class='pitems'>" . $child . "<input type='radio' name='file' value='" . hash('sha256', $parentPath . $child) . "'>" . "</p>");
                    $hasFiles=1;
                }
            }else{
                array_push($leftNode, $child);
            }
        }
        if($hasFiles) echo("<input type='submit' value='Download''>");
        echo("</form>");
        echo("</div>");
        foreach($leftNode as $dir){
            if($dir!=NULL){
                array_push($dirList, $parentPath . $dir . '/');
                printFiles($parentPath . $dir . '/');
            
            }
        }
    }
    function printUpload($dirArray){
        echo("<h4>Upload</h4>");
        echo("<form action='upload.php' method='post' enctype='multipart/form-data'> ");
        echo("<select name='dir'> ");
        foreach($dirArray as $dir){
            if(auth('dir', $_SESSION['user'], $dir)){
                echo("<option value='" . hash('sha256', $dir) . "'> " . basename($dir) . "</option>");
            }
        }
        echo("</select><br>");
        echo("<input type='file' name='uploadFile'><br>");
        echo("<input type='submit' value='Upload'>");
        echo("</form>");
    }
    
    session_start();
    include 'config.php';
    include 'auth.php';
    $fileStorage = $fileStorageDirectory;
    if(isset($_SESSION['time']) && (time() - $_SESSION['time'] > $maxSessionTime )){
        header('Location: /logout.php');
        exit;
    }
    if(isset($_SESSION['user'])){
        echo("<html>");
        #echo("You are Logged In!" . "<br>");
        #echo("<br> Available Files:");
        $dirList[] = NULL;
        echo("<div class='container'>");
        echo("<img class='banner'src='/kwood.jpg'></img>");
        echo('<h3>Welcome ' . ucfirst($_SESSION['user']) . ", to the Team3 File Server!</h3>");
        echo("<div class='middleBox'>");
        printFiles($fileStorage);
        printUpload($dirList);
        echo("<br><a href=logout.php>Logout</a>");
        echo("</div></div></hmtl>");
    }else{
        header('Location: /index.php');
    }
?>
