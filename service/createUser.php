<?php
require_once '../Database.php';
require_once '../entities/Users.php';
require_once '../dao/UserDAO.php';

use Entities\User;
use DAO\UserDAO;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    $user = new User();
    $user->setName($_POST['Nome']);
    $user->setCpf($_POST['CPF']);
    $user->setPhone($_POST['Celular']);
    $user->setEmail($_POST['E-mail']);
    $user->setPassword($_POST['Senha']);
    $user->setUserType('user'); // Define o tipo padrão

    $userDAO = new UserDAO($conn);

    if ($userDAO->create($user)) {
        echo "Usuário criado com sucesso!";
    } else {
        echo "Erro ao criar usuário.";
    }
}
?>
