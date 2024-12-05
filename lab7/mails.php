<?php
$recipients = '';
$subject = '';
$message = '';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipients = trim($_POST['recipients']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (empty($recipients) || empty($subject) || empty($message)) {
        $error = 'Все поля должны быть заполнены!';
    } else {
        $recipientsArray = preg_split('/[\s,;]+/', $recipients);

        $validEmails = [];
        foreach ($recipientsArray as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $validEmails[] = $email;
            } else {
                $error = 'Один или несколько адресов электронной почты недействительны.';
                break;
            }
        }

        if (empty($error)) {

            $headers = 'From: my-email@gmail.com' . "\r\n" .
                'Reply-To: my-email@gmail.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            foreach ($validEmails as $email) {
                mail($email, $subject, $message, $headers);
            }

            file_put_contents('recipients.txt', implode(PHP_EOL, $validEmails), FILE_APPEND | LOCK_EX);

            $recipients = $subject = $message = '';
            $success = 'Сообщение успешно отправлено!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Отправка письма</title>
</head>
<body>
<?php if (!empty($error)): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <p style="color: green;"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>
<form method="post">
    <label for="recipients">Получатели:</label>
    <input type="text" id="recipients" name="recipients" value="<?= htmlspecialchars($recipients) ?>"><br>
    <label for="subject">Тема:</label>
    <input type="text" id="subject" name="subject" value="<?= htmlspecialchars($subject) ?>"><br>
    <label for="message">Текст сообщения:</label>
    <textarea id="message" name="message"><?= htmlspecialchars($message) ?></textarea><br>
    <button type="submit">Отправить</button>
</form>
</body>
</html>
