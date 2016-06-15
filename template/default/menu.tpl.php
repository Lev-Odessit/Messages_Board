<nav class="container_12">
    <ul>
        <li>
            <a href="<?=SITE_NAME;?>">Главная</a>
        </li><!--
     --><li class="sub_menu_link">
            <a href="javascript:void(0)" class="nav_categories">
                Категории
            </a>
            <ul class="sub_menu">
                <?php if(is_array($categories)):?>
                    <?php foreach($categories as $key=>$value):?>
                        <?php if($value['next']) :?>
                            <ul>
                                <?php foreach($value['next'] as $k=>$v):?>
                                    <li><a href="?action=categories&id_cat=<?=$k?>"><?=$v;?></a></li>
                                <?php endforeach;?>
                            </ul>
                        <?php endif;?>
                    <?php endforeach;?>
                <?php endif;?>
            </ul>
        </li><!--
        <? if($user) :?>
         --><li>
                <a href="?action=p_mess">Ваши объявления</a>
            </li><!--
        <? endif;?>
        <? if($razd && is_array($razd)) :?>
            <? foreach($razd as $item) :?>
             --><li>
                    <a href="?action=<?= $m_action; ?>&amp;id_r=<?= $item['id']; ?>&id_cat=<?= $id_cat; ?>"><?= $item['name']; ?></a>
                </li><!--
            <? endforeach;?>
        <? endif;?>
        -->
    </ul>
</nav>