<?php
    require_once '../Database.php';
    require_once '../entities/User.php';
    require_once '../dao/UserDAO.php';

    use Entities\User;
    use DAO\UserDAO;

    //O CROS é utilizado para definir permissões de uso da API, ao usarmos o *, nós liberamos todos os usos.
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, PUT, GET, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Content-Type: application/json");

    $db = new Database();
    $conn = $db->getConnection();

    // O Métdo GET é utilizado para consulta, caso passemos o ID, ele retorna aquele usuário, 
    // mas se não passarmos nenhum ID, ele retorna todos os usuários
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $userDAO = new UserDAO($conn);

        if (isset($_GET['UserId'])) {
            $userId = $_GET['UserId'];
            $stmt = $userDAO->read($userId);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                echo json_encode($user);
            } else {
                echo json_encode(["message" => "Usuário não encontrado."]);
            }
        } else {
            $stmt = $userDAO->read();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($users) {
                echo json_encode($users);
            } else {
                echo json_encode(["message" => "Nenhum usuário encontrado."]);
            }
        }
    }

    // Utilizamos o Método post para o Update e para o Update 
    // (Caso passemos um ID já existnte, ele apenas edita, do contrário, ele insere)
    elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = json_decode(file_get_contents("php://input"));
        $db = new Database();
        $conn = $db->getConnection();
        $userDAO = new UserDAO($conn);
        
        if (isset($data->UserId)) {
            $stmt = $userDAO->read($data->UserId);
            $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$existingUser) {
                echo json_encode(["message" => "Usuário não encontrado."]);
                exit;
            }
    
            $user = new User();
            $user->setUserId($data->UserId);
            $user->setName(isset($data->Nome) ? $data->Nome : $existingUser['name']);
            $user->setCpf(isset($data->CPF) ? $data->CPF : $existingUser['cpf']);
            $user->setPhone(isset($data->Celular) ? $data->Celular : $existingUser['phone']);
            $user->setEmail(isset($data->Email) ? $data->Email : $existingUser['email']);
            $user->setPassword(isset($data->Senha) ? $data->Senha : $existingUser['password']);
            $user->setUserType(isset($data->UserType) ? $data->UserType : $existingUser['user_type']);
            
            // Verifica se o e-mail já existe e pertence a outro usuário.
            if (isset($data->Email) && $data->Email !== $existingUser['email']) {
                $emailCheckStmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND user_id != :user_id");
                $emailCheckStmt->execute([':email' => $data->Email, ':user_id' => $data->UserId]);
                $emailExists = $emailCheckStmt->fetch(PDO::FETCH_ASSOC);
                
                if ($emailExists) {
                    echo json_encode(["message" => "Este email já está em uso por outro usuário."]);
                    exit;
                }
            }
    
            if ($userDAO->update($user)) {
                echo json_encode(["message" => "Usuário atualizado com sucesso!"]);
            } else {
                echo json_encode(["message" => "Erro ao atualizar o usuário."]);
            }
    
        } else {
            $user = new User();
            if (isset($data->Nome)) $user->setName($data->Nome);
            if (isset($data->CPF)) $user->setCpf($data->CPF);
            if (isset($data->Celular)) $user->setPhone($data->Celular);
            if (isset($data->Email)) $user->setEmail($data->Email);
            if (isset($data->Senha)) $user->setPassword($data->Senha);
            if (isset($data->UserType)) $user->setUserType($data->UserType);
    
            if ($userDAO->create($user)) {
                echo json_encode(["message" => "Usuário criado com sucesso!"]);
            } else {
                echo json_encode(["message" => "Erro ao criar usuário."]);
            }
        }
    }
    
    // Como o nome sugere, o método DELETE, deleta um usuário (precisamos passar um ID, não há como deletar todos)
    elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        parse_str(file_get_contents("php://input"), $input); 
        $userId = $input['UserId'];

        $userDAO = new UserDAO($conn);

        if ($userDAO->delete($userId)) {
            echo json_encode(["message" => "Usuário deletado com sucesso!"]);
        } else {
            echo json_encode(["message" => "Erro ao deletar usuário."]);
        }
    }
?>
