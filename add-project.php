<?php 
require_once('init.php');

$tasks = [];
$id = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $tasks = get_tasks_by_id($con, $_SESSION['user']['id'], $id);
}
else {
    $tasks = get_tasks_by_user($con, $_SESSION['user']['id']);
}

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = ['name'];   
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }
    if (empty($errors)) {

        // SQL запрос на добавление нового проекта
        $sql = "INSERT INTO projects (user, name) VALUES (?, ?)";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'is', $_SESSION['user']['id'], $_POST['name']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        header('Location: /index.php');
    }
}

$page_content = include_template('form-project.php', [
    'projects' => get_projects($con, $_SESSION['user']['id']), 
    'tasks' => $tasks, 
    'id' => $id,
    'errors' => $errors
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'title' => 'Дела в порядке'
]);
print($layout_content);
