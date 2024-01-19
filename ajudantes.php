<?php

use PHPMailer\PHPMailer\PHPMailer;

function traduz_prioridade($codigo)
{
    /*
    if ($codigo == 1){
        $prioridade = "Baixa";        
    }
    else if($codigo == 2){
        $prioridade = "Média";        
    }
    else if($codigo == 3){
        $prioridade = "Alta";
    }
    */

    $prioridade = '';
    switch ($codigo) {
        case 1:
            $prioridade = 'Baixa';
            break;
        case 2:
            $prioridade = 'Média';
            break;
        case 3:
            $prioridade = 'Alta';
            break;
    }
    return $prioridade;
}

function traduz_data_para_banco($data)
{
    if ($data == "") {
        return "";
    }
    // $dados = explode("/", $data);
    // $data_banco = "{$dados[2]}-{$dados[1]}-{$dados[0]}";
    // return $data_banco;
    $dados = explode("/", $data);
    if (count($dados) != 3) {
        return $data;
    }
    // $objeto_data = DateTime::createFromFormat('d/m/Y', $data);
    // return $objeto_data->format('Y-m-d');
    $data_mysql = "{$dados[2]}-{$dados[1]}-{$dados[0]}";

    return $data_mysql;
}

function traduz_data_para_exibir($data)
{
    if ($data == "" or $data == "0000-00-00") {
        return "";
    }
    // $dados = explode("-", $data);
    // $data_exibir = "{$dados[2]}/{$dados[1]}/{$dados[0]}";
    // return $data_exibir;
    $partes = explode("-", $data);
    // Novo retorno da data original
    if (count($partes) != 3) {
        return $data;
    }
    $objeto_data = DateTime::createFromFormat('Y-m-d', $data);
    return $objeto_data->format('d/m/Y');
}

function traduz_concluida($concluida)
{
    if ($concluida == 1) {
        return 'Sim';
    }
    return 'Não';
}

function tem_post()
{
    if (count($_POST) > 0) {
        return true;
    }
    return false;
}

function validar_data($data)
{
    // $padrao = '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/';
    // $resultado = preg_match($padrao, $data);
    // return ($resultado == 1);
    // if ($resultado == 0) {
    //     return false;
    // }
    // $dados = explode('/', $data);
    // $dia = $dados[0];
    // $mes = $dados[1];
    // $ano = $dados[2];
    // $checar = checkdate($mes, $dia, $ano);
    $dados = explode('-', $data);
    $dia = $dados[2];
    $mes = $dados[1];
    $ano = $dados[0];
    $checar = checkdate($mes, $dia, $ano);
    return $checar;
}

function tratar_anexo($anexo)
{
    $padrao = '/^.+(\.pdf|\.zip)$/';
    $resultado = preg_match($padrao, $anexo['name']);
    if ($resultado == 0) {
        return false;
    }
    move_uploaded_file(
        $anexo['tmp_name'],
        "anexos/{$anexo['name']}"
    );
    return true;
}

function enviar_email($tarefa, $anexos = [])
{
    include "bibliotecas/PHPMailer/inc.php";
    $corpo = preparar_corpo_email($tarefa, $anexos);
    // Acessar a aplicação de e-mails;
    // Fazer a autenticação com usuário e senha;
    // Usar a opção para escrever um e-mail;
    $email = new PHPMailer(); // Esta é a criação do objeto
    //$email->SMTPDebug = 3;
    $email->isSMTP();
    $email->Host = "smtp.gmail.com";
    $email->Port = 587;
    $email->SMTPSecure = 'tls';
    $email->SMTPAuth = true;
    $email->Username = "meuemail@gmail.com";
    $email->Password = "minhasenha";
    $email->setFrom("meuemail@gmail.com", "Avisador de Tarefas");

    // Digitar o e-mail de destinatário;
    $email->addAddress(EMAIL_NOTIFICACAO);

    // Digitar o assunto do e-mail;
    $email->Subject = "Aviso de tarefa: {$tarefa['nome']}";

    // Escrever o corpo do e-mail;
    $corpo = preparar_corpo_email($tarefa, $anexos);
    $email->msgHTML($corpo);

    // Adicionar os anexos, quando necessário;
    foreach ($anexos as $anexo) {
        $email->addAttachment("anexos/{$anexo['arquivo']}");
    }
    // Usar a opção de enviar o e-mail.
    if (!$email->send()) {
        // salvar o erro em um arquivo de log
        gravar_log($email->ErrorInfo);
    }
    // ...
}
function preparar_corpo_email($tarefa, $anexos)
{
    // Aqui vamos pegar o conteúdo processado
    // do arquivo template_email.php

    // Falar para o PHP que não é para enviar
    // o resultado do processamento para o navegador:
    ob_start();

    // Incluir o arquivo template_email.php:
    include "template_email.php";

    // Guardar o conteúdo do arquivo em uma variável;
    $corpo = ob_get_contents();

    // Falar para o PHP que ele pode voltar
    // a mandar conteúdos para o navegador.
    ob_end_clean();
    return $corpo;
}

function gravar_log($mensagem)
{
    $datahora = date("Y-m-d H:i:s");
    $mensagem = "{$datahora} {$mensagem}\n";
    file_put_contents("mensagens.log", $mensagem, FILE_APPEND);
}