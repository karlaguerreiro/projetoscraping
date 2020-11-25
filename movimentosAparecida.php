<?php

require_once './libs/htmldom/simple_html_dom.php';
require_once './helpers.php';
/** 
 *       Lista de Dados Link 
 *       @author Karla Guerreiro  
 *       @link karlaguerreiro@hotmail.com
 */
$lista = geraListaMovimentos();
gravar(json_encode($lista), 'MovimentosAparecida');
//var_dump($lista); 
Percentual(' Conteudo Masculinas', count($links), $i);
gravarCSV($lista, 'MovimentosAparecida');


function gravarCSV(array $list, String $nomeDoArquivo)
{
    // Create an array of elements 


    // Open a file in write mode ('w') 
    $nomeDoArquivo = "./filters/$nomeDoArquivo" . ".xls";
    $fp = fopen($nomeDoArquivo, 'w');

    $delimiter = ',';

    $headings = array('Nome', 'E-mail', 'Telefone',  'Site', 'Endereço');

    fputcsv($fp, $headings);

    foreach ($list as $dados) {

        //var_dump($row);
        fputcsv($fp, $dados);
    }

    fclose($fp);
}



function geraListaMovimentos()
{ 
  $links=getLinksMovimentos(); 
  $listaDados = [ ];
  for($i=0; $i<count($links);$i++){
      array_push($listaDados, getContentsMovimentos($links[$i]['nome'], $links[$i]['link']));
  }
  return $listaDados;
}

//Array de links - Página Principal - Portal
function getLinksMovimentos() : Array
{
  $link = 'https://arqaparecida.org.br/movimentos/c335d-apostolado-da-oracao';
  $html = file_get_html ('https://arqaparecida.org.br/movimentos');
  // Todos os elementos com <td> - Portal
  $ret = $html->find('<td>');
  $links =[];
  // Percorre elementos de links - Laço epecializado em percorrer array
  foreach ($ret as $i => $pai) {
      $f = $pai->find('a');
      foreach($f as $j => $filho){
          if(isset($filho)){
              if($filho->href){
                array_push($links, [
                  'nome' => $filho->plaintext,
                  'link' => $filho->href
              ]);
          }
      }
  }
}
return $links;
}
    


function getContentsMovimentos (String $nome, String $link)
{
    $html = file_get_html($link);
    $filtros=[];
    $textos = [];

    $arrAux = [];
    $arrAux['nome'] = $nome;
    $arrAux['E-mail']  =  ' ';
    $arrAux['Telefone'] = ' ';
    $arrAux['Site'] = ' ';


    $ret = $html->find('div[class=top20 bottom20]');
    foreach ($ret as $pai) {
      $f = $pai->find('div');
      foreach ($f as $filho) {
          matchEmail($arrAux, $filho->plaintext);
          matchTelefone($arrAux, $filho->plaintext);
          matchLogradouro($arrAux, $filho->plaintext);
          $n = $filho->find('a');
          foreach ($n as $neto) {

              matchEmail($arrAux, $neto->plaintext);
              matchSite($arrAux, $neto->plaintext);
          }
      }
  }




    return $arrAux;
}

