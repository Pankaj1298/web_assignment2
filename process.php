<?php
header("Content-Type: application/json"); // Set the response to JSON

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
    mkdir("data", 0777, true); // Create the directory if it doesn't exist
}
$registrations = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];
$registrations[] = $data;
file_put_contents($filePath, json_encode($registrations, JSON_PRETTY_PRINT));

// Respond with success
echo json_encode(["success" => true, "data" => $data]);
exit;
?>