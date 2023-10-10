<?php
require_once("./Database.php");
date_default_timezone_set('Asia/Yangon');
class BookingController extends Database
{
    public function index()
    {
        $query = file_get_contents('./sql/getAllbookings.sql');
        $stmt = $this->db->query($query);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
    public function store($request)
    {
        $appliedDate = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO bookings (`name`, `email`, `phone`, `room_type`, `duration`, `applied_date`) VALUES (:name, :email, :phone, :room_type, :duration, :applied_date)");
        $stmt->bindParam(':name', $request['name']);
        $stmt->bindParam(":email", $request['email']);
        $stmt->bindParam(":phone", $request['phone']);
        $stmt->bindParam(":room_type", $request['room_type']);
        $stmt->bindParam(":duration", $request['duration']);
        $stmt->bindParam(":applied_date", $appliedDate);
        try {
            if ($stmt->execute()) {
                return $request;
            } else {
                return "500 Internal Server Error";
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function destroy($id)
    {
        $query = "DELETE FROM bookings WHERE id=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return "deleted";
        } else {
            echo "500 internal server error!";
        }
    }
}