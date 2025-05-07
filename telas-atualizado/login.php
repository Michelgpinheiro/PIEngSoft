<?php 

    require_once __DIR__ . '/../php/users/admin.php';
    require_once __DIR__ . '/../php/users/legal-entity.php';
    require_once __DIR__ . '/../php/users/physical-person.php';

    session_start();

    $email = $_POST['login'] ?? '';
    $password = $_POST['senha'] ?? '';

    // Exemplo de "banco de dados simulado"
    $users = [
        new Admin(), new PhysicalPerson(), new LegalEntity()
    ];

    // Simulando dados fictícios de um Admin
    $users[0]->setEmail("admin@email.com");
    $users[0]->setPassword("12345");
    $users[0]->name = "Administrador";

    // Verificação simples (em produção, compare senhas criptografadas)
    foreach ($users as $user) {
        if (($user->getEmail() === $email) && ($user->getPassword() === $password)) {
            $_SESSION['user_name'] = $user->name ?? 'Usuário';
            $_SESSION['user_type'] = get_class($user);
            header('Location: tela-inicial.php');
            exit;
        }
    }

    // Se falhou:
    // echo "<script>alert('Usuário ou senha inválidos'); window.location.href = 'index.html';</script>";


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login/--style-login.css">
</head>
<body>
    <main>
        <section class="section-titulo section">
            <h1><span class="h1-span-1">Sua plataforma</span><br><span class="h1-span-2">de leilões online</span></h1>
        </section>
        <section class="section-login section">
            <div class="formulario">
                <h2>Bem-vindo</h2>
                <form action="" method="post">
                    <div class="inputs">
                        
                        <input type="text" name="login" id="login" placeholder="Email..." class="input-login input">
                        
                        <input type="password" name="senha" id="senha" placeholder="Senha..." class="input-senha input">
                        
                    </div>
                    <a class="esqueceu-senha" href="recuperar-senha.php">Esqueceu a senha?</a>
                    <div class="button-entrar">
                        <button type="submit" class="entrar">Entrar</button>
                    </div>
                    <a class="cadastrar-conta" href="cadastro-usuario-cpf.php">Não tem uma conta? Cadastre-se aqui</a>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
                        
                        