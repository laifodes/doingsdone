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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = ['name', 'project'];   
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }
    
    if ($_POST['date'] != "") {
        if (!is_date_valid($_POST['date'])) {
            $errors['date'] = 'Неправильный формат';
        } 
    }
    else {
        $_POST['date'] = NULL;
    }  

    // Уязвимость что пользователь может в верстке поменять значение value в <option> и добавить чужому пользователю задачу
    // if ($_POST['project'] != "") {
    //     if (validate_project($_POST['project'])) {
    //         $errors['project'] = 'Неправильный формат';
    //     } 
    // }
    // else {
    //     $_POST['date'] = NULL;
    // } 
    
    if (empty($errors)) {
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