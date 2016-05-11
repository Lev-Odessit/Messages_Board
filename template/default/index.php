<?php
include "header.tpl.php";
include "menu.tpl.php";
?>
<main>
	<aside class="sidebar col-md-3">
		<?php include "side_bar.tpl.php";?>
	</aside>
	<section class="content col-md-9">
		<?=$content;?>
	</section>
</main>

<div class="clearfix"></div>

<?php include "footer.tpl.php";?>