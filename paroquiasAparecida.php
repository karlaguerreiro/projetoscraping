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
gravar(json_encode($lista), 'Paroquias');
gravarCSV($lista, 'Paroquias');



function gravarCSV(array $list, String $nomeDoArquivo)
{
    // Create an array of elements 


    // Open a file in write mode ('w') 
    $nomeDoArquivo = "./filters/$nomeDoArquivo" . ".xls";
    $fp = fopen($nomeDoArquivo, 'w');

    $delimiter = ',';

    $headings = array('Nome', 'Endereço', 'Cep', 'E-mail', 'Telefone', 'Facebook');

    fputcsv($fp, $headings);

    foreach ($list as $dados) {

        //var_dump($row);
        fputcsv($fp, $dados);
    }


    fclose($fp);
}




function getParoquiaContents($nome, $link): array
{
    $html = file_get_html($link);
    $arrAux = [];
    $arrAux['nome'] = $nome;
    
    $ret = $html->find('div[class=col-md-6]');
    foreach ($ret as $pai) {
        $f = $pai->find('<p>');
        foreach ($f as $filho) {

            $content = $filho->plaintext;
            $n = $filho->find('strong');
            foreach ($n as $neto) {
                $index = str_replace(':', "", $neto->plaintext);
            }
            $arrAux[$index] = $content;
        }
    }

    $palavrasRemover = ['Telefone:', 'Endereço:', 'Cep:', 'E-mail:', 'Facebook:', " "];

    foreach ($arrAux as $i => $frases) {
        $arrAux[$i] = str_replace($palavrasRemover, '', $frases);
    }


    return ($arrAux);
}




//Gera lista de links
function geraListaParoquias()
{
    $links = getLinksParoquias();
    $listaDados = [];
    for ($i = 0; $i < count($links); $i++) {
        Percentual(' Conteudo Paroquias', count($links), $i);
        // var_dump(getParoquiaContents($links[$i]));
        array_push($listaDados, getParoquiaContents($links[$i]['nome'], $links[$i]['link']));
    }
    return $listaDados;
}

//Array de links - Página Principal
function getLinksParoquias(): array
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

                array_push($dados, ['nome' => $nome, 'link' => $href]);
            }
        }
    }
    //var_dump($dados);
    return $dados;
}
