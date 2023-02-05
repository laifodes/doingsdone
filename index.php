<?php
require_once('init.php');

$tasks = [];
$id = null;

if (!isset($_SESSION["user"])) {
    header("location: /guest.php");
    exit;
}

echo ini_get (' session.gc_maxlifetime');

$user = $_SESSION["user"];
$user_id = $_SESSION["user"]["id"];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $tasks = get_tasks_by_id($con, $user_id, $id);
}
else {
    $tasks = get_tasks_by_user($con, $user_id);
}

$page_content = include_template('main.php', [
    'projects' => get_projects($con, $user_id), 
    'tasks' => $tasks, 
    'show_complete_tasks' => $show_complete_tasks, 
    'id' => $id
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'user' => $user,
    'title' => 'Дела в порядке'
]);
print($layout_content);
