<?php
    function auth($type, $user, $target){
        include 'openDB.php';
        if($type == 'file'){
            $query = $db->prepare('select users from files where file=:key');
        }elseif($type == 'dir'){
            $query = $db->prepare('select users from dirs where dir=:key');
        }
        $query->bindValue(':key', $target, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $users = explode(",", $result['users']);
        foreach($users as $person){
            if($person == $user) return 1;
        }
        return 0;
        include 'closeDB.php';
    }
?>
