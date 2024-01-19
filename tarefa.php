<?php

// O código verifica se o anexo é válido, e,
// se for, configura um array $anexo com informações relevantes sobre o anexo, 
// como a tarefa à qual está associado, o nome do arquivo sem a extensão
// e o nome do arquivo completo.
error_reporting(E_ALL);
ini_set('display_errors', 1);


require "config.php";
include "banco.php";
include "ajudantes.php";



$tarefa_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($tarefa_id === null) {
    // Se 'id' não está presente na URL, você pode tratar isso de acordo
    http_response_code(404);
    echo "ID da tarefa não especificado.";
    die();
}

$tarefa = buscar_tarefa($conexao, $tarefa_id);

$tem_erros = false;
$erros_validacao = array();

if (tem_post()) {
    // upload dos anexos
    $tarefa_id = $_POST['tarefa_id'];
    
    if (!isset($_FILES['anexo'])) {
        $tem_erros = true;
        $erros_validacao['anexo'] = 'Você deve selecionar um arquivo para anexar';
    } else {
        if (tratar_anexo($_FILES['anexo'])) {
            $anexo = array();
            $anexo['tarefa_id'] = $tarefa_id;
            $anexo['nome'] = substr($_FILES['anexo']['name'], 0, -4);
            $anexo['arquivo'] = $_FILES['anexo']['name'];
        } else {
            $tem_erros = true;
            $erros_validacao['anexo'] = 'Envie apenas anexos nos formatos zip ou pdf';
        }
    }
    
    if (!$tem_erros) {
        gravar_anexo($conexao, $anexo);
        header('Location: tarefa.php?id='.$tarefa_id);
    }
}

$anexos = buscar_anexos($conexao, $_GET['id']);

include "template_tarefa.php";