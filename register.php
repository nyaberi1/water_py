<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }


        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        button {
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        #errorMessage {
            color: red;
        }
    </style>

</head>

<body>
    <div class="container">
        <!-- //<div class="card"> -->
            <div class="register-container">
                <h2>Register</h2>
                <form id="registerForm" action="login_sub.php" method="post">
                    <div class="input">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input">
                        <label for="email;">Email:</label>
                        <input type="text" id="email;" name="email;" required>
                    </div>
                    <div class="input">
                        <label>Gender:</label>
                        <input type="radio" id="male" name="gender" value="male" required>
                        <label for="male">Male</label>

                        <input type="radio" id="female" name="gender" value="female" required>
                        <label for="female">Female</label>
                    </div>

                    <div class="input">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="input">
                        <label for="confirmPassword">Confirm Password:</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" required>
                    </div>

                    <button type="submit">Register</button>
                    <p> Have an account? <a href="login.php">Login here</a></p>
                </form>
                <p id="errorMessage"></p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("registerForm").addEventListener("submit", function(event) {
            event.preventDefault();

            var username = document.getElementById("username").value;
            var username = document.getElementById("email").value;
            var username = document.getElementById("gender").value;
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;

            if (password !== confirmPassword) {
                document.getElementById("errorMessage").innerText = "Passwords do not match";
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            window.location.href = "login.php";
                        } else {
                            document.getElementById("errorMessage").innerText = response.message;
                        }
                    } else {
                        console.error("Error during registration request");
                    }
                }
            };

            xhr.open("POST", "login_sub.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password));
        });
    </script>
</body>

</html>