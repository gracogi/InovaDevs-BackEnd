<?php
require_once '../Database.php';
require_once '../entities/Reservations.php';
require_once '../dao/ReservationDAO.php';

use Entities\Reservation;
use DAO\ReservationDAO;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, PUT, GET, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

$db = new Database();
$conn = $db->getConnection();
$reservationDAO = new ReservationDAO($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $reservation = new Reservation();

    if (isset($_GET['reservationId'])) {
        $reservationId = $_GET['reservationId'];
        $existingReservation = $reservationDAO->read($reservationId)->fetch(PDO::FETCH_ASSOC);

        if (!$existingReservation) {
            echo json_encode(["message" => "Reserva não encontrada."]);
            exit;
        }

        $reservation->setReservationId($reservationId);
        $reservation->setUserId(isset($data->userId) ? $data->userId : $existingReservation['user_id']);
        $reservation->setProductId(isset($data->productId) ? $data->productId : $existingReservation['product_id']);
        $reservation->setReservationDate(isset($data->reservationDate) ? $data->reservationDate : $existingReservation['reservation_date']);
        $reservation->setStatus(isset($data->status) ? $data->status : $existingReservation['status']);

        if ($reservationDAO->update($reservation)) {
            echo json_encode(["message" => "Reserva atualizada com sucesso!"]);
        } else {
            echo json_encode(["message" => "Erro ao atualizar a reserva."]);
        }
    } else {
        $reservation->setUserId($data->userId);
        $reservation->setProductId($data->productId);
        $reservation->setReservationDate($data->reservationDate);
        $reservation->setStatus($data->status);

        if ($reservationDAO->create($reservation)) {
            echo json_encode(["message" => "Reserva criada com sucesso!"]);
        } else {
            echo json_encode(["message" => "Erro ao criar reserva."]);
        }
    }
}

elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['reservationId'])) {
        $reservationId = $_GET['reservationId'];
        $stmt = $reservationDAO->read($reservationId);
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($reservation ? $reservation : ["message" => "Reserva não encontrada."]);
    } else {
        $stmt = $reservationDAO->read();
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($reservations ? $reservations : ["message" => "Nenhuma reserva encontrada."]);
    }
}

elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['reservationId'])) {
        $reservationId = $_GET['reservationId'];

        if ($reservationDAO->delete($reservationId)) {
            echo json_encode(["message" => "Reserva deletada com sucesso!"]);
        } else {
            echo json_encode(["message" => "Erro ao deletar a reserva."]);
        }
    } else {
        echo json_encode(["message" => "ID da reserva não fornecido."]);
    }
}
?>
