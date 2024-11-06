<?php
require_once '../Database.php';
require_once '../entities/Products.php';
require_once '../dao/ProductDAO.php';

use Entities\Product;
use DAO\ProductDAO;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, PUT, GET, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

$db = new Database();
$conn = $db->getConnection();
$productDAO = new ProductDAO($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $product = new Product();

    if (isset($_GET['productId'])) {
        $productId = $_GET['productId'];
        $existingProduct = $productDAO->read($productId)->fetch(PDO::FETCH_ASSOC);

        if (!$existingProduct) {
            echo json_encode(["message" => "Produto não encontrado."]);
            exit;
        }

        $product->setProductId($productId);
        $product->setName(isset($data->name) ? $data->name : $existingProduct['name']);
        $product->setDescription(isset($data->description) ? $data->description : $existingProduct['description']);
        $product->setPrice(isset($data->price) ? $data->price : $existingProduct['price']);
        $product->setStock(isset($data->stock) ? $data->stock : $existingProduct['stock']);

        if ($productDAO->update($product)) {
            echo json_encode(["message" => "Produto atualizado com sucesso!"]);
        } else {
            echo json_encode(["message" => "Erro ao atualizar o produto."]);
        }
    } else {
        $product->setName($data->name);
        $product->setDescription($data->description);
        $product->setPrice($data->price);
        $product->setStock($data->stock);

        if ($productDAO->create($product)) {
            echo json_encode(["message" => "Produto criado com sucesso!"]);
        } else {
            echo json_encode(["message" => "Erro ao criar produto."]);
        }
    }
}

elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['productId'])) {
        $productId = $_GET['productId'];
        $stmt = $productDAO->read($productId);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($product ? $product : ["message" => "Produto não encontrado."]);
    } else {
        $stmt = $productDAO->read();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($products ? $products : ["message" => "Nenhum produto encontrado."]);
    }
}

elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['productId'])) {
        $productId = $_GET['productId'];

        if ($productDAO->delete($productId)) {
            echo json_encode(["message" => "Produto deletado com sucesso!"]);
        } else {
            echo json_encode(["message" => "Erro ao deletar o produto."]);
        }
    } else {
        echo json_encode(["message" => "ID do produto não fornecido."]);
    }
}
?>
