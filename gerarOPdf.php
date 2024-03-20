<?php 
require 'vendor/autoload.php';
require_once('conexao.php');


ob_clean();

$query = 'SELECT id, titulo, descricao from informacoes';
$chamados = $conn->prepare($query);
$chamados->execute();

$conteudoDaPagina = "<!DOCTYPE html>";
$conteudoDaPagina .= "<html lang=''>";
$conteudoDaPagina .= "<head>";
$conteudoDaPagina .= "<meta charset='UTF-8'>";
$conteudoDaPagina .= "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
$conteudoDaPagina .= "<title>Document</title>";
$conteudoDaPagina .= "</head>";
$conteudoDaPagina .= "<body>";
$conteudoDaPagina .= "<h1>Relatório dos Chamados</h1>";
$conteudoDaPagina .= "<hr>";

while($row_chamadosBancoDeDados = $chamados->fetch(PDO::FETCH_ASSOC)){

    extract($row_chamadosBancoDeDados); //extraindo colunas do banco de dados;
    
    $conteudoDaPagina .= "Numero: $id<br>";
    $conteudoDaPagina .= "Titulo: $titulo<br>";
    $conteudoDaPagina .= "Informação: $descricao<br>";
    $conteudoDaPagina .= "<br>";
    $conteudoDaPagina .= "<br>";
}


$conteudoDaPagina .= "</body>";

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml($conteudoDaPagina);

$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream();
?>
