<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

// Debugging: Log received POST data
error_log(print_r($_POST, true));

// Retrieve form data
$fullName = $_POST['fullName'] ?? null;
$email = $_POST['email'] ?? null;
$phone = $_POST['phone'] ?? null;
$dob = $_POST['dob'] ?? null;
$gender = $_POST['gender'] ?? null;
$address = $_POST['address'] ?? null;

// Validate form data
if (!$fullName || !$email || !$phone || !$dob || !$gender || !$address) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit;
}

// Create an associative array of the form data
$data = [
    "fullName" => $fullName,
    "email" => $email,
    "phone" => $phone,
    "dob" => $dob,
    "gender" => $gender,
    "address" => $address,
];

// Save the data to a JSON file
$filePath = "data/registrations.json";
if (!file_exists("data")) {
    if (!mkdir("data", 0777, true)) {
        echo json_encode(["success" => false, "message" => "Failed to create directory."]);
        exit;
    }
}

$registrations = [];
if (file_exists($filePath)) {
    $fileContents = file_get_contents($filePath);
    if ($fileContents === false) {
        echo json_encode(["success" => false, "message" => "Failed to read existing data."]);
        exit;
    }
    $registrations = json_decode($fileContents, true);
    if ($registrations === null && json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["success" => false, "message" => "Failed to decode existing data."]);
        exit;
    }
}

$registrations[] = $data;
if (file_put_contents($filePath, json_encode($registrations, JSON_PRETTY_PRINT)) === false) {
    echo json_encode(["success" => false, "message" => "Failed to save data."]);
    exit;
}

// Respond with success
echo json_encode(["success" => true, "data" => $data]);
exit;
?>