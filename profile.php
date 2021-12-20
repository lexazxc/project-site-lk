<?php include('config/db.php'); 
    session_start();
    if(!$_SESSION['email'])
    {
    header('location:/index.php');
    exit();
    } else
?>
<div class="card-1" style="width: 25rem">
                <div class="card-body-1" id="boxslide1" style="display: none;">
                    <div class="text-flex">
                    <h5 class="card-title text-center mb-4">Профиль</h5>
                    <img src="uploads/avatars/<?php echo $_SESSION['photo']; ?>" class="avatar">
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $_SESSION['firstname']; ?>
                        <?php echo $_SESSION['lastname']; ?> </h6>
                    <p class="card-text">Почта: <?php echo $_SESSION['email']; ?></p>
                    <p class="card-text">Номер телефона: <?php echo $_SESSION['mobilenumber']; ?></p>
                    </div>
                </div>
            </div>
            <div class="card" id="menu">
                <button type="submit" name="profile" id="profile" class="butprofile"><span class="material-icons" data_target="dashboard.php">account_circle</span></button>
                <button type="submit" name="settings" id="settings" class="butsettings" data_target="settings.php"><span class="material-icons">settings</span></button>
                <a href="/settings.php" id="link"></a>
                <button type="submit" name="statics" id="statics" class="butstatics"><span class="material-icons">trending_up</span></button>
                <button type="submit" class="butlogout"><a href="logout.php">log</a></button>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $('#boxslide1').slideDown(2000);
                        $('#boxslide2').slideDown(2000);    
                        $('#boxslide3').slideDown(2000);
                    });
                    $(document).ready(function(){
                        $('#settings').on('click',function(){
                            $('#boxslide1').slideUp(2000);
                            $('#boxslide2').slideUp(2000);
                            $('#boxslide3').slideUp(2000);
                            $('#menu').animate({ left: -410 }, 2200, function() {});
                            window.setTimeout(function(){
                                $.ajax({
                                    url: ('settings.php'),
                                    cache: false,
                                    success: function(html) {
                                    $("#flex").html(html);
                                    }
                                });
                            }, 1980);
                        });
                    });
                    $(document).ready(function(){
                        $('#profile').on('click',function(){
                            window.setTimeout(function(){
                                $.ajax({
                                    url: ('profile.php'),
                                    cache: false,
                                    success: function(html) {
                                    $("#flex").html(html);
                                    }
                                });
                            }, 1);
                        });
                    });
                </script>
            </div>
            <div class="card-2" style="width: 25rem">
                <div class="card-body-2-1" id="boxslide2" style="display: none;">
                <div class="text-flex">
                    <h6 class="card-subtitle mb-2 text-muted">Интресы:</h6>
                    <p class="card-text"><?php echo $_SESSION['interests']; ?></p>
                    <h6 class="card-subtitle mb-2 text-muted">Соцсети:</h6>
                    <p class="card-text"><a href="http://vk.com/<?php echo $_SESSION['vk']; ?>">vk</a></p>
                    <p class="card-text"><a href="http://facebook.com/profile.php?id=<?php echo $_SESSION['facebook']; ?>">facebook</a></p>
                    <p class="card-text"><a href="http://instagram.com/<?php echo $_SESSION['instagram']; ?>">instagram</a></p>
                    <p id="demo"></p>
                </div>
                </div>
                <div class="card-body-2-2" id="boxslide3" style="display: none;">
                <div class="text-flex">
                    <p class="card-text">День рождения: <?php echo $_SESSION['birthday']; ?></p>
                    <p class="card-text">Начала обучение: <?php echo $_SESSION['start_of_studies']; ?></p>
                    <p class="card-text">Группа: <?php echo $_SESSION['group']; ?></p>
                </div>
                </div>
            </div>
        </div>
    </div>