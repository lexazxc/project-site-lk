<?php include('config/db.php'); 
    session_start();
    if(!$_SESSION['email'])
    {
    header('location:/index.php');
    exit();
    }
?>
            <div class="card" style="left: -410" id="menu">
                <button type="submit" name="profile" id="profile" class="butprofile_s"><span class="material-icons">account_circle</span></button>
                <button type="submit" name="settings" id="settings" class="butsettings_s"><span class="material-icons">settings</span></button>
                <button type="submit" name="statics" id="statics" class="butstatics_s"><span class="material-icons">trending_up</span></button>
                <button type="submit" class="butlogout"><a href="logout.php">log</a></button>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $('#boxslide_s').slideDown(2000);
                    });
                    $(document).ready(function(){
                        $('#profile').on('click',function(){
                            $('#boxslide_s').slideUp(2000);
                            $('#menu').animate({ left: +410 }, 2200, function() {});
                            window.setTimeout(function(){
                                $.ajax({
                                    url: ('profile.php'),
                                    cache: false,
                                    success: function(html) {
                                    $("#flex").html(html);
                                    }
                                });
                            }, 1780);
                        });
                    });
                    $(document).ready(function(){
                        $('#settings').on('click',function(){
                            window.setTimeout(function(){
                                $.ajax({
                                    url: ('settings.php'),
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
            <div class="card_s" id="boxslide_s" style="display: none;">
            <form class="settings_icon" method="post" action="/save_reviews.php">
                <div class="form-row">
		            <div class="img-list" id="js-file-list"></div>
		            <input id="js-file" type="file" name="file[]" multiple accept=".jpg,.jpeg,.png">
	            </div>
                <div class="form-submit">
		            <input type="submit" name="send" value="Отправить">
	            </div>
            </form>
            <form class="settings_info" method="post" action="/info.php">
                    <span style="color: #fff; margin-left: 3px;">Интересы</span><br>
                <input type="text" class="interests" name="interests" id="interests" /><br>
                    <span style="color: #fff; margin-left: 3px;">вк</span><br>
                <input type="text" class="social" name="vk" id="vk" /><br>
                    <span style="color: #fff; margin-left: 3px;">Инста</span><br>
                <input type="text" class="social" name="instagram" id="instagram" /><br>
                    <span style="color: #fff; margin-left: 3px;">фейсбук</span><br>
                <input type="text" class="social" name="facebook" id="facebook" /><br>
                <input type="submit" name="send" value="Отправить">
            </form>
            <script>
            $("#js-file").change(function(){
                if (window.FormData === undefined) {
                    alert('В вашем браузере загрузка файлов не поддерживается');
                } else {
                    var formData = new FormData();
                    $.each($("#js-file")[0].files, function(key, input){
                        formData.append('file[]', input);
                    });
            
                    $.ajax({
                        type: 'POST',
                        url: '/upload_image.php',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        dataType : 'json',
                        success: function(msg){
                            msg.forEach(function(row) {
                                if (row.error == '') {
                                    $('#js-file-list').append(row.data);
                                } else {
                                    alert(row.error);
                                }
                            });
                            
                        }
                    });
                }
            });
            
            /* Удаление загруженной картинки */
            function remove_img(target){
                $(target).parent().remove();
            }
            </script>
            </div>
            </div>
    </div>