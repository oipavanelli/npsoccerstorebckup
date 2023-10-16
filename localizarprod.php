<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$bancodedados = 'npsoccerstore';

// Estabelecer a conexão com o banco de dados usando a extensão MySQLi
$conn = mysqli_connect($host, $usuario, $senha, $bancodedados);

// Verificar se a conexão foi bem-sucedida
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Função para evitar injeção de SQL
function limparEntrada($entrada) {
    global $conn;
    return mysqli_real_escape_string($conn, $entrada);
}

// Consulta para recuperar todos os registros da tabela
$query = "SELECT id, nomeprod, descricao, valor, imagem FROM produtos";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Erro ao recuperar dados do banco de dados: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Página de Produtos</title>
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    header {
        background-color: #333; /* Cor de fundo do cabeçalho */
        color: #fff;
        padding: 20px;
        text-align: center;
    }

    header a {
        color: #fff; /* Cor dos links no cabeçalho */
        text-decoration: none;
        margin: 0 20px; /* Espaçamento entre os links */
        position: relative;
    }

    header a:hover {
        text-decoration: underline; /* Sublinhar os links quando o mouse passar por cima */
    }

    header .dropdown {
        position: relative;
        display: inline-block;
    }

    header .dropdown-content {
        display: none;
        position: absolute;
        background-color: #fff; /* Fundo branco */
        border: 1px solid #333; /* Borda preta */
        min-width: 160px;
        z-index: 1;
    }

    header .dropdown:hover .dropdown-content {
        display: block;
    }

    header .dropdown-content a {
        color: #000; /* Cor do texto */
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    header .dropdown-content a:hover {
        background-color: #1df68d;
        color: #fff; /* Cor do texto ao passar o mouse */
    }

    h1 {
        margin: 0;
        color: black;
    }

    .product-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .product {
        width: 300px;
        margin: 20px;
        border: 1.9px solid green;
        border-radius: 20px;
        padding: 25px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .product:hover {
        transform: translateY(-10px);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .product img {
        max-width: 100%;
        height: auto;
    }

    .product h2 {
        margin-top: 0;
    }

    .product p {
        margin-bottom: 0;
    }
    </style>
    <script>
        // Função para editar a camisa
        function editarCamisa(camisaId) {
            // Redirecionar para a página de edição com o ID fornecido
            window.location.href = "editar.php?id=" + camisaId;
        }

        // Função para excluir a camisa
        function excluirCamisa(camisaId) {
            if (confirm("Tem certeza de que deseja excluir esta camisa?")) {
                // Redirecionar para a página de exclusão com o ID fornecido
                window.location.href = "excluir.php?id=" + camisaId;
            }
        }

        // Função para abrir a página de descrição do produto
        function abrirPaginaDescricao(event) {
            var paginaDescricao = event.currentTarget.getAttribute("data-pagina");
            if (paginaDescricao) {
                window.open(paginaDescricao, "_blank");
            }
        }

        // Adiciona o evento de clique em todos os elementos com a classe "product"
        window.addEventListener("DOMContentLoaded", function () {
            var products = document.getElementsByClassName("product");
            for (var i = 0; i < products.length; i++) {
                products[i].addEventListener("click", abrirPaginaDescricao);
            }
        });
    </script>
</head>
<body>
<header>
    <a href="cadastroprod.php">Cadastrar Produtos</a>
    <a href="localizarcad.php">Localizar Usuários</a>
    <div class="dropdown">
        <a href="#">Relatórios</a>
        <div class="dropdown-content">
            <a href="#">Camisas</a>
            <a href="#">Chuteiras</a>
        </div>
    </div>
    <a href="telainicial.php">Sair</a>
</header>
<center>
<h1>Camisas</h1>
</center>
<div class="product-container">
<?php
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $nomeprod = $row['nomeprod'];
    $descricao = $row['descricao'];
    $valor = $row['valor'];
    $imagemNome = $row['imagem'];

    echo '<div class="product" data-pagina="desc.php">';
    echo '<img src="' . $imagemNome . '" alt="' . $nomeprod . '" style="margin-left: 30px;">';
    echo '<h2>' . $nomeprod . '</h2>';
    echo '<p>' . $descricao . '</p>';
    echo '<p>Preço: ' . $valor . '</p>';
    echo '<button onclick="editarCamisa(' . $id . ')">Editar</button>';
    echo '<button onclick="excluirCamisa(' . $id . ')">Excluir</button>';
    echo '</div>';
}
?>
</div>
</body>
</html>
<?php
// Fechar a conexão com o banco de dados
mysqli_close($conn);
?>
