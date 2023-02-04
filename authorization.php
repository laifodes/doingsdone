<?php 
require_once('init.php');

$tasks = [];
$id = null;



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