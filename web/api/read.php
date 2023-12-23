<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

 include_once '../config/database.php';
    include_once '../class/phone.php';

$database = new Database();
$db = $database->getConnection();

$phone = new Phone($db);

$stmt = $phone->getPhonenumber();
$num = $stmt->rowCount();

if ($num > 0) {
    $phone_arr = array();
    $phone_arr["body"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $phone_item = array(
            "id" => $id,
            "numberphone" => $numberphone
           
        );

        array_push($phone_arr["body"], $phone_item);
    }

    http_response_code(200);
    echo json_encode($phone_arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No phone number found.")
    );
}
?>
