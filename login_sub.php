<?php

session_start();

include 'database.php'; // Include the database class

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dbName = Database::connect(); // Connect to the database using the Database class

    if (isset($_POST["register"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $gender = $_POST["gender"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];

        if (empty($username) || empty($email) || empty($gender) || empty($password) || empty($confirmPassword)) {
            echo json_encode(["success" => false, "message" => "All fields are required"]);
            exit;
        }

        if ($password !== $confirmPassword) {
            echo json_encode(["success" => false, "message" => "Passwords do not match"]);
            exit;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $query = $dbName->prepare("INSERT INTO users (username, email, gender, password) VALUES (?, ?, ?, ?)");
        $query->bind_param("ssss", $username, $email, $gender, $hashedPassword);
        $result = $query->execute();

        if ($result) {
            echo json_encode(["success" => true, "message" => "Registration successful"]);
            exit;
        } else {
            echo json_encode(["success" => false, "message" => "Registration failed"]);
            exit;
        }
    } elseif (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Query the database for the user
        $query = $dbName->prepare("SELECT * FROM users WHERE username = ?");
        $query->bind_param("s", $username);
        $query->execute();
        $result = $query->get_result();

        // Check if the user exists
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user["password"])) {
                // Set session variable
                $_SESSION["user_id"] = $user["id"];

                echo json_encode(["success" => true, "message" => "Login successful"]);
                exit;
            }
        }

        // If username or password is incorrect
        echo json_encode(["success" => false, "message" => "Incorrect username or password"]);
        exit;
    }
}
?>