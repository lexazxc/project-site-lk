<?php
   
    include('config/db.php');

    global $wrongPwdErr, $accountNotExistErr, $emailPwdErr, $verificationRequiredErr, $email_empty_err, $pass_empty_err;

    if(isset($_POST['login'])) {
        $email_signin        = $_POST['email_signin'];
        $password_signin     = $_POST['password_signin'];

        $user_email = filter_var($email_signin, FILTER_SANITIZE_EMAIL);
        $pswd = mysqli_real_escape_string($connection, $password_signin);

        $sql = "SELECT * From users WHERE email = '{$email_signin}' ";
        $query = mysqli_query($connection, $sql);
        $rowCount = mysqli_num_rows($query);

        if(!$query){
           die("SQL query failed: " . mysqli_error($connection));
        }

        if(!empty($email_signin) && !empty($password_signin)){
            if(!preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,20}$/", $pswd)) {
                $wrongPwdErr = '<div class="alert alert-danger">
                Пароль должен содержать от 6 до 20 символов, содержать как минимум один специальный символ, буквы нижнего и верхнего регистра и цифру.
                    </div>';
            }
            if($rowCount <= 0) {
                $accountNotExistErr = '<div class="alert alert-danger">
                        Учетная запись пользователя не существует.
                    </div>';
            } else {
                while($row = mysqli_fetch_array($query)) {
                    $id            = $row['id'];
                    $firstname     = $row['firstname'];
                    $lastname      = $row['lastname'];
                    $email         = $row['email'];
                    $mobilenumber  = $row['mobilenumber'];
                    $pass_word     = $row['password'];
                    $token         = $row['token'];
                    $is_active     = $row['is_active'];
                    $group         = $row['group'];
                    $perms         = $row['perms'];
                    $photo         = $row['photo'];
                    $birthday      = $row['birthday'];
                    $appraisals    = $row['appraisals'];
                    $start_of_studies   = $row['start_of_studies'];
                    $date_login    = $row['date_login'];
                    $interests     = $row['interests'];
                    $vk            = $row['vk'];
                    $facebook      = $row['facebook'];
                    $instagram     = $row['instagram'];
                }

                $password = password_verify($password_signin, $pass_word);

                if($is_active == '1') {
                    if($email_signin == $email && $password_signin == $password) {
                       header("Location: ./dashboard.php");
                       
                       $_SESSION['id'] = $id;
                       $_SESSION['firstname'] = $firstname;
                       $_SESSION['lastname'] = $lastname;
                       $_SESSION['email'] = $email;
                       $_SESSION['mobilenumber'] = $mobilenumber;
                       $_SESSION['token'] = $token;
                       $_SESSION['group'] = $group;
                       $_SESSION['perms'] = $perms;
                       $_SESSION['photo'] = $photo;
                       $_SESSION['birthday'] = $birthday;
                       $_SESSION['appraisals'] = $appraisals;
                       $_SESSION['start_of_studies'] = $start_of_studies;
                       $_SESSION['date_login'] = $date_login;
                       $_SESSION['interests'] = $interests;
                       $_SESSION['vk'] = $vk;
                       $_SESSION['facebook'] = $facebook;
                       $_SESSION['instagram'] = $instagram;

                    } else {
                        $emailPwdErr = '<div class="alert alert-danger">
                                Электронная почта или пароль неверны.
                            </div>';
                    }
                } else {
                    $verificationRequiredErr = '<div class="alert alert-danger">
                        Для входа в систему требуется подтверждение учетной записи.
                        </div>';
                }

            }

        } else {
            if(empty($email_signin)){
                $email_empty_err = "<div class='alert alert-danger email_alert'>
                    Электронная почта не указана.
                    </div>";
            }
            
            if(empty($password_signin)){
                $pass_empty_err = "<div class='alert alert-danger email_alert'>
                    Пароль не указан.
                        </div>";
            }            
        }

    }

?>    