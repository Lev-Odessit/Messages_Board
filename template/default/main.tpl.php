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
    <section class="slider container_12">
        <div class="carosel_header">
            <div class="title">Последние объявления:</div>
            <ul class="carosel_control_buttons">
                <li class="prev">&#60;</li><!--
             --><li class="next">&#62;</li>
            </ul>
        </div>
        <div class="carosel_body">
            <ul class="carosel_posts">
                <?php foreach ( $text as $item ) : ?>
                    <li>
                        <a href="?action=view_mess&id=<?=$item['id'];?>">
                            <img class="mini_mess" src="<?=SITE_NAME."/".MINI.$item['img'];?>">
                            <div class="clear"></div>
                            <div class="post_title"><?=$item['title'];?></div>
                            <div class="post_day_of_add"><b>Дата добавления:</b> <?=date("d.m.Y",$item['date']);?></div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
<?php endif; ?>

<div class="columns container_12">
    <div class="left_column grid_8">
        <div class="main_page_categories">
            <div class="title">Категории:</div>
            <div class="clear"></div>
            <div class="categories_item">
                <a href="?action=categories&amp;id_cat=5">
                    <i class="fa fa-car fa-2x"></i> <br>
                    <span>Автомобили</span>
                </a>
                <a href="?action=categories&amp;id_cat=6">
                    <i class="fa fa-motorcycle fa-2x"></i> <br>
                    <span>Мото</span>
                </a>
                <a href="?action=categories&amp;id_cat=7">
                    <i class="fa fa-tv fa-2x"></i> <br>
                    <span>Компьютеры</span>
                </a>
                <a href="?action=categories&amp;id_cat=8">
                    <i class="fa fa-gamepad fa-2x"></i> <br>
                    <span>Игры</span>
                </a>
                <a href="?action=categories&amp;id_cat=9">
                    <i class="fa fa-bed fa-2x"></i> <br>
                    <span>Мебель</span>
                </a>
                <a href="?action=categories&amp;id_cat=10">
                    <i class="fa fa-stumbleupon fa-2x"></i> <br>
                    <span>Сантехника</span>
                </a>
                <a href="?action=categories&amp;id_cat=11">
                    <i class="fa fa-wrench fa-2x"></i> <br>
                    <span>Инструмент</span>
                </a>
                <a href="?action=categories&amp;id_cat=12">
                    <i class="fa fa-simplybuilt fa-2x"></i> <br>
                    <span>Стройматериалы</span>
                </a>
            </div>
        </div>
        <div class="advanced_search">
            <div class="title">Расширенный поиск:</div>
            <div class="clear"></div>
            <form method="GET">
                <div class="col_1 grid_4">
                    <input name="action" value="search" type="hidden">
                    <div class="search_query">
                        <label for="Search">По названию:</label>
                        <input id="Search" name="search" type="text" />
                    </div>
                    <div class="search_query">
                        <label for="searchTown">По городу:</label>
                        <input id="searchTown" name="search-town" type="text" />
                    </div>

                    <div class="search_query">
                        <label for="idCategories"></label>
                        <select id="idCategories" name="id_categories">
                            <option selected="selected" value="">Выберите категорию</option>
                            <optgroup label="Транспорт">
                                <option value="5">--Автомобили</option>
                                <option value="6">--Мото</option>
                            </optgroup>
                            <optgroup label="Интернет">
                                <option value="7">--Компьютеры</option>
                                <option value="8">--Игры</option>
                            </optgroup>
                            <optgroup label="Дом">
                                <option value="9">--Мебель</option>
                                <option value="10">--Сантехника</option>
                            </optgroup>
                            <optgroup label="Сад, огород">
                                <option value="11">--Интсрумент</option>
                                <option value="12">--Строй материалы</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="col_2 grid_3">
                    <div class="search_type_query">
                        <label for="idRazd_1">Тип объявления:</label>
                        <input id="idRazd_1" name="id_razd" value="1" type="radio"><label for="idRazd_1">Предложение</label>
                        <input id="idRazd_2" name="id_razd" value="2" type="radio"><label for="idRazd_2">Спрос</label>
                    </div>
                    <div class="search_rate_query">
                        <label for="">Диапазон цен:</label>
                        <label for="pMin">От: </label> <input id="pMin" name="p_min" class="p_search" type="text">
                        <label for="pMax">До: </label><input id="pMax" name="p_max" class="p_search" type="text">
                    </div>
                </div>
                <div class="clear"></div>
                <button type="submit" class="search_btn">Поиск</button>
            </form>
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




