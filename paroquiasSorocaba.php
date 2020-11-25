<?php


require_once './libs/htmldom/simple_html_dom.php';
require_once './helpers.php';
$lista =geraListaParoquias();
var_dump($lista);

function geraListaParoquias(){
    $links = getLinksParoquias();
    $listaDados = [];
    for($i=0; $i<count($links);$i++){
       // var_dump(getParoquiaContents($links[$i]));
        array_push($listaDados);
    }
    return $listaDados;
}

function getLinksParoquias() : Array
{
$link='https://www.arquidiocesesorocaba.org.br/paroquias/';
$html = file_get_html($link);
$ret =$html->find('div[class=grid-header-box]');
var_dump(($ret)->href);
$dados =[];
foreach ($ret as $i => $pai) {
    $f = $pai->find('h2');
    foreach ($f as $j => $filho) {
        $n = $filho->find('a');
            foreach ($n as $k => $neto){
        if (isset($filho)) {
            $aux = [];
            if ($neto->href) {
                $href = $neto->href;
            }
            if ($neto->plaintext) {
                $nome =  $neto->plaintext;
            }
           
            array_push($dados, ['nome' => $nome , 'link' =>$href]);
        }
     }
  }
}
var_dump($dados);
return $dados;
}

?>