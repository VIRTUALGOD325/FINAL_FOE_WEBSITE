<?php

//EMAIL VALIDATION
if( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("ENTER A VALID EMAIL ADDRESS");
}

//PASSWORD VALIDATION (strlen to check password length)
if(strlen($_POST["password"]) < 8){
    die("PASSWORD LENGTH SHOULD BE MINIMUM 8 CHARACTERS");
}

//PASSWORD VALIDATION TO CHECK IT CONTAINS ATLEAST ONE LETTER (pregmatch function is used to check that string contains atleast one letter)
if( ! preg_match("/[a-z]/i", $_POST["password"])){
    die("PASSWORD MUST CONTAIN ATLEAST ONE LETTER");
}

//PASSWORD VALIDATION TO CHECK IT CONTAINS ATLEAST ONE NUMBER (pregmatch function is used to check that string contains atleast one letter)
if( ! preg_match("/[0-9]/", $_POST["password"])){
    die("PASSWORD MUST CONTAIN ATLEAST ONE NUMBER");
}


$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);


$mysqli = require __DIR__ . "/database.php";


//INSERTING DATA
$sql = "INSERT INTO user (email, password_hash) VALUES (? , ?)";

$stmt = $mysqli->stmt_init();

if( ! $stmt->prepare($sql)){
    die("SQL ERROR TRY AGAIN LATER");
}

//BINDING INFO
$stmt->bind_param("ss", $_POST["email"], $password_hash);

if($stmt->execute()){

    header("Location: index.php");
    exit;
}
else{
    if($mysqli->errno === 1062){
        die("EMAIL IS ALREADY USED");
    }
    else{
        die($mysqli->error . "  " . $mysqli->errno);
    }
}













