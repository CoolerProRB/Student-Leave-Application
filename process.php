<?php
session_start();

$api_key = 'apdFzoRqJ75J6upVUdTx';
$password = "x";
$yourdomain = "groupass";

$name = $_POST["name"];
$email = $_POST["email"];
$subject = $_POST["subject"];
$desc = $_POST["desc"];

$_SESSION["name"] = $name;
$_SESSION['email'] = $email;
$_SESSION["subject"] = $subject;
$_SESSION["desc"] = $desc;

$ticket_data = json_encode(array(
    "name" => $name,
    "description" => $desc,
    "subject" => $subject,
    "email" => $email,
    "priority" => 1,
    "status" => 2,
    "source" => 1
));

$url = "https://$yourdomain.freshdesk.com/api/v2/tickets";

$ch = curl_init($url);

$header[] = "Content-type: application/json";
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
$info = curl_getinfo($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($server_output, 0, $header_size);
$response = substr($server_output, $header_size);

$status = array("status" => "error");
if($info['http_code'] == 201){
    $status["status"] = "success";
    session_destroy();
}

curl_close($ch);
echo json_encode($status);
?>