<?php
// $bdServidor = 'localhost';
// $bdUsuario = 'sistematarefas';
// $bdSenha = 'gabriel';
// $bdBanco = 'tarefas';

// $conexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco);

require_once "config.php";
$conexao = mysqli_connect(BD_SERVIDOR, BD_USUARIO, BD_SENHA, BD_BANCO);

if (mysqli_connect_errno()) {
    echo "Problemas para conectar no banco. Erro: ";
    echo mysqli_connect_error();
    die();
}

function buscar_tarefas($conexao)
{
    $sqlBusca = 'SELECT * FROM tarefas';
    $resultado = mysqli_query($conexao, $sqlBusca);
    $tarefas = [];
    while ($tarefa = mysqli_fetch_assoc($resultado)) {
        $tarefas[] = $tarefa;
    }
    return $tarefas;
}


function gravar_tarefa($conexao, $tarefa)
{
    if ($tarefa['prazo'] == '') {
        $prazo = 'NULL';
    } else {
        $prazo = "'{$tarefa['prazo']}'";
    }

    $sqlGravar = "
            INSERT INTO tarefas
            (nome, descricao, prioridade, prazo, concluida)
            VALUES
            (
                '{$tarefa['nome']}',
                '{$tarefa['descricao']}',
                '{$tarefa['prioridade']}',
                {$prazo},
                '{$tarefa['concluida']}'
            )
        ";

    mysqli_query($conexao, $sqlGravar);
}

function buscar_tarefa($conexao, $id)
{
    $sqlBusca = 'SELECT * FROM tarefas WHERE id = ' . $id;
    $resultado = mysqli_query($conexao, $sqlBusca);
    return mysqli_fetch_assoc($resultado);
}

function editar_tarefa($conexao, $tarefa)
{
    if ($tarefa['prazo'] == '') {
        $prazo = 'NULL';
    } else {
        $prazo = "'{$tarefa['prazo']}'";
    }
    $sqlEditar = "
            UPDATE tarefas SET
                nome = '{$tarefa['nome']}',
                descricao = '{$tarefa['descricao']}',
                prioridade = {$tarefa['prioridade']},
                prazo = {$prazo},
                concluida = {$tarefa['concluida']}
            WHERE id = {$tarefa['id']}
        ";
    mysqli_query($conexao, $sqlEditar);
}

function remover_tarefa($conexao, $id)
{
    $sqlRemover = "DELETE FROM tarefas WHERE id = {$id}";
    mysqli_query($conexao, $sqlRemover);
}

function gravar_anexo($conexao, $anexo)
{
    $sqlGravar = "INSERT INTO anexos
            (tarefa_id, nome, arquivo)
            VALUES
            (
                {$anexo['tarefa_id']},
                '{$anexo['nome']}',
                '{$anexo['arquivo']}'
            )
        ";
    mysqli_query($conexao, $sqlGravar);
}

function buscar_anexos($conexao, $tarefa_id)
{
    $sql = "SELECT * FROM anexos
        WHERE tarefa_id = {$tarefa_id}";
    $resultado = mysqli_query($conexao, $sql);
    $anexos = [];
    while ($anexo = mysqli_fetch_assoc($resultado)) {
        $anexos[] = $anexo;
    }
    return $anexos;
}

function buscar_anexo($conexao, $id)
{
    $sqlBusca = 'SELECT * FROM anexos WHERE id = ' . $id;
    $resultado = mysqli_query($conexao, $sqlBusca);
    return mysqli_fetch_assoc($resultado);
}

function remover_anexo($conexao, $id)
{
    $sqlRemover = "DELETE FROM anexos WHERE id = {$id}";
    mysqli_query($conexao, $sqlRemover);
}