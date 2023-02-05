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
  <h2 class="content__main-heading">Добавление задачи</h2>

  <form class="form" action="/add-task.php<?php if (isset($_GET['id'])):?><?= '?id=' . $id ?><?php endif;?>" method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="form__row">
      <?php $classname = (isset($errors['name'])) ? "form__input--error" : "" ?>
      <label class="form__label" for="name">Название <sup>*</sup></label>

      <input class="form__input <?= $classname; ?>" type="text" name="name" id="name" value="<?= $_POST['name'] ?? "";?>" placeholder="Введите название">
      <?php if (isset($errors['name'])) : ?>
        <p class="form__message">
          <?= $errors['name'] ?? ""; ?>
        </p>
      <?php endif; ?>
    </div>

    <div class="form__row">
      <?php $classname = (isset($errors['project'])) ? "form__input--error" : "" ?>
      <label class="form__label" for="project">Проект <sup>*</sup></label>

      <select class="form__input form__input--select <?= $classname; ?>" name="project" id="project">
        <option value="" selected hidden>Выберите категорию</option>
        <?php foreach ($projects as $value) : ?>
          <option value="<?= $value['id'] ?>" <?php if ($value['id'] == $id || isset($_POST['project']) && $value['name'] == $_POST['project']) : ?>selected<?php endif; ?>><?= $value['name'] ?></option>
        <?php endforeach; ?>
      </select>
      <?php if (isset($errors['project'])) : ?>
        <p class="form__message">
          <?= $errors['project'] ?? ""; ?>
        </p>
      <?php endif; ?>
    </div>

    <div class="form__row">
      <?php $classname = (isset($errors['date'])) ? "form__input--error" : "" ?>
      <label class="form__label" for="date">Дата выполнения</label>

      <input class="form__input form__input--date <?= $classname; ?>" type="text" name="date" id="date" value="<?= $_POST['date'] ?? "";?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
      <?php if (isset($errors['date'])) : ?>
        <p class="form__message">
          <?= $errors['date'] ?? ""; ?>
        </p>
      <?php endif; ?>
    </div>

    <div class="form__row">
      <label class="form__label" for="file">Файл</label>

      <div class="form__input-file">
        <input class="visually-hidden" type="file" name="file" id="file" value="<?= $_POST['file'] ?? "";?>">

        <label class="button button--transparent" for="file">
          <span>Выберите файл</span>
        </label>
      </div>
    </div>

    <div class="form__row form__row--controls">
      <input class="button" type="submit" name="" value="Добавить">
    </div>
  </form>
</main>
