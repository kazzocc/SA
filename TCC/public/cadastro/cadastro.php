<?php
// Incluir as classes do PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Usando o namespace do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Conexão com o banco de dados
$conexao = mysqli_connect("localhost", "root", "", "tccSA");

if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Receber dados do formulário
$nome  = mysqli_real_escape_string($conexao, $_POST["nome"]);
$email = mysqli_real_escape_string($conexao, $_POST["email"]);
$senha = mysqli_real_escape_string($conexao, $_POST["senha"]);
$tipo  = mysqli_real_escape_string($conexao, $_POST["tipo_conta"]);

// Preparar a consulta para inserção no banco de dados
$query = "INSERT INTO tb_usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conexao, $query);
mysqli_stmt_bind_param($stmt, "ssss", $nome, $email, $senha, $tipo);

// Executar a consulta de inserção
if (mysqli_stmt_execute($stmt)) {
    // Cadastro realizado com sucesso, agora enviar o e-mail

    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Autenticação SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'andreluiznetsolutions@gmail.com';  // Seu e-mail
        $mail->Password   = 'dyqw cdww whdd hclb';      // Sua senha ou senha de aplicativo

        // Definir remetente e destinatário
        $mail->setFrom('andreluiznetsolutions@gmail.com', 'André Luiz');
        $mail->addAddress($email); // O e-mail do usuário que se cadastrou

        // Definir o conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Cadastro realizado no site da ETEC';
        $mail->Body    = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .greeting { font-size: 20px; font-weight: bold; color: #4CAF50; }
                    .message { font-size: 16px; }
                    .footer { font-size: 12px; color: #777; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <p class='greeting'>Olá, <b>$nome</b>!</p>
                    <p class='message'>Seja muito bem-vindo à nossa plataforma da ETEC! Seu cadastro foi realizado com sucesso. Estamos felizes em tê-lo conosco.</p>
                    <p class='message'>Agora você pode acessar nossos recursos e começar a explorar o conteúdo disponível. Caso tenha alguma dúvida, nossa equipe de suporte está à disposição para ajudá-lo.</p>
                    <p class='footer'>Atenciosamente,<br>Equipe ETEC</p>
                </div>
            </body>
            </html>
        ";

        // Enviar o e-mail
        $mail->send();
        echo "<script>alert('Cadastro realizado com sucesso! Um e-mail de boas-vindas foi enviado para o seu endereço.');</script>";
        echo '<meta http-equiv="refresh" content="3; url=cadastro.html">'; // Redireciona após 3 segundos
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
} else {
    // Caso o cadastro falhe
    echo "<script>alert('Erro ao cadastrar usuário. Tente novamente.');</script>";
    echo '<meta http-equiv="refresh" content="3; url=cadastro.html">'; // Redireciona após 3 segundos
}

// Fechar a conexão
mysqli_stmt_close($stmt);
mysqli_close($conexao);
?>
