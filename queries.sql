INSERT INTO user(id, email, nickname, password)
VALUES (1, 'laifodes@mail.ru', 'laifodes', '44'),
       (2, 'stanislav@mail.ru', 'stanislav', '55');

INSERT INTO projects(id, name, user)
VALUES (1, 'Входящие', 1),
       (2, 'Учеба', 1),
       (3, 'Работа', 1),
       (4, 'Домашние дела', 1),
       (5, 'Авто', 1);

INSERT INTO tasks(id, name, category, date_of_completion, completed)
VALUES (1, 'Собеседование в IT компании', 3, "2019-12-01", 0),
       (2, 'Выполнить тестовое задание', 3, "2019-12-25", 0),
       (3, 'Сделать задание первого раздела', 2, "2019-12-21", 1),
       (4, 'Встреча с другом', 1, "2023-01-15", 0),
       (5, 'Купить корм для кота', 4, NULL, 0),
       (6, 'Заказать пиццу', 4, NULL, 0);

-- Получить все проекты пользователя
SELECT * FROM projects WHERE (user = 1)

-- Получить все задачи проекта
SELECT * FROM tasks WHERE (category = 1)

-- Пометить задачу выполненной
UPDATE tasks
SET completed = 1
WHERE id = 1;

-- Заменить название задачи
UPDATE tasks
SET name = 'Сделать БД!'
WHERE id = 1;

-- Получить количество задач для каждой категории
SELECT count(tasks.id) tasks_count, projects.id FROM projects
LEFT JOIN tasks ON projects.id = tasks.category
GROUP BY projects.id;

-- Получить список проектов и количества задач для каждого проекта у текущего пользователя
SELECT count(tasks.id) tasks_count, projects.id FROM projects
LEFT JOIN tasks ON projects.id = tasks.category
WHERE projects.user = 1
GROUP BY projects.id;
