<?php
    namespace Entities;

    class Reservation {
        private $reservationId;
        private $userId;
        private $productId;
        private $reservationDate;
        private $status;

        public function getReservationId() {
            return $this->reservationId;
        }

        public function setReservationId($reservationId) {
            $this->reservationId = $reservationId;
        }

        public function getUserId() {
            return $this->userId;
        }

        public function setUserId($userId) {
            $this->userId = $userId;
        }

        public function getProductId() {
            return $this->productId;
        }

        public function setProductId($productId) {
            $this->productId = $productId;
        }

        public function getReservationDate() {
            return $this->reservationDate;
        }

        public function setReservationDate($reservationDate) {
            $this->reservationDate = $reservationDate;
        }

        public function getStatus() {
            return $this->status;
        }

        public function setStatus($status) {
            $this->status = $status;
        }
    }
?>
