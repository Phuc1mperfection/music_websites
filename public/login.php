<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../public/assets/css/style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px ;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            opacity: 1;
            padding-bottom: 10px;
        }

        .login-container form {
            text-align: center;
            border-bottom: 1px solid silver;
        }

        .login-container h2 {
            text-align: center;
            border-bottom: 1px solid silver;
            padding-bottom: 10px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #174b8b;
            color: #fff;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: darkblue;
            transition: all 0.3s;
        }

        .alert {
            margin-bottom: 20px;
            padding: 10px;
            background-color: white;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            color: #721c24;
        }

        .txt_field input {
            width: 100%;
            padding: 0 5px;
            height: 40px;
            font-size: 16px;
            border: none;
            background: none;
            outline: none;
        }
        .txt_field input:focus~span::before,
        .txt_field input:valid~span::before {
            width: 100%;
        }

    </style>
</head>

<body>
    <?php
    include "../app/core/functions.php";
    include "../app/core/config.php";
    include "../app/pages/includes/header.php";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $values = [];
        $values['username'] = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (empty($password)) {
            message("Password is required");
        } else {
            $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
            $row = db_query_one($query, $values);

            if (!empty($row) && $password == $row['password']) {
                authenticate($row);
                $_SESSION['uid'] = $row['id'];
                message("Login successful");

                // Kiểm tra vai trò của người dùng và chuyển hướng tương ứng
                if ($row['role'] == 'admin') {
                    redirect('admin');
                } else {
                    redirect('home.php');
                }
            } else {
                message("Wrong username or password");
            }
        }
    }

    ?>
    <section class="content">
        <div class="login-container">
            <?php if (message()) : ?>
                <div class="alert"><?= message('', true) ?></div>
            <?php endif; ?>
            <form method="post">
                <center><img src="assets/images/logo.jpg" style="width: 100%;border-radius: 50%;border: solid thin #f7f7f7;"></center>
                <h2>Login</h2>
                <div class="txt_field">
                    <input value="<?= set_value('username') ?>" class="my-1 form-control" type="text" name="username" placeholder="Username">
                    <input value="<?= set_value('password') ?>" class="my-1 form-control" type="password" name="password" placeholder="Password">
                </div>
                <button style=" color: aliceblue; border-radius: 5rem" >Login</button>
            </form>
        </div>
    </section>
    <?php include "../app/pages/includes/footer.php"; ?>
</body>
</html>