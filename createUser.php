<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['Nome'];
    $cpf = $_POST['CPF'];
    $celular = $_POST['Celular'];
    $email = $_POST['E-mail'];
    $senha = password_hash($_POST['Senha'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (nome, cpf, celular, email, senha) VALUES (:nome,  :cpf, :celular, :email, :senha)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nome' => $nome, ':email' => $email, ':cpf' => $cpf, ':celular' => $celular, ':senha' => $senha]);

    echo "Usuário criado com sucesso!";
}
?>

