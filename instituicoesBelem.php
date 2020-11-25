<?php


require_once './libs/htmldom/simple_html_dom.php';
require_once './helpers.php';

$lista = geraListaInstituicoes();
gravar(json_encode($lista), 'InstituçõesBelem');

function geraListaInstituicoes()
{
    $lista = getInstituicoesContents();
    $listaDados = $lista;
    var_dump ($lista);
    return $listaDados;
}


function getInstituicoesContents():array 
{
$link='https://arquidiocesedebelem.com.br/instituicoes/';
$html = file_get_html($link);
// $dados = [];

$arrAux = [];
$arrAux['E-mail']  =  ' ';
$arrAux['Telefone'] = ' ';
$arrAux['Site'] = ' ';
$listaConteudos =[];

$ret =$html->find('div[class=et_pb_blurb_container]');
foreach($ret as  $pai){
    $f= $pai->find('h4[class=et_pb_module_header]',0);
    if ($f->plaintext) {
        $nome =  $f->innertext;
        $arrAux['nome'] = $nome;
    }
    $f= $pai->find('div[class=et_pb_blurb_description]');
    foreach ($f as $filho){
       $n = $filho->find('<p>');
       foreach ($n as $neto){        
        $texto= strip_tags($neto->plaintext);
        matchEmail($arrAux, $texto);
        matchTelefone($arrAux, $texto);
        matchLogradouro($arrAux, $texto);
        matchSite($arrAux, $texto);

        $b =$neto->find('a',0);
        foreach($b as $bisneto){
            if (isset($bisneto)){
                if($bisneto->plaintext){
                    matchEmail($arrAux, $texto);
                    //var_dump($b);
                    array_push ($listaConteudos, $arrAux);

                }
                
            }
                
        }

        //var_dump ($arrAux);
       }
   }
}

 

    return $listaConteudos;

}


?>