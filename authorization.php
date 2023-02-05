<?php 
require_once('init.php');

$tasks = [];
$id = null;

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = ['email'];   
    if (preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $_POST['email'])) {
        $errors[$field] = 'Поле не заполнено';
    }
}

$page_content = include_template('form-authorization.php', [
    'projects' => get_projects($con, 1), 
    'tasks' => $tasks, 
    'show_complete_tasks' => $show_complete_tasks, 
    'id' => $id,
    'errors' => $errors
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'title' => 'Дела в порядке'
]);
print($layout_content);