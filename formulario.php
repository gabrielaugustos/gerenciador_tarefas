<?php
// Onde será exibido o formulário para inserir dados da tarefa
?>

<form method="POST">
    <input type="hidden" name="id" value="<?php echo $tarefa['id']; ?>" />
    <fieldset>
        <legend>Nova tarefa</legend>
        <label>
            Tarefa:
            <!--<input type="text" name="nome" value="<?php echo $tarefa['nome']; ?>" />-->
            <?php
            if ($tem_erros && array_key_exists('nome', $erros_validacao)): ?>
                <span class="erro">
                    <?php echo $erros_validacao['nome']; ?>
                </span>
            <?php endif; ?>
            <input type="text" name="nome" value="<?php echo $tarefa['nome']; ?>" />
        </label>
        <label>
            Descrição (Opcional):
            <textarea name="descricao"><?php echo trim($tarefa['descricao']); ?></textarea>
        </label>
        <label>
            Prazo (Opcional):
            <!--<input type="text" name="prazo" value="<?php
            //echo traduz_data_para_exibir($tarefa['prazo']);
            ?>" placeholder="Ex.: 12/12/2000" /> -->
            <?php
            if ($tem_erros && array_key_exists('prazo', $erros_validacao)): ?>
                <span class="erro">
                    <?php echo $erros_validacao['prazo']; ?>
                </span>
            <?php endif; ?>
            <input type="date" name="prazo" value="<?php echo
                traduz_data_para_exibir($tarefa['prazo']); ?>" />
        </label>
        <fieldset>
            <legend>Prioridade:</legend>
            <label>
                <input type="radio" name="prioridade" value="1" <?php echo ($tarefa['prioridade'] == 1)
                    ? 'checked'
                    : '';
                ?> /> Baixa
                <input type="radio" name="prioridade" value="2" <?php echo ($tarefa['prioridade'] == 2)
                    ? 'checked'
                    : '';
                ?> /> Média
                <input type="radio" name="prioridade" value="3" <?php echo ($tarefa['prioridade'] == 3)
                    ? 'checked'
                    : '';
                ?> /> Alta
            </label>
        </fieldset>
        <label>
            Tarefa concluída:
            <input type="checkbox" name="concluida" value="1" <?php echo ($tarefa['concluida'] == 1) ? 'checked' : '';
            ?> />
        </label>
        <label>
            Lembrete por e-mail:
            <input type="checkbox" name="lembrete" value="1" />
        </label>
        <br>
        <input type="submit" value="<?php echo ($tarefa['id'] > 0) ? 'Atualizar' : 'Cadastrar'; ?> "
            class="cadastrar" />
        <?php
        if ($tarefa['id'] > 0): ?>
            <a href="tarefas.php" class="cancelar">
                Cancelar
            </a>
        <?php endif; ?>
    </fieldset>
</form>
<?php
// $lista_tarefas = [];
// if (array_key_exists('nome', $_GET)) {
//     $lista_tarefas[] = $_GET['nome'];
// }
?>

<!-- <table>
    <tr>
        <th>Tarefas</th>
    </tr>
    <?php
    foreach ($lista_tarefas as $tarefa): ?>
        <tr>
            <td>
                <?php echo $tarefa ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table> -->

<style>
    .cadastrar {
        font-size: 15px;
        background: #d9fbd9;
        color: #333;
        border: solid 1px;
        border-radius: 2px;
        cursor: pointer;
        padding: 2px 7px;
    }

    .cadastrar:hover {
        background-color: #b8f9b8;
    }

    .cancelar {
        font-size: 15px;
        border: solid 1px;
        border-radius: 2px;
        text-decoration: none;
        background: #FF6666;
        color: #333;
        padding: 2px 7px;
    }

    .cancelar:hover {
        background: #F44;
    }
</style>