<div class="container_12">
    <h3 class="title_page">Категория - <?= $cat_name; ?></h3>
    <?php if ( $name_razd ) : ?>
        <strong>Раздел: </strong><?= $name_razd; ?>
    <?php endif; ?>
    <? if($_SESSION['msg']) : ?>
        <?= $_SESSION['msg']; ?>
        <?php unset($_SESSION['msg']);?>
    <? endif; ?>
    <?php if ($text) : ?>
        <?php foreach ( $text as $item ) : ?>
            <ul class="categories_mess">
                <li class="cat_mess_img">
                    <a href="?action=view_mess&id=<?=$item['id'];?>">
                        <img class="mini_mess" src="<?=SITE_NAME."/".MINI.$item['img'];?>">
                    </a>
                </li>
                <li class="cat_mess_desc">
                    <div class="title">
                        <a href="?action=view_mess&id=<?=$item['id'];?>"><?=$item['title'];?></a>
                    </div>
                    <div class="simple_description">
                        <b>Категория:</b> <?=$item['cat'];?> | <b>Город:</b> <?=$item['town'];?> | <b>Автор: </b><a href="mailto:<?=$item['email'];?>"><?=$item['uname'];?></a>
                    </div>
                    <div class="mess_text_desc">
                        <?=nl2br($item['text']);?>
                    </div>
                </li>
                <li class="cat_mess_price">
                    $ <?=$item['price'];?>.00
                </li>
            </ul>
        <?php endforeach; ?>
        <?php if ($navigation) : ?>
            <ul class="pager">
                <?php if ( $navigation['first'] ) : ?>
                    <li class="first">
                        <a href="?action=categories&page=1&id_cat=<?= $id_cat; ?><?= $id_r; ?>">Первая</a>
                    </li>
                <?php endif; ?>
                <?php if ( $navigation['last_page'] ) : ?>
                    <li>
                        <a href="?action=categories&page=<?= $navigation['last_page']; ?>&id_cat=<?= $id_cat; ?><?= $id_r; ?>">&lt;</a>
                    </li>
                <?php endif; ?>
                <?php if ($navigation['previous']) : ?>
                    <?php foreach ($navigation['previous'] as $val) : ?>
                        <li>
                            <a href="?action=categories&page=<?= $val; ?>&id_cat=<?= $id_cat; ?><?= $id_r; ?>"><?= $val; ?></a>
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
                            <a href="?action=categories&page=<?= $v; ?>&id_cat=<?= $id_cat; ?><?= $id_r; ?>"><?= $v; ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ( $navigation['next_pages'] ) : ?>
                    <li>
                        <a href="?action=categories&page=<?= $navigation['next_pages']; ?>&id_cat=<?= $id_cat; ?><?= $id_r; ?>">&gt;</a>
                    </li>
                <?php endif; ?>
                <?php if ( $navigation['end'] ) : ?>
                    <li class="last">
                        <a href="?action=categories&page=<?= $navigation['end']; ?>&id_cat=<?= $id_cat; ?><?= $id_r; ?>">Последняя</a>
                    </li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    <?php else : ?>
        <div class="grid_12 ntngs_to_display">Объявлений нет</div>
    <?php endif; ?>
</div>

