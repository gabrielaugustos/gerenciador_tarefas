<?php
//Onde todas as tarefas serão exibidas 
?>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<table>
    <tr>
        <th>Tarefa</th>
        <th>Descricao</th>
        <th>Prazo</th>
        <th>Prioridade</th>
        <th>Concluída</th>
        <th>Opções</th>
    </tr>
    <?php foreach ($lista_tarefas as $tarefa): ?>
        <tr>
            <td class="nome">
                <a href="tarefa.php?id=<?php echo $tarefa['id']; ?>">
                    <span class="material-symbols-outlined" style="color:blue;">
                        attach_file_add
                    </span>
                </a>
                <?php echo $tarefa['nome']; ?>
            </td>
            <td class="descricao">
                <?php echo trim($tarefa['descricao']); ?>
            </td>
            <td>
                <?php echo traduz_data_para_exibir($tarefa['prazo']); ?>
            </td>
            <td class="prioridade">
                <?php echo traduz_prioridade($tarefa['prioridade']); ?>
            </td>
            <td class="concluida">
                <?php echo traduz_concluida($tarefa['concluida']); ?>
            </td>
            <!-- A célula com os links para
             editar e remover tarefas -->
            <td>
                <span>&nbsp;</span>
                <a href="editar.php?id=<?php echo $tarefa['id']; ?>" class="editar">
                    Editar
                </a>
                <span>&nbsp;</span>
                <a href="remover.php?id=<?php echo $tarefa['id']; ?>" onclick="return confirmarExclusao();" class="remover">
                    Remover
                </a>
                <script>
                    function confirmarExclusao() {
                        return confirm("Tem certeza de que deseja excluir esta tarefa?");
                    }
                </script>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<style>
    th {
        border: solid 1px #333;
    }

    td {
        border-right: solid 1px #333;
    }

    .nome {
        border-left: solid 1px #333;
    }

    .nome a {
        text-decoration: none;
        color: black;
    }

    .editar {
        text-align: center;
    }

    span {
        margin: 0 5px;
    }

    .concluida {
        text-align: center;
    }

    .prioridade {
        text-align: center;
    }

    .prazo {
        text-align: center;
    }

    .remover {
        font-size: 15px;
        border: solid 1px red;
        border-radius: 3px;
        text-decoration: none;
        background: #F44;
        color: #FFF;
        padding: 2px 7px;
    }

    .remover:hover {
        background-color: red;
    }

    .editar {
        font-size: 15px;
        border: solid 1px blue;
        border-radius: 3px;
        text-decoration: none;
        background: #336699;
        color: #FFF;
        padding: 2px 7px;
    }

    .editar:hover{
        background-color: blue;
    }
</style>