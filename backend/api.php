<?php
header("Content-Type: application/json");
require_once 'includes/db_connect.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

try {
    switch($method) {
        case 'GET':
            // Listar todos os itens
            $stmt = $conn->query("SELECT * FROM itens");
            $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($itens);
            break;

        case 'POST':
            // Criar novo item
            $stmt = $conn->prepare("INSERT INTO itens (nome, tipo, quantidade, preco, descricao) 
                                  VALUES (:nome, :tipo, :quantidade, :preco, :descricao)");
            $stmt->execute($input);
            echo json_encode(['message' => 'Item criado com sucesso']);
            break;

        case 'PUT':
            // Atualizar item
            $stmt = $conn->prepare("UPDATE itens SET 
                                  nome = :nome, tipo = :tipo, quantidade = :quantidade, 
                                  preco = :preco, descricao = :descricao 
                                  WHERE id = :id");
            $stmt->execute($input);
            echo json_encode(['message' => 'Item atualizado com sucesso']);
            break;

        case 'DELETE':
            // Deletar item
            $stmt = $conn->prepare("DELETE FROM itens WHERE id = :id");
            $stmt->execute(['id' => $_GET['id']]);
            echo json_encode(['message' => 'Item deletado com sucesso']);
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido']);
    }
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
