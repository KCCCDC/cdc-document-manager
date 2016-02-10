<?php
    function  grabFiles($parentPath){
        $directory = array_diff(scandir($parentPath), array('..', '.'));
        $leftNode[] = NULL;
        foreach($directory as $child){
            if(!is_dir($parentPath . $child)){
                generateInsert($parentPath . $child);
            }else{
                generateDirInsert($parentPath . $child . '/');
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

    function generateDirInsert($filePath){
        include 'openDB.php';

        $key = hash('sha256', $filePath);
        $insert = $db->prepare("insert into dirs (dir, key) values ('$filePath', '$key')");
        $insert->execute();
        include 'closeDB.php';
    }
    include 'config.php';
    grabFiles($fileStorageDirectory);
    echo('DONE!');
?>
