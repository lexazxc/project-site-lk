<?php include('config/db.php');
session_start();
 
// Временная директория.
$tmp_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/avatars/tmp/';
 
// Постоянная директория.
$path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/avatars/';

$id_user = $_SESSION['id'];
if (isset($_POST['send'])) {
	// Сохранение изображений в БД и перенос в постоянную папку.
	if (!empty($_POST['images'])) {
		foreach ($_POST['images'] as $row) {
			$filename = preg_replace("/[^a-z0-9\.-]/i", '', $row);
			if (!empty($filename) && is_file($tmp_path . $filename)) {
                $sql = "UPDATE users SET photo = '{$filename}' WHERE id = '{$id_user}'";
                mysqli_query($connection, $sql);
				rename($tmp_path . $filename, $path . $filename);
                $file_name = pathinfo($filename, PATHINFO_FILENAME);				
				$file_ext = pathinfo($filename, PATHINFO_EXTENSION);
				$thumb = $file_name . '-thumb.' . $file_ext;
				unlink($tmp_path . $thumb);
			}
		}
	}
}

header('Location: /logout.php', true, 301);
exit();
?>