<?php
    session_start();     
    if($_SESSION['email'])
    {
        session_destroy();
    header('location:/index.php'); //переадресация на страницу входа
    exit();
    }
;?>