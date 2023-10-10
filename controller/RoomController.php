<?php
require_once("./Database.php");
require_once("./response/RoomResponse.php");
class RoomController extends Database
{
    public function index()
    {
        $query = file_get_contents('./sql/getAllRooms.sql');
        $stmt = $this->db->query($query);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach ($data as $d) {
            if ($d->time_to_available <= date('Y-m-d H:i:s') && $d->vailable == 0 && $d->time_to_available != null) {
                $query = "UPDATE rooms SET time_to_available = null,available = true WHERE id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(":id", $d->id);
                try {
                    $stmt->execute();
                } catch (PDOException $e) {
                    return $e->getMessage();
                }
            }
        }
        return $data;
    }
    public function changeToDefaultValue()
    {
    }
    public function store($request)
    {
        $imageName = basename($request["image"]["name"]);
        $imageDir = "public/images/";
        $numberOfRoom = $request['numberOfRoom'] ?? 1;
        $url = $imageDir . $imageName;
        if (move_uploaded_file($request['image']['tmp_name'], $url)) {
            for ($i = 0; $i < $numberOfRoom; $i++) {
                $stmt = $this->db->prepare("INSERT INTO rooms (`room_type`,`price`,`room_size`,`accessories`,`image`) VALUES (:room_type,:price,:room_size,:accessories,:imageName)");
                $stmt->bindParam(':room_type', $request["room_type"], PDO::PARAM_STR);
                $stmt->bindParam(':price', $request["price"], PDO::PARAM_STR);
                $stmt->bindParam(':room_size', $request["room_size"], PDO::PARAM_STR);
                $stmt->bindParam(':accessories', $request["accessories"], PDO::PARAM_STR);
                $stmt->bindParam(':imageName', $imageName, PDO::PARAM_STR);
                try {
                    if ($stmt->execute()) {
                    } else {
                        return "500 Internal Server Error";
                    }
                } catch (PDOException $e) {
                    return $e->getMessage();
                }
            }
            return $request;
        } else {
            return "fail to upload the image";
        }
    }
}