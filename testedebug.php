<?php
require_once './libs/htmldom/simple_html_dom.php';
require_once './helpers.php';

/** 
 *       Lista de Dados Link Femininas
 *       @author Karla Guerreiro  
 *       @link karlaguerreiro@hotmail.com
 */


$lista = geraListaParoquias();
//var_dump($lista);
gravar(json_encode($lista),'Paroquias');

//Gera lista de links
function geraListaParoquias(){
    $links = getLinksParoquias();
    $listaDados = [];
    for($i=0; $i<count($links);$i++){
       // Percentual(' Conteudo Paroquias',count($links),$i);
       // var_dump(getParoquiaContents($links[$i]));
        array_push($listaDados,getParoquiaContents($links[$i]));
    }
    return $listaDados;
}

//Array de links - Página Principal
function getLinksParoquias() : Array
{
    $link = 'https://arqaparecida.org.br/paroquia/22407-santo-afonso-maria-de-ligorio';
    $html = file_get_html('https://arqaparecida.org.br/Arquidiocese/Paroquias');
    $ret = $html->find('<td>');
    $dados = [];
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
    //var_dump($dados);
    return $dados;
}