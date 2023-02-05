<?php 
require_once('init.php');

$tasks = [];
$id = null;
$error_message = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $tasks = get_tasks_by_id($con, $_SESSION['user']['id'], $id);
}
else {
    $tasks = get_tasks_by_user($con, $_SESSION['user']['id']);
}

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = ['name', 'project'];   
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }
    
    if ($_POST['project'] != "" && check_hacker($con, $_SESSION['user']['id'], $_POST['project'])) {
        $error_message = "Ай-ай-ай, хакером быть нынче плохо, но прибыльно!";
    }

    if ($_POST['date'] != "") {
        if (!is_date_valid($_POST['date'])) {
            $errors['date'] = 'Неправильный формат';
        } 
    }
    else {
        $_POST['date'] = NULL;
    }  
    
    if (empty($errors) && empty($error_message)) {
        // Добавление файла в папку  
        if (isset($_FILES['file'])) {
            $file_name = $_FILES['file']['name'];
            $file_path = __DIR__ . '/uploads/';
            $file_url = '/uploads/' . $file_name;
            move_uploaded_file($_FILES['file']['tmp_name'], $file_path . $file_name);
        }

        // SQL запрос на добавление новой задачи
        $sql = "INSERT INTO tasks (name, category, date_of_completion, link_file) VALUES (?, ?, ?, ?)";
        
        if ($_FILES['file']['name'] == "") {
            $_FILES['file']['name'] = NULL;
        }


        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'siss', $_POST['name'], $_POST['project'], $_POST['date'], $_FILES['file']['name']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        header('Location: /index.php');

    }
}

$page_content = include_template('form-task.php', [
    'projects' => get_projects($con, $_SESSION['user']['id']), 
    'tasks' => $tasks, 
    'id' => $id,
    'errors' => $errors,
    'error_message' => $error_message
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'title' => 'Дела в порядке'
]);
print($layout_content);