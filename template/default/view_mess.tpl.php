<div class="view_mess_page container_12">
    <h3 class="title_page"><?=$text['title']; ?></h3>
    <? if($_SESSION['msg']) : ?>
        <?=$_SESSION['msg'];?>
        <?php unset($_SESSION['msg']);?>
    <? endif ?>
    <?php if ($text) : ?>
        <div class="view_mess container_12">
            <div class="grid_6">
                <a class="mess_img" href="<?=SITE_NAME."/".FILES.$text['img'];?>" data-lightbox="image-<?= $counter ?>">
                    <img width="400" class="mini_mess" src="<?=SITE_NAME."/".FILES.$text['img'];?>">
                </a>
            </div>
            <div class="mess_info grid_6">
                <ul>
                    <li>
                        <b>Категория: </b><?=$text['cat'];?>
                    </li>
                    <li>
                        <b>Тип объявления: </b><?=$text['razd'];?>
                    </li>
                    <li>
                        <b>Город: </b><?=$text['town'];?>
                    </li>
                    <li>
                        <b>Дата: </b><?=date("d.m.Y",$text['date']);?>
                    </li>
                    <li>
                        <b>Цена: </b><?=$text['price'];?>.00 $
                    </li>
                    <li>
                        <b>Автор: </b><a href="mailto:<?=$text['email'];?>"><?=$text['uname'];?></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="columns container_12">
            <div class="mess_desc grid_8">
                <div class="title">Описание</div>
                <div class="mess_text">
                    <?=nl2br($text['text']);?>
                </div>
            </div>
            <div class="right_column grid_4">
                <div class="banners">
                    <div class="title">Баннеры:</div>
                    <div class="clear"></div>
                    <div class="banner_wrapper">
                        <a href="#">280x160</a>
                    </div>
                    <div class="banner_wrapper">
                        <a href="#">280x160</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($lastMess) : ?>
        <div class="slider container_12">
            <div class="carosel_header">
                <div class="title">Последние объявления:</div>
                <ul class="carosel_control_buttons">
                    <li class="prev">&#60;</li><!--
             --><li class="next">&#62;</li>
                </ul>
            </div>
            <div class="carosel_body">
                <ul class="carosel_posts">
                    <?php foreach ( $lastMess as $item ) : ?>
                        <li>
                            <a href="?action=view_mess&id=<?=$item['id'];?>">
                                <img class="mini_mess" src="<?=SITE_NAME."/".MINI.$item['img'];?>">
                                <div class="clear"></div>
                                <div class="post_title"><?=$item['title'];?></div>
                                <div class="post_day_of_add"><b>Дата добавления:</b><span><?=date("d.m.Y",$item['date']);?></span></div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>


