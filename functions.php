<?php 
/**
 * Возвращает количество задач для категории
 * @param string $name Имя категории
 * @param array $tasks Ассоциативный массив задач
 * @return int Количество задач
 */
function quantity_tasks($name, array $tasks = []) {
    $counter = 0;

    foreach ($tasks as $task) {
        if ($name === $task['category']) {
            $counter++;
        }
    }
    return $counter;
}

/**
 * Возвращает количество часов для даты 
 * @param string $deadline Строка с датой
 * @return int Количество часов
 */
function quantity_hours($deadline) {
    return floor((strtotime($deadline) - time()) / 60 / 60);
}

