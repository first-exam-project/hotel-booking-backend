<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
header("Content-Type: application/json");
require_once("./controller/RoomController.php");
require_once("./controller/BookingController.php");
require_once("./controller/CustomerPerRoomController.php");
$room = new RoomController();
$booking = new BookingController();
$customerPerRoom = new CustomerPerRoomController();
switch ($method | $uri) {
    case ($method == 'POST' && $uri == '/api/admin/rooms');
        $requestBody = $_POST;
        $requestBody['image'] = $_FILES['image'];
        echo json_encode($room->store($requestBody), JSON_PRETTY_PRINT);
        break;
    case ($method == 'GET' && $uri == '/api/admin/rooms');
        echo json_encode($room->index(), JSON_PRETTY_PRINT);
        break;
    case ($method == 'GET' && $uri == '/api/admin/bookings');
        echo json_encode($booking->index(), JSON_PRETTY_PRINT);
        break;
    case ($method == 'POST' && $uri == '/api/admin/bookings');
        echo json_encode($customerPerRoom->store($_POST), JSON_PRETTY_PRINT);
        break;
    case ($method == 'DELETE' && preg_match('/\/api\/admin\/bookings\/[1-9]/', $uri));
        echo json_encode($booking->destroy(basename($uri)), JSON_PRETTY_PRINT);
        break;
    case ($method == 'GET' && $uri == '/api/client/rooms');
        echo json_encode($room->index(), JSON_PRETTY_PRINT);
        break;
    case ($method == 'POST' && $uri == '/api/client/bookings');
        echo json_encode($booking->store($_POST), JSON_PRETTY_PRINT);
        break;
    default:
        echo json_encode(
            array(
                "ERROR" => "THERE IS NO ROUTE WITH THIS PATH"
            ),
            JSON_PRETTY_PRINT
        );
        break;
}