<?php 
require_once('init.php');

$tasks = [];
$id = null;

$errors = [];

// Проверяем подключение к базе
if ($con === false) {
    // Ошибка подключения к MySQL
    print_r('Ошибка подключения к базе');
} 
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Валидация
    // Список обязательных к заполнению полей
    $required_fields = ['email', 'password', 'name'];
    
    // Проверка особенными проверками различных полей
    $verification = [
        'email' => validate_email($_POST['email']),
        'name' => validate_length($_POST['name'], 4, 20)
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
    
    if (empty($errors)) {
        // Проверяем существование пользователя с такой почтой
        $email = mysqli_real_escape_string($con, $_POST['email']); // Экранирует специальные символы в строке
        $sql = "SELECT id FROM user WHERE email = '$email'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $errors['email'] = "Указанный email уже используется другим пользователем";
        }
        else {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (email, password, nickname) VALUES (?, ?, ?)";

            $stmt = db_get_prepare_stmt($con, $sql, [$_POST['email'], $password, $_POST['name']]);
            $result = mysqli_stmt_execute($stmt);
            if ($result === false) {
                // Ошибка при выполнении SQL запроса
                print_r('Ошибка при выполнении SQL запроса');
            }
            else {
                // Если запрос выполнен успешно, переадресовываем пользователя на главную страницу
                header('Location: /auth.php');
            }
        }
    }
}

$page_content = include_template('form-register.php', [
    'errors' => $errors
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'title' => 'Дела в порядке | Регистрация'
]);
print($layout_content);