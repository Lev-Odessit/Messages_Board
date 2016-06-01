<h3 class="title_page"><?=$text['title']; ?></h3>
<? if($_SESSION['msg']) : ?>
    <?=$_SESSION['msg'];?>
    <?php unset($_SESSION['msg']);?>
<? endif ?>
<?php if ($text) : ?>
        <div class="t_mess">
        <h4 class="title_p_mess">
            <a href="?action=view_mess&id=<?=$text['id'];?>"><?=$text['title'];?></a>
        </h4>
        <?php if ( $text['confirm'] == 0 ) : ?>
            <p class="no_confirm"><strong>Ещё не подтвержденно модератором</strong></p>
        <?php endif; ?>
        <?php if ( $text['is_actual'] == 0 ) : ?>
            <p class="no_actual"><strong>Уже не актуально</strong></p>
        <?php endif; ?>
        <p class="p_mess_cat">
            <strong>Категория: </strong><?=$text['cat'];?>
            <strong>Тип объявления: </strong><?=$text['razd'];?>
            <strong>Город: </strong><?=$text['town'];?>
        </p>
        <p class="p_mess_cat">
            <strong>Дата добавления объявления: </strong><?=date("d.m.Y",$text['date']);?>
            <strong>Цена: </strong><?=$text['price'];?>
            <strong>Автор: </strong><a href="mailto:<?=$text['email'];?>"><?=$text['uname'];?></a>
        </p>
        <p class="mess_desc">
            <img class="mini_mess" src="<?=SITE_NAME."/".MINI.$text['img'];?>">
            <?=nl2br($text['text']);?>
        </p>
</div>
<?php endif; ?>


