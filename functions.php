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

/**
 * Проверяет установлено ли значение из раскрывающегося списка, иначе можно добавить задачу другому пользователю
 * Нужно как-то придумать чтобы пользователь создавший <option> в верстке не мог чужому пользователю добавить задачу, каждый раз пользователя сверять?
 * @param mixed $value Выбранное значение
 * @param array $values_list Массив значений
 * @return string|null
 */
function validate_project($project) {
    if ($project === "") {
        return "Выберите проект из раскрывающегося списка";
    }
    return null;
}

/**
 * Проверяет e-mail на корректность
 * @param string $email Значение поля ввода
 * @return string|null
 */
function validate_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "E-mail введён некорректно";
    }
    return null;
}

/**
 * Проверяет длину никнейма
 * @param string $nickname Значение поля ввода
 * @param int $min Минимальное количество символов
 * @param int $max Максимальное количество символов
 * @return string|null
 */
function validate_length($nickname, $min, $max) {
    if ($nickname) {
        $length = mb_strlen($nickname);
        if ($length < $min or $length > $max) {
            return "Поле должно содержать от $min до $max символов";
        }
    }
    return null;
}