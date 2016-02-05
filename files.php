<?php
    session_start();
    if(isset($_SESSION['user'])){
        echo('Welcome ' . $_SESSION['user'] . "<br>");
        echo("You are Logged In!");
    }
