<?php

//Connecting to the database
$servername = "127.0.0.1";
$username = "s2657187";
$password = "s2657187";
$db_name = "d2657187";

$conn = new mysqli($servername, $username, $password, $db_name);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user_details (username, password, email) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            /*bind->param binds the parameters provided to the SQL statement above*/
            $stmt->bind_param("sss", $username, $hashedPassword, $email);

            if($stmt->execute()){
                $response['error'] = false;
                $response["message"] = "User registered successfully";
                echo json_encode($response);
            } else {
                $response['error'] = true;
                $response["message"] = "Some error occurred while registering user";
                echo json_encode($response);
            }

        } else {
            $response["error"] = true;
            $response["message"] = "Required fields are missing";
            echo json_encode($response);
        }

}else {
        //This is an associative array in PHP, and we create a key named 'error' setting the value to true, to show that there is an error
        $response["error"] = true;
        $response["message"] = "Invalid request method.";

        //Now to display the error message in json format we write the code below
        echo json_encode($response);
    }



