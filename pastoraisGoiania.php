<?php


require_once './libs/htmldom/simple_html_dom.php';
require_once './helpers.php';
$lista =geraListaParoquias();
var_dump($lista);

function geraListaPastorais(){
    $links = getLinksPastorais();
    $listaDados = [];
    for($i=0; $i<count($links);$i++){
       // var_dump(getParoquiaContents($links[$i]));
        array_push($listaDados);
    }
    return $listaDados;
}

function getLinksPastorais() : Array
{
$link='https://www.arquidiocesedegoiania.org.br/pastoral/pastorais';
$html = file_get_html($link);
$ret =$html->find('div[class=blcs]',0)->find('div',0);
var_dump(($ret)->innertext);
$dados =[];
foreach ($ret as $i => $pai) {
    $f = $pai->find('a');
    foreach ($f as $j => $filho) {
        if (isset($filho)) {
            $aux = [];
            if ($filho->href) {
                $href = $filho->href;
            }
            if ($filho->plaintext) {
                $nome =  $filho->plaintext;
            }
           
            array_push($dados, ['nome' => $nome , 'link' =>$href]);
        }
    }
}
var_dump($dados);
return $dados;
}

?>