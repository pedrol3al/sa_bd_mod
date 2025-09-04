<?php
session_start();
require_once('../Conexao/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se usuário existe e não está inativo
    if ($usuario) {
        if ($usuario['inativo'] == 1) {
            // USUÁRIO INATIVO - NÃO PERMITE LOGIN
            echo "
            <!DOCTYPE html>
            <html lang='pt-br'>
            <head>
                <meta charset='UTF-8'>
                <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css'>
                <script src='https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js'></script>
                <style>
                    .notyf__toast {
                        margin: 0 auto;
                        max-width: 400px;
                    }
                </style>
            </head>
            <body>
                <script>
                    const notyf = new Notyf({
                        duration: 5000,
                        position: {
                            x: 'center',
                            y: 'top'
                        },
                        types: [
                            {
                                type: 'warning',
                                background: '#ffc107',
                                icon: {
                                    className: 'bi bi-exclamation-triangle',
                                    tagName: 'i',
                                    text: ''
                                }
                            }
                        ]
                    });
                    
                    notyf.error('Sua conta está desativada. Entre em contato com o administrador.');
                    
                    setTimeout(() => {
                        window.location.href = '../index.php';
                    }, 3000);
                </script>
            </body>
            </html>
            ";
            exit();
        }

        if (password_verify($senha, $usuario['senha'])) {
            // LOGIN BEM SUCEDIDO DEFINE VARIÁVEIS DE SESSÃO
            $_SESSION['usuario'] = $usuario['nome'];
            $_SESSION['perfil'] = $usuario['id_perfil'];
            $_SESSION['id_usuario'] = $usuario['id_usuario'];

            // VERIFICA SE A SENHA É TEMPORÁRIA 
            if ($usuario['senha_temporaria']) {
                // REDIRECIONA PARA A TROCA DE SENHA
                header("Location: alterar_senha.php");
                exit();
            } else {
                // REDIRECIONA PARA A PÁGINA PRINCIPAL
                header("Location: ../Principal/main.php");
                exit();
            }
        }
    }
    
    // LOGIN INVÁLIDO (usuário não existe OU senha incorreta)
    echo "
    <!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css'>
        <script src='https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js'></script>
        <style>
            .notyf__toast {
                margin: 0 auto;
                max-width: 400px;
            }
        </style>
    </head>
    <body>
        <script>
            const notyf = new Notyf({
                duration: 5000,
                position: {
                    x: 'center',
                    y: 'top'
                },
                types: [
                    {
                        type: 'error',
                        background: '#dc3545',
                        icon: {
                            className: 'bi bi-x-circle',
                            tagName: 'i',
                            text: ''
                        }
                    }
                ]
            });
            
            notyf.error('E-mail ou senha incorretos!');
            
            setTimeout(() => {
                window.location.href = '../index.php';
            }, 3000);
        </script>
    </body>
    </html>
    ";
}
?>