<style>
    .selected {
        padding: 2px 3px 3px;
        background-color: #d00;
        color: #fff;
        font-weight: bold;
    }
</style>
<?php
require_once('./class.pagination.php');

$paging = new Pagination();
$paging->set('urlscheme','pagination.php?page=%page%');
$paging->set('perpage',20);
$paging->set('page',max(1,intval($_GET['page'])));
$paging->set('total',3000);
$paging->set('nexttext','Next Page');
$paging->set('prevtext','Previous Page');
$paging->set('focusedclass','selected');
$paging->set('delimiter',' - ');
$paging->set('numlinks',10);

$paging->display();
