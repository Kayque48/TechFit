<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>

    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1E5332, #68A842);
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 30px;
            padding: 20px;
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.4);
        }

        .card {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            width: 300px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            backdrop-filter: blur(4px);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            animation: fadeIn 0.6s ease forwards;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
        }

        a {
            display: inline-block;
            margin-top: 10px;
            background: #FBC70B;
            color: #1E5332;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: bold;
            text-decoration: none;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        a:hover {
            background: #E95D29;
            color: #fff;
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="card">
        <h1>Página de Cadastro do Usuário</h1>
        <a href="../public/cadUser.php">Acessar</a>
    </div>

    <div class="card">
        <h1>Página de Login do Usuário</h1>
        <a href="public/loginUser.php">Acessar</a>
    </div>

    <div class="card">
        <h1>Página de Cadastro de Produto</h1>
        <a href="public/cadastroProduto.php">Acessar</a>
    </div>

    <div class="card">
        <h1>Página da Tela do Cliente</h1>
        <a href="public/telaCliente.php">Acessar</a>
    </div>

    <script>
        // Pequeno script para logar no console quando clicarem em um link
        document.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", () => {
                console.log(`Redirecionando para: ${link.getAttribute("href")}`);
            });
        });
    </script>
</body>
</html>
