<?php
include "../app/core/functions.php";
include "../app/core/config.php";
require page('includes/header');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {

  $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $password = $_POST['password'];

  $query = "SELECT * FROM users WHERE username = :username";
  $result_username = db_query_one($query, ['username' => $username]);

  if (!empty($result_username)) {
      message('Tên đăng nhập đã tồn tại.');
  }

  $query = "SELECT * FROM users WHERE email = :email";
  $result_email = db_query_one($query, ['email' => $email]);

  if (!empty($result_email)) {
      message('Email đã được sử dụng.');
  }

  if (empty($result_username) && empty($result_email)) {
      $values = [
          'username' => $username,
          'email' => $email,
          'password' => $password,
      ];

      $query = "INSERT INTO users (" . implode(',', array_keys($values)) . ", role) VALUES (:" . implode(', :', array_keys($values)) . ", 'user')";
      $row_count = db_query_insert($query, $values);

    if ($row_count !== false && $row_count > 0) {
        message('<span style="background-color: green;color: white">Sign up successful, you are preparing to redirect to the login page!</span>');
        echo '<script>
            setTimeout(function() {
                window.location.href = "login.php";
            }, 3000);
        </script>';
    } else {
        message('Sign up failed. Please try again.');
    }
  }
}

?>
<style>
    .signup-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            opacity: 1;

        }

        .signup-container form {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid silver;
        }

        .signup-container h2 {
            text-align: center;
            border-bottom: 1px solid silver;
            padding-bottom: 10px;
        }

        .signup-container input[type="text"],
        .signup-container input[type="password"] {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .signup-container button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #174b8b;
            color: #fff;
            cursor: pointer;
        }

        .signup-container button:hover {
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

        .txt_field input:focus~label,
        .txt_field input:valid~label {
            top: -5px;
            color: #2691d9;
        }

        .txt_field input:focus~span::before,
        .txt_field input:valid~span::before {
            width: 100%;
        }

</style>
<section class="content">
  <div class="signup-container">
    <?php if (message()): ?>
      <div class="alert"><?= message('', true) ?></div>
    <?php endif; ?>

    <form method="post">
      <link rel="stylesheet" href="../public/assets/css/style.css">
      <center><img src="assets/images/logo.jpg" style="width: 100%;border-radius: 50%;border: solid thin #f7f7f7;"></center>
      <h2>Sign Up</h2>
      <input value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" class="my-1 form-control" type="text" name="username" placeholder="Username">
      <input class="my-1 form-control" type="password" name="password" placeholder="Password">
      <input value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" class="my-1 form-control" type="email" name="email" placeholder="Email">
      <button class="my-1 btn" style="background-color: #5755FE; color: aliceblue; border-radius: 5rem">Sign Up</button>    </form>
  </div>
</section>

<?php require page('includes/footer'); ?>
