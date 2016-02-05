<html>
    <?php include 'openDB.php' ?>
    <?php
        if(isset($_POST['user']) && isset($_POST['passwd']) ){
            $username = $_POST['user'];
            $query = $db->prepare('select * from users where username=:username');
            $query->execute(array(':username' => $username));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $login = password_verify($_POST['passwd'], $result['pass']);
            echo($login);
        }
    ?>    

<? include 'closeDB.php'?>
</html>
