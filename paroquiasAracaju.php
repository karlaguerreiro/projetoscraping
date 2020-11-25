<?php
require_once './libs/htmldom/simple_html_dom.php';
require_once './helpers.php';


$link='http://arquidiocesecampinas.com/pastorais/';
$html = file_get_html($link);
$ret =$html->find('div[class=question-container]',0)->find('div[class=font_8]');
var_dump($ret)

?>