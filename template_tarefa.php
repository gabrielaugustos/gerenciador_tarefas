<html>

<head>
    <meta charset="utf-8" />
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="tarefas.css" type="text/css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <div="bloco_principal">
        <br>
        <h1>Tarefa:
            <?php echo $tarefa['nome']; ?>
        </h1>
        <br>
        <p>
            <a href="tarefas.php">
                Voltar para a lista de tarefas
            </a>
        </p>
        <br>
        <p>
            <strong>Concluída:</strong>
            <?php echo
                traduz_concluida($tarefa['concluida']); ?>
        </p>
        <p>
            <strong>Descrição:</strong>
            <?php echo nl2br($tarefa['descricao']); ?>
        </p>
        <p>
            <strong>Prazo:</strong>
            <?php echo
                traduz_data_para_exibir($tarefa['prazo']); ?>
        </p>
        <p>
            <strong>Prioridade:</strong>
            <?php echo
                traduz_prioridade($tarefa['prioridade']); ?>
        </p>
        <br>
        <h2>Anexos</h2>
        <!-- lista de anexos -->
        <?php if (isset($anexos) && count($anexos) > 0): ?>
            <table>
                <tr>
                    <th>Arquivo</th>
                    <th>Opções</th>
                </tr>
                <?php foreach ($anexos as $anexo): ?>
                    <tr>
                        <td>
                            <?php echo $anexo['nome']; ?>
                        </td>
                        <td class="opcoes">
                            <a href="anexos/<?php echo $anexo['arquivo']; ?>" class="baixar">
                                <span class="material-symbols-outlined">
                                    download
                                </span>
                            </a>
                            <span>&nbsp;</span>
                            <a href="remover_anexo.php?id=<?php echo $anexo['id']; ?>" class="remover">
                                Remover
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Não há anexos para esta tarefa.</p>
        <?php endif; ?>
        <!-- formulário para um novo anexo -->
        </div>
</body>
<!-- formulário para um novo anexo -->
<form action="" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Novo anexo</legend>
        <input type="hidden" name="tarefa_id" value="<?php echo $tarefa['id']; ?>" />
        <label>
            <?php if ($tem_erros && array_key_exists('anexo', $erros_validacao)): ?>
                <span class="erro">
                    <?php echo $erros_validacao['anexo']; ?>
                </span>
            <?php endif; ?>
            <input type="file" name="anexo" />
        </label>
        <input type="submit" value="Cadastrar" class="cadastrar">
    </fieldset>
</form>

<style>
    p {
        margin: 10px 80px;
    }

    h2 {
        margin: 10px 80px;
    }

    .cadastrar {
        font-size: 15px;
        background: #d9fbd9;
        color: #333;
        border: solid 1px;
        border-radius: 2px;
        cursor: pointer;
    }

    .opcoes {
        display: flex;
        flex-direction: row;
        gap: 18px;
    }

    .baixar {
        /* border: solid 1px blue;
        border-radius: 3px;
        background: #336699;
        color: #FFF; */
        text-decoration: none;
        padding: 7px;
    }

    .baixar:hover{
        background: #e9e9e9;
        border-radius: 3px;
    }

    .remover {
        border: solid 1px red;
        border-radius: 3px;
        text-decoration: none;
        background: #F44;
        color: #FFF;
        padding: 0px 7px;
        display: flex;
        justify-content: center;
        /* Centraliza horizontalmente */
        align-items: center;
        /* Centraliza verticalmente */
    }

    .remover:hover {
        background-color: red;
    }
</style>

</html>