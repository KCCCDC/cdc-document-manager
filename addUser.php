<html>
    <?php include 'openDB.php' ?>

    <?php
        if(isset($_POST['user']) && isset($_POST['passwd'])  ){
            $username = strtolower($_POST['user']);
            $password = password_hash($_POST['passwd'], PASSWORD_DEFAULT);
            $insert = $db->prepare("insert into users (username, pass) values ('$username', '$password' )" );
            $insert->execute();
        }
    
    ?>

    <?php include 'closeDB.php' ?>
<html>
