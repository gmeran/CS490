<?php

// Accept user and pass from post request
if ((isset($_POST['user_id']) && isset($_POST['password'])) == false)
{
	die("Did not recieve login info");
}
else
{
	$user_id = $_POST["user_id"];
	$password = $_POST["password"];
}

// Connect to DB
$conn = new mysqli("sql1.njit.edu", "vc259", "candide57");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check login info against DB
$query = sprintf("SELECT UCID, pw_hash FROM vc259.student_logins where UCID = '%s'", $user_id);
$result = $conn->query($query);

if (!($result->num_rows == 1))
{
	die(json_encode("UCID not found in db"));
}


// Verify password, echo JSON response back to middle

if (password_verify($password, $result->fetch_assoc()["pw_hash"]))
{
	$response = "Backend Accepts";
}else
{
	$response = "Backend Rejects";
}

echo json_encode($response);
?>