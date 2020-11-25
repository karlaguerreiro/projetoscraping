<?php
require_once './libs/htmldom/simple_html_dom.php';
require_once './helpers.php';

/** 
 *       Lista de Dados Link Femininas
 *       @author Karla Guerreiro  
 *       @link karlaguerreiro@hotmail.com
 */

$lista = geraListaObras();
gravar(json_encode($lista), 'ObrasSociaisAparecida');
gravarCSV($lista, 'ObrasSociaisAparecida');


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

function geraListaObras()
{
    $links = getLinksObras();
    $listaDados = [];

    for ($i = 0; $i < count($links); $i++) {
        Percentual(' Conteudo Obras',count($links),$i);
        array_push($listaDados, getObrasContents($links[$i]['nome'], $links[$i]['link']));
    }
    return $listaDados;
}

//Array de links - Página Principal - Portal
function getLinksObras(): array
{
    $html = file_get_html('https://arqaparecida.org.br/obras-sociais/');
    // Todos os elementos com <td> - Portal
    $ret = $html->find('<td>');
    $lista = [];
    foreach ($ret as $i => $pai) {
        $f = $pai->find('a');
        if (isset($f)) {
            foreach ($f as $j => $filho)
            if (isset($filho)) {
                if ($filho->href){
                array_push($lista, [
                    'nome' => $filho->plaintext,
                    'link' => $filho->href
                ]);
            }
        }
    }
    }
    return $lista;
}


//var_dump(getObrasContents($link));




function getObrasContents(String $nome, String $link)
{
    $html = file_get_html($link);

    
    $arrAux = [];
    $arrAux['nome'] = $nome;
    $arrAux['E-mail']  =  ' ';
    $arrAux['Telefone'] = ' ';
    $arrAux['Site'] = ' ';



    $ret = $html->find('div[class=top20 bottom20]');
    
    foreach ($ret as $i => $pai) {
        $f = $pai->find('p');
        foreach ($f as $j => $filho) {
            matchEmail($arrAux, $filho->plaintext);
            matchTelefone($arrAux, $filho->plaintext);
            matchLogradouro($arrAux, $filho->plaintext);
            }
        }
        
    
    // foreach ($ret as $i => $pai) {
    //     foreach ($f as $j => $filho) {
    //     $f = $pai->find('div');
    //     matchEmail($arrAux, $filho->plaintext);
    //     matchTelefone($arrAux, $filho->plaintext);
    //     matchLogradouro($arrAux, $filho->plaintext);
    //     }
    
    return $arrAux;
}

