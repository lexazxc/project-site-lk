<?php 
    include('config/db.php');
    session_start();

    $_interests = $_vk = $_facebook = $_instagram = "";
    
    $id_user = $_SESSION['id'];
    if(isset($_POST["submit"])) {
        $interests     = $_POST["interests"];
        $vk      = $_POST["vk"];
        $facebook         = $_POST["facebook"];
        $instagram  = $_POST["instagram"];

        $_interests = mysqli_real_escape_string($connection, $interests);
        $_vk = mysqli_real_escape_string($connection, $vk);
        $_facebook = mysqli_real_escape_string($connection, $facebook);
        $_instagram = mysqli_real_escape_string($connection, $instagram);

        /*if((preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])$/", $_interests)))*/
                $sql_interests = "UPDATE users SET interests = '{$interests}' WHERE id = '{$id_user}'";
                mysqli_query($connection, $sql_interests);
        

                $sql_vk = "UPDATE users SET vk = '{$vk}' WHERE id = '{$id_user}'";
                mysqli_query($connection, $sql_vk);
        
        
                $sql_facebook = "UPDATE users SET facebook = '{$facebook}' WHERE id = '{$id_user}'";
                mysqli_query($connection, $sql_facebook);
        
        

                $sql_instagram = "UPDATE users SET instagram = '{$instagram}' WHERE id = '{$id_user}'";
                mysqli_query($connection, $sql_instagram);
        
        

    }

    header('Location: /dashboard.php', true, 301);
exit();
    
?>