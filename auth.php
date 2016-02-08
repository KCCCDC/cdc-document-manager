<?php
    function auth($type, $user, $target){
        include 'openDB.php';
        switch($type){
            case 'file':
                $query = $db->prepare('select users from files where file=:key');
                $query->bindValue(':key', $target, PDO::PARAM_STR);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $users = explode(",", $result['users']);
                foreach($users as $person){
                    if($person == $user) return 1;
                }
            break;
            
            case 'dir':
                
            break;
        }
        include 'closeDB.php';
    }
?>
