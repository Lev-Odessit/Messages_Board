<div class="container_12">
    <h3 class="title_page">Объявления</h3>
    <?php if ( $name_razd ) : ?>
        <strong>Раздел: </strong><?= $name_razd; ?>
    <?php endif; ?>
    <?php if (!is_string($text) && !is_bool($text)) : ?>
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
                        <a href="?<?= $url; ?>page=1">Первая</a>
                    </li>
                <?php endif; ?>

                <?php if ( $navigation['last_page'] ) : ?>
                    <li>
                        <a href="?<?= $url; ?>page=<?= $navigation['last_page'] ?>">&lt;</a>
                    </li>
                <?php endif; ?>

                <?php if ($navigation['previous']) : ?>
                    <?php foreach ($navigation['previous'] as $val) : ?>
                        <li>
                            <a href="?<?= $url; ?>page=<?= $val; ?>"><?= $val; ?></a>
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
                            <a href="?<?= $url; ?>page=<?= $v; ?>"><?= $v; ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if ( $navigation['next_pages'] ) : ?>
                    <li>
                        <a href="?<?= $url; ?>page=<?= $navigation['next_pages']; ?>">&gt;</a>
                    </li>
                <?php endif; ?>

                <?php if ( $navigation['end'] ) : ?>
                    <li class="last">
                        <a href="?<?= $url; ?>page=<?= $navigation['end']; ?>">Последняя</a>
                    </li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    <?php else : ?>
        <div class="container_12 ntngs_to_display">
            <? if($_SESSION['msg']) : ?>
                <?= $_SESSION['msg']; ?>
                <?php unset($_SESSION['msg']);?>
            <? endif; ?>
        </div>
    <?php endif; ?>
</div>