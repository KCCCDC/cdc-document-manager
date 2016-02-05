<?php
    session_start();
    if(isset($_SESSION['user'])){
        header('Location: /files.php');
    }

?>

<html>
    <body>
    <div>
        Team 3 File Server
    </div>
    <div>
        <form action="login.php" method="post">
                Username:<input type="text" name='user'><br/>
                Password:<input type="password" name='passwd'><br/>
                <input type="submit" value="Log in">
        </form>
    </div>
    </body>
</html>
