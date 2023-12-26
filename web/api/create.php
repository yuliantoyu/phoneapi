<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../class/phone.php';


$database = new Database();

$db = $database->getConnection();

$item = new Phone($db);

$data = json_decode(file_get_contents("php://input"));



$item->numberphone = $data->numberphone.'/'.$data->provider;


if ($item->create()) {
    http_response_code(201); // 201 Created
    echo json_encode(array("message" => "Phone created successfully."));
} else {
    http_response_code(500); // 500 Internal Server Error
    echo json_encode(array("message" => "Phone could not be created."));
}
?>
