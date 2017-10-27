<?php /* Template Name: page-test */
require_once dirname(__FILE__) .('\simplehtmldom\simple_html_dom.php');

// Create DOM from URL

/*
$html = file_get_html('https://www.ivp.co.jp/');

$list = $html->find('.sf-menu li');

foreach($list as $li) 
   {
        echo $li;
    }

*/

$url = file_get_html('https://shop-list.com/all/svc/product/Search/?keyword=%83j%83b%83g');

$items = $url->find('.listProduct li');

foreach($items as $item) 
   {
        $Genre = $item->find('.genre',0);
         echo  $Genre ;
    }


?>