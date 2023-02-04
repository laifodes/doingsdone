<?php
require_once('db_config.php');

$page_content = include_template('form-task.php', [
    'projects' => get_projects($con, 1), 
    'tasks' => $tasks, 
    'show_complete_tasks' => $show_complete_tasks, 
    'id' => $id
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'title' => 'Дела в порядке'
]);
print($layout_content);