<!DOCTYPE html>
<html>


<head>

    <style>
        body {
            background: url(assets/background.png);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            background-color: #F5E9D6;
            font-family: "Pacifico", cursive;
            font-weight: 400;
            font-style: normal;
            height: 100vh;
            /* Ensure the body takes full height */
            margin: 0;
            display: flex;
            /* Flex on body to center container */
            justify-content: center;
            align-items: center;
        }

        .account {
            display: flex;
            align-items: center;

        }

        .navigations {
            display: flex;
            justify-content: space-around;
        }

        body {
            background: url(assets/background.png);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            background-color: #F5E9D6;
            font-family: "Pacifico", cursive;
            font-weight: 400;
            font-style: normal;
        }

        h1 {
            color: blue;
        }

        p {
            color: red;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
            border-radius: 15px;
            width: 400px;
            margin-top: 150px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .register-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .register-form h2 {
            color: #dbae5d;
            margin-bottom: 20px;
            text-transform: lowercase;
            font-size: 2rem;
        }

        .register-form input[type="text"],
        .register-form input[type="email"],
        .register-form input[type="tel"],
        .register-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 2px solid #f0a9a9;
            border-radius: 25px;
            background-color: #ffecec;
            color: #555;
            font-size: 1rem;
            text-align: center;
            outline: none;
        }

        .register-form input::placeholder {
            color: #dbae5d;
            font-style: italic;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }

        .checkbox-container input[type="checkbox"] {
            margin-right: 10px;
        }

        .checkbox-container label {
            color: #555;
            font-style: italic;
        }

        button {
            background-color: #f0a9a9;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #f08080;
        }

        @media (max-width: 600px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            .register-form input {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>


    <div class="container">
        <form action="admin-login.php" method="POST" class="register-form">
            <h2>Stardust Admin Login</h2>

            <input type="email" name="email" placeholder="email" id="email" required>
            <input type="password" name="password" placeholder="password" id="password" required>
            <div class="checkbox-container">
                <input type="checkbox" id="remember">
                <label for="remember">remember me</label>
            </div>
            <button type="submit">login</button>
        </form>
    </div>



</body>

</html>