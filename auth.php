<?php
require_once("init.php");

$errors = [];
$error_message = "";

// Проверяем подключение к базе
if ($con === false) {
    // Ошибка подключения к MySQL
    print_r('Ошибка подключения к базе');
} 
elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_guest = $_POST;

    // Валидация
    // Список обязательных к заполнению полей
    $required_fields = ['email', 'password'];
    
    // Проверка особенными проверками различных полей
    $verification = [
        'email' => validate_email($_POST['email']),
    ];

    // Проверка имеется ли результат от "особенной" проверки
    // После проверка на пустое ли поле и формируется массив ошибок
    foreach ($required_fields as $field) {
        if (isset($verification[$field]) && !is_null($verification[$field])) {
            $errors[$field] = $verification[$field];
        }
        elseif (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }

    if (!empty($errors)) {
        $error_message = "Пожалуйста, исправьте ошибки в форме";
    } else {
        $error_message = "Вы ввели неверный email или пароль";
    }

    // Находим в таблице users в базе данных пользователя с переданным email
    $email = mysqli_real_escape_string($con, $_POST["email"]); // Экранирует специальные символы в строке
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($con, $sql);
    if ($result === false) {
        // Ошибка при выполнении SQL запроса
        print_r('Ошибка подключения к базе');
    } else {
        $user = $result ? mysqli_fetch_array($result, MYSQLI_ASSOC) : null;
    }

    if (empty($errors)) {
        if (password_verify($_POST['password'], $user['password'])) {
            $_SESSION["user"] = $user;
            header("Location: /index.php");
            exit();
        }
    }
}

$page_content = include_template('form-auth.php', [
    "error_message" => $error_message,
    'errors' => $errors
]);

$layout_content = include_template("layout.php", [
    "content" => $page_content,
    "user" => [],
    "title" => "Дела в порядке | Авторизация на сайте",
]);

print($layout_content);
