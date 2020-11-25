<?php


function limpaDOM(String $String)
{
}

// function gravarCSV(array $list, String $nomeDoArquivo)
// {
//     // Create an array of elements 


//     // Open a file in write mode ('w') 
//     $nomeDoArquivo = "./filters/$nomeDoArquivo" . ".csv";
//     $fp = fopen($nomeDoArquivo, 'w');

//     $delimiter = ',';

//     $headings = array('link', 'texto', 'html');

//     fputcsv($fp, $headings);

//     foreach ($list as $dados) {
//         foreach ($dados as $row) {
//             //var_dump($row);
//             fputcsv($fp, $row);
//         }
//     }


//     fclose($fp);
// }


function gravar(String $json, String $nomeDoArquivo)
{
    //echo $json;
    //Variável arquivo armazena o nome e extensão do arquivo.
    $nomeDoArquivo = "./filters/$nomeDoArquivo" . ".json";

    //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
    $fp = fopen($nomeDoArquivo, "w");

    //Escreve no arquivo aberto.
    fwrite($fp, $json);

    //Fecha o arquivo.
    fclose($fp);
}


function Percentual(String $processoName, $total, $y = 0)
{
    //usleep(1);
    $percent =  (100 * $y) / $total;
    echo chr(27) . chr(91) . 'H' . chr(27) . chr(91) . 'J';
    printf("Gerando $processoName ");
    echo number_format($percent + 0.1, 1, '.', ',') . '%';
    if ($percent > 95.0) {
        echo chr(27) . chr(91) . 'H' . chr(27) . chr(91) . 'J';
        printf("Gerando $processoName ");
        echo number_format(100, 1, '.', ',') . '%';
    }
}

function matchSite(array &$arr, String $site)
{
    $matches = [];
    preg_match('([a-zA-Z._-]+\.[a-zA-Z_-]+)', $site, $matches);
    $matches = isset(($matches)[0]) ? ($matches)[0] : NULL;

    if (isset($matches)) {
        $index = 'Site';
        $match = $matches;
        $arr[$index] = $match;
        return true;
    }
    return false;
}

function matchLogradouro(array &$arr, String $logradouro)
{
    preg_match('/([\w\W]+)\s(\d+)/', $logradouro, $matches);
    $matches = isset(($matches)[0]) ? ($matches)[0] : NULL;

    if (isset($matches)) {
        $index = 'Endereço';
        $match = $matches;
        $arr[$index] = $match;
        return true;
    }
    return false;
}

//var_dump($logradouro);

function matchTelefone(array &$arr, String $telefone): Bool
{
    preg_match('/(\(?\d{2}\)?\s)?(\d{4,5}\-\d{4})/', $telefone, $matches);

    $matches = isset(($matches)[0]) ? ($matches)[0] : NULL;

    if (isset($matches)) {
        $index = 'Telefone';
        $match = $matches;
        $arr[$index] = $match;
        return true;
    }
    return false;
}

// Passagem por referencia != passagem por parametro
// Passagem por parametro faz uma copia da variavel
// referencia acessa o valor direto na memoria . <- tomar cuidado também . 
//vc modifica o dado dentro da função
function matchEmail(array &$arr, String $string)
{
    $matches = [];
    preg_match('/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9_-]+)/', $string, $matches);

    $matches = isset(($matches)[0]) ? ($matches)[0] : NULL;

    if (isset($matches)) {
        $index = 'E-mail';
        $match = $matches;
        $arr[$index] = $match;
        return true;
    }
    return false;
}
