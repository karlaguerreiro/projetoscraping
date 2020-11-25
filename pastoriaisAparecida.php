<?php
require_once './libs/htmldom/simple_html_dom.php';
require_once './helpers.php';

/** 
 *       Lista de Dados Link Femininas
 *       @author Karla Guerreiro  
 *       @link karlaguerreiro@hotmail.com
 */



 $conteudo = geraListaPastoriais();
 //var_dump($conteudo);
 gravar(json_encode($conteudo) , 'PastoriaisAparecida');
 gravarCSV($conteudo, 'PastoriaisAparecida');


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

function geraListaPastoriais()
 {
  $links = getLinksPastoriais();
  $listaDados = [];

  for ($i=0; $i< count($links); $i++){
    Percentual(' Conteudo Paroquias', count($links), $i);
      array_push($listaDados, getContentsPastorais($links[$i]['nome'], $links[$i]['link']));
      }
    return $listaDados;
}

function getLinksPastoriais(): array
{
 $html = file_get_html('https://arqaparecida.org.br/pastorais-e-comissoes');

 $ret = $html->find('<td>');
 $lista = [];
 foreach ($ret as $i => $pai) {
     $f = $pai->find('a');
     if (isset($f)) {
         foreach ($f as $j => $filho) {
             array_push($lista,[
                'nome' => $filho->plaintext,
                'link' => $filho->href
             ]);
         }

     }
 }
 
 return $lista;
}

function getContentsPastorais (String $nome, String $link)
{
    $html = file_get_html($link);

    $filtros = [];
    $textos = [];

    $arrAux = [];
    $arrAux['nome'] = $nome;
    $arrAux['E-mail']  =  ' ';
    $arrAux['Telefone'] = ' ';
    $arrAux['Site'] = ' ';

    
    $ret = $html->find('div[class=top20 bottom20]');

    foreach ($ret as $i =>$pai){
      $f = $pai->find('div');
        if (isset($f)){
            foreach ($f as $j => $filho) {
                matchEmail($arrAux, $filho->plaintext);
                matchTelefone($arrAux, $filho->plaintext);
                matchLogradouro($arrAux, $filho->plaintext);
                  $f = $pai->find('a');
                  if (isset($f)) {
                      foreach ($f as $j => $filho) {
                         
                matchEmail($arrAux, $filho->plaintext);
                matchSite($arrAux, $filho->plaintext);
                         
                      }
                  }
       
            }
          }
        }



        
  
      return $arrAux;
}
