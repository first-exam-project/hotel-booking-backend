<?php
require_once("./Database.php");
require_once("./controller/BookingController.php");
date_default_timezone_set('Asia/Yangon');
class CustomerPerRoomController extends Database
{
    public function store($request)
    {
        $roomQuery = $this->db->prepare("SELECT * FROM rooms WHERE `available` = true AND `room_type` = :room_type");
        $roomQuery->bindParam(":room_type", $request['room_type']);
        try {
            if ($roomQuery->execute()) {
                $data = $roomQuery->fetchAll(PDO::FETCH_OBJ);
                $randomId = array_rand($data);
                $randomValue = $data[$randomId];
                $this->CustomerPerRoom($request, $randomValue);
                return $request;
            } else {
                return "500 internal Server error";
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function CustomerPerRoom($request, $room)
    {
        $stmt = $this->db->prepare("INSERT INTO customer_per_rooms (`name`, `email`, `phone`, `room_id`, `duration`, `applied_date`) VALUES (:name, :email, :phone, :room_id, :duration, :applied_date)");
        $stmt->bindParam(':name', $request['name']);
        $stmt->bindParam(":email", $request['email']);
        $stmt->bindParam(":phone", $request['phone']);
        $stmt->bindParam(":room_id", $room->id);
        $stmt->bindParam(":duration", $request['duration']);
        $stmt->bindParam(":applied_date", $request['applied_date']);
        try {
            if ($stmt->execute()) {
                $booking = new BookingController();
                $booking->destroy($request['id']);
                return $this->roomUpdate($request['duration'], $room->id);
            } else {
                return "500 Internal Server Error";
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function roomUpdate($duration, $id)
    {
        $days = "+" . $duration . "days";
        $now = time();
        $time_to_available = date("Y-m-d H:i:s", strtotime($days, $now));
        $query = "UPDATE rooms SET time_to_available = :time_to_available ,available = false WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam("id", $id);
        $stmt->bindParam("time_to_available", $time_to_available);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}