<?php if($_SESSION['msg']) : ?>
    <?= $_SESSION['msg']; ?>
    <?php unset($_SESSION['msg']);?>
<?php endif; ?>

<?php if ( !$name_razd ) : ?>
    <h3 class="title_page">Объявления</h3>
<?php else : ?>
    <h3 class="title_page">Объявления</h3>
    <strong>Раздел: </strong><?= $name_razd; ?>
<?php endif; ?>

<?php if ($text) : ?>
    <?php foreach ( $text as $item ) : ?>
        <div class="t_mess">
            <h4 class="title_p_mess">
                <a href="?action=view_mess&id=<?=$item['id'];?>"><?=$item['title'];?></a>
            </h4>
            <div class="p_mess_cat">
                <strong>Категория: </strong><?=$item['cat'];?>
                <strong>Тип объявления: </strong><?=$item['razd'];?>
                <strong>Город: </strong><?=$item['town'];?>
            </div>
            <div class="p_mess_cat">
                <strong>Дата добавления объявления: </strong><?=date("d.m.Y",$item['date']);?>
                <strong>Цена: </strong><?=$item['price'];?>
                <strong>Автор: </strong><a href="mailto:<?=$item['email'];?>"><?=$item['uname'];?></a>
            </div>
            <div class="mess_desc">
                <img class="mini_mess" src="<?=SITE_NAME."/".MINI.$item['img'];?>">
                <div class="text_desc">
                    <?=nl2br($item['text']);?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if ($navigation) : ?>
        <ul class="pager">

            <?php if ( $navigation['first'] ) : ?>
                <li class="first">
                    <a href="?action=main&page=1><?= $id_r; ?>">Первая</a>
                </li>
            <?php endif; ?>

            <?php if ( $navigation['last_page'] ) : ?>
                <li>
                    <a href="?action=main&page=<?= $navigation['last_page']; ?><?= $id_r; ?>">&lt;</a>
                </li>
            <?php endif; ?>

            <?php if ($navigation['previous']) : ?>
                <?php foreach ($navigation['previous'] as $val) : ?>
                    <li>
                        <a href="?action=main&page=<?= $val; ?><?= $id_r; ?>"><?= $val; ?></a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ( $navigation['current'] ) : ?>
                <li>
                    <span><?= $navigation['current']; ?></span>
                </li>
            <?php endif; ?>

            <?php if ( $navigation['next'] ) : ?>
                <?php foreach ( $navigation['next'] as $v ) : ?>
                    <li>
                        <a href="?action=main&page=<?= $v; ?><?= $id_r; ?>"><?= $v; ?></a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ( $navigation['next_pages'] ) : ?>
                <li>
                    <a href="?action=main&page=<?= $navigation['next_pages']; ?><?= $id_r; ?>">&gt;</a>
                </li>
            <?php endif; ?>

            <?php if ( $navigation['end'] ) : ?>
                <li class="last">
                    <a href="?action=main&page=<?= $navigation['end']; ?><?= $id_r; ?>">Последняя</a>
                </li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
<?php else : ?>
    <p>Объявлений нет</p>
<?php endif; ?>


