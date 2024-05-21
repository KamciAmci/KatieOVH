<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Sprawdź, czy formularz został wysłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Połącz z bazą danych
    $servername = "";
    $username = ""; // Zmień na nazwę użytkownika bazy danych
    $password = ""; // Zmień na hasło użytkownika bazy danych
    $dbname = ""; // Zmień na nazwę bazy danych

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Sprawdź połączenie
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Pobierz dane z formularza
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Zabezpiecz dane przed atakami SQL Injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Zapytanie do bazy danych - sprawdź czy istnieje użytkownik o podanym adresie email i haśle
    $sql = "SELECT * FROM login WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Zalogowano pomyślni
        echo '<script>alert("Logged Succesfully!")</script>'; 
        header('Location: /index.html');
    } else {
        // Błąd logowania
        echo '<script>alert("Email or Password incorrect!")</script>'; 
    }

    // Zamknij połączenie z bazą danych
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katie | Login Page</title>
    <link rel="icon" type="image/x-icon" href="/src/favicon.svg">
    <style>
        body, html {
            height: 100%;
            font-family: 'Courier New', Courier, monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #2c2c2c;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .loginpanel {
            height: 500px;
            width: 400px;
            opacity: 0.9;
            background-color: #333;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            position: relative;
        }
        .logo {
            height: 90px;
            width: 90px;
            background-image: url(/src/faviconb.svg);
            background-size: 70px;
            background-position: center;
            position: absolute;
            top: -60px;
            left: calc(50% - 45px);
            background-repeat: no-repeat;
            background-color: #fff;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            transition: 0.1s ease-in-out;
        }
        .lt {
            height: 60px;
            width: 100%;
            color: aliceblue;
            font-size: 40px;
            text-align: center;
            margin-bottom: 40px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            color: aliceblue;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #555;
            color: #fff;
        }
        .form-group input::placeholder {
            color: #ccc;
        }
        .login-btn {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .login-btn:hover {
            background-color: #0056b3;
        }
        .error {
            color: rgb(168, 32, 32);
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.3s ease;
            position: absolute;
            top: calc(100% + 5px);
            font-weight: 600;
            left: 50px;
        }
        .bpass {
            position:absolute;
            color: red;
            font-size: 14px;
            opacity: 0; /* Ukrycie komunikatu */
            transition: opacity 0.3s ease; /* Animacja zmiany opacity */
            position: absolute; /* Ustawienie komunikatu poniżej pola input */
            left: 0;
        }
        .error.active {
            opacity: 1;
        }
        #bpass {
            transform: translate(calc(50vw - 100px),calc(50vh - 250px));
            opacity: 0;
        }
        .logo:hover {
            cursor: pointer;
            border: none;

        }
        footer {
            width: 100%;
            background-color: #2c2c2c;
            color: white;
            text-align: center;
            padding: 20px;
            position: fixed;
            bottom: 0;
            left: 0;
        }
        footer p {
            margin: 5px 0;
        }

    </style>
    <script>
        
        function zmienPrzezroczystosc(opacityValue) {
            var element = document.querySelector(".bpass");
            if (element) {
                element.style.opacity = opacityValue;
            } else {
                console.error("Element o klasie 'bpass' nie został znaleziony.");
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Zapobiega domy
                //ślnemu zachowaniu formularza
                if (validateEmail(emailInput.value)) {
                    emailError.classList.remove('active');
                    form.submit();
                } else {
                    emailError.classList.add('active');
                    zmienPrzezroczystosc(1); // Wywołanie funkcji ustawiającej przezroczystość na 1
                }
            });

            function validateEmail(email) {
                const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                return re.test(String(email).toLowerCase());
            }
        });
    </script>
</head>
<body>
    <div class="loginpanel">
    <button onclick="window.location.href='index.html'" class="logo"></button>
        <div class="lt">Login Page</div>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="text" id="email" name="email" placeholder="Enter your email address">
                <!-- <div id="bpass" class="bpass">Email or Password not valid</div> -->
                <div class="error" id="emailError">Please enter a valid email address.</div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2024 Katie. All rights reserved.</p>
        <p>Contact us at Noreply@Katie.ovh</p>
    </footer>
</body>
</html>
