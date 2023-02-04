<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>

    <nav class="main-navigation">
        <ul class="main-navigation__list">
        <?php foreach ($projects as $value) : ?>
        <li class="main-navigation__list-item 
            <?php if ($value['id'] == $id) : ?>
                main-navigation__list-item--active                       
            <?php endif; ?>">
            <a class="main-navigation__list-item-link" href="index.php?id=<?= $value['id'] ?>"><?= htmlspecialchars($value['name']) ?></a>
            <span class="main-navigation__list-item-count"><?= $value['tasks_count'] ?></span>
        </li>
        <?php endforeach; ?>
        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button"
        href="/add-project.php">Добавить проект</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="index.php" method="post" autocomplete="off">
        <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
            <a href="/" class="tasks-switch__item">Повестка дня</a>
            <a href="/" class="tasks-switch__item">Завтра</a>
            <a href="/" class="tasks-switch__item">Просроченные</a>
        </nav>

        <label class="checkbox">
            <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
            <input class="checkbox__input visually-hidden show_completed" type="checkbox"<?php if ($show_complete_tasks === 1): ?>checked<?php endif; ?>>
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>
    
    <table class="tasks">
        <?php if (!is_null($tasks)): foreach ($tasks as $task): ?>
        <?php if ($show_complete_tasks === 1 || !$task['completed']):?>  
        <tr class="tasks__item task <?php if ($task['completed']): ?>task--completed<?php endif; ?><?php if (!$task['completed'] && quantity_hours($task['date_of_completion']) <= 24 && $task['date_of_completion'] !== null): ?>task--important<?php endif; ?>">
            <td class="task__select">                      
                <label class="checkbox task__checkbox">
                    <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" 
                    <?php if ($task['completed'] && $show_complete_tasks === 1):?> checked<?php endif; ?>>
                    <span class="checkbox__text"><?=htmlspecialchars($task['task'])?> <?=quantity_hours($task['date_of_completion'])?></span>
                </label>
            </td>

            <td class="task__file">
                <?php if (isset($task['link_file'])): ?>
                    <a class="download-link" href="<?= "/uploads/" . $task['link_file']?>">name</a>
                <?php endif;?>
            </td>

            <td class="task__date">
                <?php if (isset($task["date_of_completion"])): ?>
                            <?= htmlspecialchars(date("d.m.Y", strtotime($task["date_of_completion"]))); ?>
                <?php endif; ?>
            </td>
            <td class="task__controls"><?=htmlspecialchars($task['category'])?></td>
        </tr>
        <?php endif; ?>
        <?php endforeach; endif;?>               
        <!--показывать следующий тег <tr/>, если переменная $show_complete_tasks равна единице-->
    </table>
</main>