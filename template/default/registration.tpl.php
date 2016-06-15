<div class="container_12">
    <?php if($_SESSION['msg']) : ?>
        <div class="general_msg">
            <?= $_SESSION['msg']; ?>
            <?php unset($_SESSION['msg']);?>
        </div>
    <?php endif; ?>
</div>
<div class="registration_block container_12">
    <h1 class="">Регистрация</h1>
    <form METHOD="post">
        <div class="form_input">
            <label for="reg_login_input">Логин:</label>
            <input type="text" id="reg_login_input" placeholder="Логин" name="reg_login" autocomplete="off" value="<?= $_SESSION['reg']['login'];?>" />
            <? unset($_SESSION['reg']['login']); ?>
        </div>
        <div class="form_input">
            <label for="reg_password_input">Пароль:</label>
            <input type="password" id="reg_password_input" placeholder="Пароль" name="reg_password" autocomplete="off" />
        </div>
        <div class="form_input">
            <label for="reg_password_confirm_input">Подтвердите пароль:</label>
            <input type="password" id="reg_password_confirm_input" placeholder="Подтвердите пароль" name="reg_password_confirm" autocomplete="off" />
        </div>
        <div class="form_input">
            <label for="reg_email_input"> Email </label>
            <input type="text" class="form-control" id="reg_email_input" placeholder="Email" name="reg_email" autocomplete="off" value="<?= $_SESSION['reg']['email'];?>"/>
            <? unset($_SESSION['reg']['email']); ?>
        </div>
        <div class="form_input">
            <label for="reg_name_input"> Ваше Имя </label>
            <input type="text" id="reg_name_input" placeholder="Имя" name="reg_name" autocomplete="off" value="<?= $_SESSION['reg']['name'];?>"/>
            <? unset($_SESSION['reg']['name']); ?>
        </div>
        <button class="registration_btn" type="submit" name="reg">Регистрация</button>
    </form>
</div>
