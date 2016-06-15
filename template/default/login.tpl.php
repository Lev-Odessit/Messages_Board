<div class="container_12">
    <?php if($_SESSION['msg']) : ?>
        <div class="general_msg">
            <?= $_SESSION['msg']; ?>
            <?php unset($_SESSION['msg']);?>
        </div>
    <?php endif; ?>
</div>
<div class="login_block container_12">
    <h1>Авторизируйтесь</h1>

    <form METHOD="post">
        <div class="form_input">
            <label for="login_input">Логин: </label>
            <input type="text" autocomplete="off" id="login_input" placeholder="Логин" name="login">
        </div>
        <div class="form_input">
            <label for="password_input">Пароль: </label>
            <input type="password" autocomplete="off" id="password_input" placeholder="Пароль" name="password">
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="member"> Запомнить меня
            </label>
        </div>
        <button class="login_btn" type="submit">Логин</button>
    </form>
</div>