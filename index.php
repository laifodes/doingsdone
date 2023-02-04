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

$page_content = include_template('main.php', [
    'projects' => get_projects($con, 1), 
    'tasks' => $tasks, 
    'show_complete_tasks' => $show_complete_tasks, 
    'id' => $id
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'id' => $id,
    'title' => 'Дела в порядке'
]);
print($layout_content);
