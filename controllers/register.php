<?php
   
    include('config/db.php');

    require_once './lib/vendor/autoload.php';
    
    global $success_msg, $email_exist, $f_NameErr, $l_NameErr, $_emailErr, $_mobileErr, $_passwordErr;
    global $fNameEmptyErr, $lNameEmptyErr, $emailEmptyErr, $mobileEmptyErr, $passwordEmptyErr, $email_verify_err, $email_verify_success;
    
    $_first_name = $_last_name = $_email = $_mobile_number = $_password = "";

    if(isset($_POST["submit"])) {
        $firstname     = $_POST["firstname"];
        $lastname      = $_POST["lastname"];
        $email         = $_POST["email"];
        $mobilenumber  = $_POST["mobilenumber"];
        $password      = $_POST["password"];
        $email_check_query = mysqli_query($connection, "SELECT * FROM users WHERE email = '{$email}' ");
        $rowCount = mysqli_num_rows($email_check_query);

        if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($mobilenumber) && !empty($password)){

            if($rowCount > 0) {
                $email_exist = '
                    <div class="alert alert-danger" role="alert">
                        Пользователь с такой электронной почтой уже существует!
                    </div>
                ';
            } else {
                $_first_name = mysqli_real_escape_string($connection, $firstname);
                $_last_name = mysqli_real_escape_string($connection, $lastname);
                $_email = mysqli_real_escape_string($connection, $email);
                $_mobile_number = mysqli_real_escape_string($connection, $mobilenumber);
                $_password = mysqli_real_escape_string($connection, $password);

                if(!preg_match("/^[a-zA-Z ]*$/", $_first_name)) {
                    $f_NameErr = '<div class="alert alert-danger">
                            Разрешены только буквы и пробелы.
                        </div>';
                }
                if(!preg_match("/^[a-zA-Z ]*$/", $_last_name)) {
                    $l_NameErr = '<div class="alert alert-danger">
                            Разрешены только буквы и пробелы.
                        </div>';
                }
                if(!filter_var($_email, FILTER_VALIDATE_EMAIL)) {
                    $_emailErr = '<div class="alert alert-danger">
                            Неверный формат электронной почты.
                        </div>';
                }
                if(!preg_match("/^[0-9]{12}+$/", $_mobile_number)) {
                    $_mobileErr = '<div class="alert alert-danger">
                            Разрешены только 12-значные мобильные номера.
                        </div>';
                }
                if(!preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,20}$/", $_password)) {
                    $_passwordErr = '<div class="alert alert-danger">
                        Пароль должен содержать от 6 до 20 символов. Должен содержать как минимум один специальный символ, нижний регистр, верхний регистр и цифру.
                        </div>';
                }
                
                if((preg_match("/^[a-zA-Z ]*$/", $_first_name)) && (preg_match("/^[a-zA-Z ]*$/", $_last_name)) &&
                 (filter_var($_email, FILTER_VALIDATE_EMAIL)) && (preg_match("/^[0-9]{12}+$/", $_mobile_number)) && 
                 (preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/", $_password))){

                    $token = md5(rand().time());

                    $password_hash = password_hash($password, PASSWORD_BCRYPT);

                    $sql = "INSERT INTO users (firstname, lastname, email, mobilenumber, password, token, is_active,
                    date_time, photo, perms) VALUES ('{$firstname}', '{$lastname}', '{$email}', '{$mobilenumber}', '{$password_hash}', 
                    '{$token}', '0', now(), 'noavatar.png' 'stud' )";
                    
                    $sqlQuery = mysqli_query($connection, $sql);
                    
                    if(!$sqlQuery){
                        die("MySQL query failed!" . mysqli_error($connection));
                    } 

                    if($sqlQuery) {
                        $msg = 'Нажмите на ссылку активации, чтобы подтвердить свой адрес электронной почты. <br><br>
                          <a href="http://localhost/user_verificaiton.php?token='.$token.'"> Нажмите здесь, чтобы подтвердить электронную почту</a>
                        ';
                        
                        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                        ->setUsername('test473541321@gmail.com                        ')
                        ->setPassword('473541321');

                        $mailer = new Swift_Mailer($transport);

                        $message = (new Swift_Message('Пожалуйста, подтвердите адрес электронной почты!'))
                        ->setFrom([$email => $firstname . ' ' . $lastname])
                        ->setTo($email)
                        ->addPart($msg, "text/html")
                        ->setBody('Привет! Пользователь');

                        $result = $mailer->send($message);
                          
                        if(!$result){
                            $email_verify_err = '<div class="alert alert-danger">
                                    Письмо с подтверждением не может быть отправлено!
                            </div>';
                        } else {
                            $email_verify_success = '<div class="alert alert-success">
                                Письмо с подтверждением отправлено!
                            </div>';
                        }
                    }
                }
            }
        } else {
            if(empty($firstname)){
                $fNameEmptyErr = '<div class="alert alert-danger">
                    First name can not be blank.
                </div>';
            }
            if(empty($lastname)){
                $lNameEmptyErr = '<div class="alert alert-danger">
                    Last name can not be blank.
                </div>';
            }
            if(empty($email)){
                $emailEmptyErr = '<div class="alert alert-danger">
                    Email can not be blank.
                </div>';
            }
            if(empty($mobilenumber)){
                $mobileEmptyErr = '<div class="alert alert-danger">
                    Mobile number can not be blank.
                </div>';
            }
            if(empty($password)){
                $passwordEmptyErr = '<div class="alert alert-danger">
                    Password can not be blank.
                </div>';
            }            
        }
    }
?>