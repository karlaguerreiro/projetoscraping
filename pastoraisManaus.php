<?php


require_once './libs/htmldom/simple_html_dom.php';
require_once './helpers.php';

// $lista =geraListaPastorais();
// var_dump($lista);

// function geraListaPastorais(){
//     $links = getLinksPastorais();
//     $listaDados = [];
//     for($i=0; $i<count($links);$i++){
//        // var_dump(getParoquiaContents($links[$i]));
//         array_push($listaDados);
//     }
//     return $listaDados;
// }

// function getLinksPastorais(): Array{
// $link = 'https://arquidiocesedemanaus.org.br/pastorais-movimentos/';
// $html = file_get_html($link);
// $ret =$html->find('div[class=box pastoral-box]');
// var_dump(($ret)->innertext);
// $dados =[];
// foreach ($ret as $i => $pai) {
//     $f = $pai->find('a');
//     foreach ($f as $j => $filho) {
//         if (isset($filho)) {
//             $aux = [];
//             if ($filho->href) {
//                 $href = $filho->href;
//             }
//             if ($filho->plaintext) {
//                 $nome =  $filho->plaintext;
//             }
           
//             array_push($dados, ['nome' => $nome , 'link' =>$href]);
//         }
//     }
// }
// var_dump($dados);
// return $dados;
// }

$link='https://arquidiocesedemanaus.org.br/laicato/apostolado-da-oracao/';
$html = file_get_html($link);

$ret = $html->find('span=[class=field-value]',2);
var_dump ($ret->innertext);
?>