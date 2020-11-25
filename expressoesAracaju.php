<?php
require_once './libs/htmldom/simple_html_dom.php';
require_once './helpers.php';


/** 
 *       Lista de Dados Link Femininas
 *       @author Karla Guerreiro  
 *       @link karlaguerreiro@hotmail.com
 */
   $link='https://www.arquidiocesedearacaju.org/expressoes';
    $html = file_get_html($link);
    $ret =$html->find('div[class=panel-body]');
    var_dump(($ret)->innertext);