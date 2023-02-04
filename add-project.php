<?php 
require_once('init.php');

$tasks = [];
$id = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $tasks = get_tasks_by_id($con, 1, $id);
}
else {
    $tasks = get_tasks_by_user($con, 1);
}

$errors = [];
if (isset($_POST['add-project'])) {
    $required_fields = ['name'];   
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }
    if (empty($errors)) {
        $user = 1;

        // SQL запрос на добавление нового проекта
        $sql = "INSERT INTO projects (user, name) VALUES (?, ?)";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'is', $user, $_POST['name']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        header('Location: /index.php');
    }
}
// if (isset($_POST['name'])) {
//     $user = 1;
//     $project = $_POST['name'];
    
//     if ($project === '') {
//         header('Location: /pages/form-project.html');
//     }
//     else {
//         // SQL запрос на добавление нового проекта
//         $sql = "INSERT INTO projects (user, name) VALUES (?, ?)";

//         $stmt = mysqli_prepare($con, $sql);
//         mysqli_stmt_bind_param($stmt, 'is', $user, $project);
//         mysqli_stmt_execute($stmt);
//         $res = mysqli_stmt_get_result($stmt);

//         header('Location: /index.php');
//     }
// }

$page_content = include_template('form-project.php', [
    'projects' => get_projects($con, 1), 
    'tasks' => $tasks, 
    'id' => $id,
    'errors' => $errors
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'title' => 'Дела в порядке'
]);
print($layout_content);
