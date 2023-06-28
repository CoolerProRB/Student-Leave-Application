<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $desc = $_POST["desc"];

    $error = array("name" => "","email" => "",'subject' => "", "desc" => "","status" => "success");

    $nameValid = $emailValid = $subjectValid = $descValid = false;

    if($name == ""){
        $error["name"] = "Name is required!";
        $error["status"] = "error";
    }
    else{
        $nameValid = true;
    }

    if($email == ""){
        $error['email'] = "Email is required!";
        $error["status"] = "error";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error['email'] = "Invalid email format!";
        $error["status"] = "error";
    }
    else{
        $emailValid = true;
    }

    if($subject == ""){
        $error["subject"] = "Subject is required!";
        $error["status"] = "error";
    }
    else{
        $subjectValid = true;
    }

    if($desc == ""){
        $error["desc"] = "Description is required!";
        $error["status"] = "error";
    }
    else{
        $descValid = true;
    }

    if($nameValid && $emailValid && $subjectValid && $descValid){
        $_SESSION["name"] = $name;
        $_SESSION["email"] = $email;
        $_SESSION["subject"] = $subject;
        $_SESSION["desc"] = $desc;
    }

    echo json_encode($error);
}
?>