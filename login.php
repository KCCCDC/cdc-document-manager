<?php include 'openDB.php' ?>
<?php
    session_start();
    if(isset($_POST['user']) && isset($_POST['passwd']) ){
        $username = $_POST['user'];
        $query = $db->prepare('select * from users where username=:username');
        $query->execute(array(':username' => $username));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $login = password_verify($_POST['passwd'], $result['pass']);
        if($login == 1){
            $_SESSION['user'] = $username;
        }
    }
?>    
<? include 'closeDB.php'?>


<?php
    if(isset($_SESSION['user']) ){
        header('Location: /files.php');
    }else{
        header('Location: /index.php');
    }
?>

<html>

</html>
