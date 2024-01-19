<?php

// Onde tudo será armazenado e gravará no banco

session_start();
require 'vendor/autoload.php';
require "config.php";
require "banco.php";
require "ajudantes.php";

$exibir_tabela = true;

$tem_erros = false;
$erros_validacao = [];

// if (array_key_exists('nome', $_POST)) {
//     $semEspacoBranco = trim($_POST['nome']);

//     if ($semEspacoBranco != "") {
if (tem_post()) {
    $tarefa = [
        'id' => $_POST['id'],
        'nome' => $_POST['nome'],
        'descricao' => '',
        'prazo' => '',
        'prioridade' => $_POST['prioridade'],
        'concluida' => 0,
    ];
    if (strlen($tarefa['nome']) == 0) {
        $tem_erros = true;
        $erros_validacao['nome'] = 'O nome da tarefa é obrigatório!';
    }
    if (array_key_exists('descricao', $_POST)) {
        $tarefa['descricao'] = $_POST['descricao'];
    }

    // if (array_key_exists('prazo', $_POST)) {
    //     $tarefa['prazo'] =
    //         traduz_data_para_banco($_POST['prazo']);
    // }

    // agora com o input do tipo date não precisamos mais traduzir e nem validar 
    if (array_key_exists('prazo', $_POST) && strlen($_POST['prazo']) > 0) {
        $tarefa['prazo'] = $_POST['prazo'];
        // if (validar_data($_POST['prazo'])) {
        //     $tarefa['prazo'] = traduz_data_para_banco($_POST['prazo']);
        // } else {
        //      $tem_erros = true;
        //      $erros_validacao['prazo'] = 'O prazo não é uma data válida!';
        // }
    }

    if (array_key_exists('concluida', $_POST)) {
        $tarefa['concluida'] = 1;
    }

    //$_SESSION['lista_tarefas'][] = $tarefa;   
    if (!$tem_erros) {
        gravar_tarefa($conexao, $tarefa);
        if (
            array_key_exists('lembrete', $_POST)
            && $_POST['lembrete'] == '1'
        ) {
            enviar_email($tarefa);
        }
        header('Location: tarefas.php');
        die();
    }
}
// else {
//     header('Location: tarefas.php');
//     exit();
// }


/*  PARA FAZER A CONEXÃO COM O BANCO DE DADOS ESSA SESSÃO SERÁ APAGADA
if(array_key_exists('lista_tarefas', $_SESSION)) {
    $lista_tarefas = $_SESSION['lista_tarefas'];
} else {
    $lista_tarefas = [];
}
*/

//FAZENDO A CONEXÃO COM O BANCO DE DADOS
$lista_tarefas = buscar_tarefas($conexao);

// $tarefa = [
//     'id' => 0,
//     'nome' => '',
//     'descricao' => '',
//     'prazo' => '',
//     'prioridade' => 1,
//     'concluida' => ''
// ];

$tarefa = [
    'id' => 0,
    'nome' => $_POST['nome'] ?? '',
    'descricao' => $_POST['descricao'] ?? '',
    'prazo' => (array_key_exists('prazo', $_POST)) ? traduz_data_para_banco($_POST['prazo']) : '',
    'prioridade' => $_POST['prioridade'] ?? 1,
    'concluida' => $_POST['concluida'] ?? ''
];

require "template.php";