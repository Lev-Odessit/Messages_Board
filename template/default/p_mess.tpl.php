<div class="container_12">
<h3 class="title_page">Личные объявления</h3>
    <? if($_SESSION['msg']) : ?>
        <div class="general_msg">
            <?= $_SESSION['msg']; ?>
            <?php unset($_SESSION['msg']);?>
        </div>
    <? endif; ?>
<?php if ($text) : ?>
    <?php $counter = 0; ?>
    <?php foreach ( $text as $item ) : ?>
        <ul class="categories_mess container_12">
            <li class="cat_mess_img">
                <a href="<?=SITE_NAME."/".FILES.$item['img'];?>" data-lightbox="image-<?= $counter ?>">
                    <img class="mini_mess" src="<?=SITE_NAME."/".MINI.$item['img'];?>">
                </a>
            </li>
            <li class="cat_mess_desc">
                <div class="title">
                    <a href="?action=view_mess&id=<?=$item['id'];?>"><?=$item['title'];?></a>
                </div>
                <div class="simple_description">
                    <b>Категория: </b><?=$item['cat'];?> | <b>Город: </b><?=$item['town'];?> | <b>Автор: </b><a href="mailto:<?=$item['email'];?>"><?=$item['uname'];?></a>
                </div>
                <div class="mess_text_desc">
                    <?=nl2br($item['text']);?>
                </div>
                <form method="POST" class="update_mess_opt">
                    <a href="?action=edit_mess&id=<?=$item['id'];?>">Изменить</a>
                    <a href="?action=p_mess&delete=<?=$item['id'];?>">Удалить</a>
                    <a href="?action=view_mess&id=<?=$item['id'];?>">Просмотреть</a>
                    <br>
                    <div class="mess_period">
                        Продлить период актуальности объявления на:
                        <select name="time">
                            <option value="10">10 дней</option>
                            <option value="15">15 дней</option>
                            <option value="20">20 дней</option>
                            <option value="30">30 дней</option>
                        </select>
                        <input type="hidden" name="id" value="<?=$item['id'];?>">
                        <input type="submit" value="Ok">
                    </div>
                </form>
            </li>
            <li class="cat_mess_price">
                $ <?=$item['price'];?>.00
            </li>
        </ul>
        <?php $counter++; ?>
    <?php endforeach; ?>
<?php endif; ?>
</div>

