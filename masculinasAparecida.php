<?php
require_once './libs/htmldom/simple_html_dom.php';
require_once './helpers.php';

/** 
 *       Lista de Dados Link Masculinas
 *       @author Karla Guerreiro  
 *       @link karlaguerreiro@hotmail.com
 */
// //echo "<pre>";
$lista = geraListaMasculinas();
gravar(json_encode($lista), 'Masculinas');
gravarCSV($lista, 'Maculinas');


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


// var_dump($arrAx);

//Gera lista de links
function geraListaMasculinas()
{
    $links = getLinksMasculinas();
    $listaDados = [];
    for ($i = 0; $i < count($links); $i++) {
        Percentual(' Conteudo Masculinas', count($links), $i);
        array_push($listaDados, getMasculinasContents($links[$i]['nome'], $links[$i]['link']));
    }
    return $listaDados;
}

//Array de links - Página Principal - Portal
function getLinksMasculinas(): array
{
    $link = 'https://arqaparecida.org.br/ordens-religiosas/masculinas/5a405-casa-geral-dos-oblatos-mosteiro-sagrada-face';
    $html = file_get_html('https://arqaparecida.org.br/ordens-religiosas/masculinas');
    // Todos os elementos com <td> - Portal
    $ret = $html->find('<td>');
    $links = [];
    // Percorre elementos de links - Laço epecializado em percorrer array
    foreach ($ret as $i => $pai) {
        $f = $pai->find('a');
        foreach ($f as $j => $filho) {
            if (isset($filho)) {
                if ($filho->href) {
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

//Busca o conteúdo da página 
function getMasculinasContents(String $nome, String $link)
{
    $html = file_get_html($link);

    //Busca todos os elementos com classe top20.bottom20

    $filtros = [];
    $textos = [];

    $arrAux = [];
    $arrAux['nome'] = $nome;
    $arrAux['E-mail']  =  ' ';
    $arrAux['Telefone'] = ' ';
    $arrAux['Site'] = ' ';


    $ret = $html->find('.top20.bottom20');

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
