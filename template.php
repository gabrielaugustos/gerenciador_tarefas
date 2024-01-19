<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="tarefas.css" type="text/css" />
</head>
<body>
    <h1>Gerenciador de Tarefas</h1>
    <?php require 'formulario.php'; ?>
    <!--verificará se a tabela deve ou não ser exibida-->
    <?php if ($exibir_tabela): ?>
        <?php require 'tabela.php'; ?>
    <?php endif; ?>
</body>

</html>