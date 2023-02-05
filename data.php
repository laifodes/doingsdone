<?php
$show_complete_tasks = rand(0, 1);

// Функция для получения всех проектов и количества задач пользователя
function get_projects ($con, $user) {
    $sql = "SELECT count(tasks.id) AS tasks_count, projects.name, projects.id FROM projects
            LEFT JOIN tasks ON projects.id = tasks.category
            WHERE projects.user = ?
            GROUP BY projects.name, projects.id";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

// Функция для получения всех задач пользователя
function get_tasks_by_user ($con, $user) {
    $sql = "SELECT tasks.name AS task, tasks.date_of_completion, projects.name AS category, tasks.completed, link_file FROM projects
            JOIN tasks ON tasks.category = projects.id
            WHERE projects.user = ?";


    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

// Функция для получения всех задач пользователя с отбором по проекту
function get_tasks_by_id ($con, $user, $id) {
    $sql = "SELECT tasks.name AS task, tasks.date_of_completion, projects.name AS category, tasks.completed, link_file FROM projects
            JOIN tasks ON tasks.category = projects.id
            WHERE projects.user = ? AND projects.id = ?";


    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $user, $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res) == 0) {
        http_response_code(404);
    }
    else {
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
}

// Проверяем что проект привязан к пользователю и он не хочет пошалить) 
function check_hacker ($con, $user, $project) {
    $user = mysqli_real_escape_string($con, $user); // Экранирует специальные символы в строке
    $project = mysqli_real_escape_string($con, $project); // Экранирует специальные символы в строке

    $sql = "SELECT * FROM `projects` WHERE user = '$user' and id = '$project'";
    $result = mysqli_query($con, $sql);

    // Ай-ай-ай кто-то тут хакер!
    if (mysqli_num_rows($result) == 0) {
        return TRUE;
    }
    // Он молодец, не плохой
    else {
        return FALSE;
    }
}