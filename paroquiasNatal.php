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
$link='http://arquidiocesedenatal.org.br/paroquias';
$html = file_get_html($link);
$ret =$html->find('div[id=lista_quadros]');
var_dump(($ret)->href);

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