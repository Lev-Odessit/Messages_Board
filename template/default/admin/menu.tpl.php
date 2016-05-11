<nav>
    <? if($user) :?>
        <? if($edit_us) :?>
            <a href="<?= SITE_NAME; ?>/admin.php?action=edit_user">Пользователи</a>
            <a href="<?= SITE_NAME; ?>/admin.php?action=edit_priv">Привелегии</a>
        <? endif;?>
        <? if($add_cat) :?>
            <a href="<?= SITE_NAME; ?>/admin.php?action=edit_cat">Категории</a>
        <? endif; ?>
        <? if($edit_mess) :?>
            <a href="<?= SITE_NAME; ?>/admin.php?action=edit_adm_mess">Объявления</a>
        <? endif; ?>
    <? endif; ?>
</nav>
<div class="clearfix"></div>