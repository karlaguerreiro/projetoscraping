<?php


require_once './libs/htmldom/simple_html_dom.php';
require_once './helpers.php';
$lista = geraListaParoquias();
//var_dump($lista);
gravar(json_encode($lista), 'ParoquiasCuritiba');
gravarCSV($lista, 'ParoquiasCuritiba');


function geraListaParoquias()
{
    $links = getLinksParoquias();
    $listaDados = [];
    for ($i = 0; $i < count($links); $i++) {
        Percentual(' Conteudo Paroquias', count($links), $i);
        // var_dump();
        array_push($listaDados, getContentsParoquias($links[$i]['nome'], $links[$i]['link']));
    }
    return $listaDados;
}
function gravarCSV(array $list, String $nomeDoArquivo)
{
    // Create an array of elements 


    // Open a file in write mode ('w') 
    $nomeDoArquivo = "./filters/$nomeDoArquivo" . ".csv";
    $fp = fopen($nomeDoArquivo, 'w');

    $delimiter = ',';

    $headings = array('Nome', 'Setor', 'Bairro', 'Cidade', 'CEP', 'Endereço', 'Telefone', 'Estado', 'E-mail');

    fputcsv($fp, $headings);

    foreach ($list as $dados) {
       
        //var_dump($row);
        fputcsv($fp, $dados);
    }


    fclose($fp);
}
function getLinksParoquias(): array
{
    $link = 'http://arquidiocesedecuritiba.org.br/paroquias/';
    $html = file_get_html($link);
    $ret = $html->find('div[class=margem-10]');
    //var_dump(($ret)->href);
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

                array_push($dados, ['nome' => $nome, 'link' => $href]);
            }
        }
    }
    //var_dump($dados);
    return $dados;
}
//array auxiliar 
function getContentsParoquias($nome,  $link)
{
    $aux = ['nome' => $nome];

    $html = file_get_html($link);
    $ret = $html->find('div[class="box-cinza1"]');

    foreach ($ret as $i => $pai) {
        $conteudo = $pai->plaintext;

        $f = $pai->find('strong');

        foreach ($f as $j => $filho) {
            $index = str_replace(':', "", $filho->plaintext);
        }

        $aux[$index] = $conteudo;
    }

    // $conteudo = '';

    $ret = $html->find('div[class="box-cinza2"]');
    foreach ($ret as $i => $pai) {


        $conteudo = $pai->plaintext;
        //echo $conteudo.PHP_EOL;
        $f = $pai->find('strong');

        foreach ($f as $j => $filho) {
            $index = str_replace(':', "", $filho->plaintext);
        }

        $aux[$index] = $conteudo;
    }

    $palavrasRemover = ['Telefone:', 'Endereço:', 'Bairro:', 'cidade:', 'Estado:', 'CEP:', 'E-mail:', 'Setor:'];

    foreach ($aux as $i => $frases) {
        $aux[$i] = str_replace($palavrasRemover, '', $frases);
    }

    return ($aux);
}
