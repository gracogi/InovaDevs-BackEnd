# InvaDevs-BackEnd

<!--?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    require_once 'Database.php';

    class User {
        private $conn;
        private $table_name = "users";

        public $name;
        public $cpf;
        public $phone;
        public $email;
        public $password;
        public $user_type = "user"; // Tipo padrão como "user"

        public function __construct($db) {
            $this->conn = $db;
        }

        public function create() {
            $query = "INSERT INTO " . $this->table_name . " (name, cpf, phone, email, password, user_type) VALUES (:name, :cpf, :phone, :email, :password, :user_type)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":cpf", $this->cpf, PDO::PARAM_STR); // CPF como string para evitar problemas de formato
            $stmt->bindParam(":phone", $this->phone, PDO::PARAM_STR);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", password_hash($this->password, PASSWORD_BCRYPT));
            $stmt->bindParam(":user_type", $this->user_type);

            if ($stmt->execute()) {
                echo "Usuário criado com sucesso!";
                return true;
            } else {
                echo "Erro ao criar usuário.";
                return false;
            }
        }
    }

    // Processamento da requisição
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Conexão com o banco de dados
        $database = new Database();
        $db = $database->getConnection();

        // Criação da instância de usuário
        $user = new User($db);

        // Definindo propriedades com base nos dados do formulário
        $user->name = $_POST['Nome'] ?? null;
        $user->cpf = $_POST['CPF'] ?? null;
        $user->phone = $_POST['Celular'] ?? null;
        $user->email = $_POST['E-mail'] ?? null;
        $user->password = $_POST['Senha'] ?? null;

        // Tentativa de criação do usuário
        if ($user->create()) {
            echo "Usuário criado com sucesso!";
        } else {
            echo "Erro ao criar usuário.";
        }
    }
?-->
