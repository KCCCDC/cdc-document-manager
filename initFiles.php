<?php
    function  grabFiles($parentPath){
        $directory = array_diff(scandir($parentPath), array('..', '.'));
        $leftNode[] = NULL;
        foreach($directory as $child){
            if(!is_dir($parentPath . $child)){
                generateInsert($parentPath . $child);
            }else{
                array_push($leftNode, $child);
            }
        }
        foreach($leftNode as $dir){
            if($dir!=NULL){
                grabFiles($parentPath . $dir . '/');
            
            }
        }
    }
    
    function generateInsert($filePath){
        include 'openDB.php';
        $key = hash('sha256', $filePath );
        $insert = $db->prepare("insert into files (file, key) values ('$filePath', '$key' )" );
        $insert->execute();
        include 'closeDB.php';
    }
    grabFiles("/srv/files/");
    echo('DONE!');
?>
