<?php


require_once './libs/htmldom/simple_html_dom.php';
require_once './helpers.php';

$lista =geraListaPastorais();
var_dump($lista);

function geraListaPastorais(){
    $links = getLinksPastorais();
    $listaDados = [];
    for($i=0; $i<count($links);$i++){
       // var_dump(getParoquiaContents($links[$i]));
       array_push($listaDados, getPastoraisContents($links[$i]));
    }
    return $listaDados;
}

function getLinksPastorais(){
$link='https://arquicascavel.org.br/pastoral/63-pastoral-carceraria';
$html = file_get_html('https://arquicascavel.org.br/pastorais/');
$ret =$html->find('div[class="col-6 col-sm-4 col-md-3 col-lg-3"]');
//var_dump(($ret)->href);
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
           
            array_push($dados, ['nome' => $nome ]);
        }
    }
}
//var_dump($dados);
return $dados;
}


function getPastoraisContents(String $dados){
$link = $dados['link'];
$html = file_get_html($link);

$ret=$html->find('div[class=pd-desc]');
$filtros = [];
$textos = [];


foreach ($ret as $i=>$pai){
    if (isset($pai)){
    $f = $pai->find('p');
    foreach ($f as $j =>$filho){
        array_push($textos, isset($filho->innertext) ? $filho->innertext : ' ');
        if(isset($filho->innertext)){
            $innertext= $filho->innertext;
        }


        array_push($filtros);
    }
}

}
$filtros[5]['texto']= $textos;
return $filtros;
}


?>