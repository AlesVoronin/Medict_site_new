<?php
// Файлы phpmailer
require 'assets/php/PHPMailer.php';
require 'assets/php/SMTP.php';
require 'assets/php/Exception.php';

// Переменные, которые отправляет пользователь
$name = $_POST['name'];
$number = $_POST['number'];
$email = $_POST['email'];
$text = $_POST['text'];
// $file = $_FILES['file'];

// Формирование самого письма
$title = "Заголовок письма";
$body = "
<h2>Заявка на демонстрацию</h2>
<b>Имя:</b> $name<br>
<b>Номер:</b> $number<br>
<b>Почта:</b> $email<br><br>
<b>Сообщение:</b><br>$text
";

// Валидация почты
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'mail.comrad.by'; // SMTP сервера вашей почты
    $mail->Username   = 'a.voronin'; // Логин на почте
    $mail->Password   = '9{v+lE2GFc'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('a.voronin@comrd.by', 'ООО «Медикт» умные операционные'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('alesworonin@gmail.com');
//     $mail->addAddress('youremail@gmail.com'); // Ещё один, если нужен

    // Прикрипление файлов к письму
if (!empty($file['name'][0])) {
    for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
        $uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
        $filename = $file['name'][$ct];
        if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
            $rfile[] = "Файл $filename прикреплён";
        } else {
            $rfile[] = "Не удалось прикрепить файл $filename";
        }
    }
}
// Отправка сообщения
$mail->isHTML(true);
$mail->Subject = $title;
$mail->Body = $body;

// Проверяем отравленность сообщения
if ($mail->send()) {$result = "success";}
else {$result = "error";}

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}
} else {
	$result = "email";
}
// Отображение результата
echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);

?>
