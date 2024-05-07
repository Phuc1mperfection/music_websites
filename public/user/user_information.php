<?php
if (isset($_SESSION['uid'])) {
    include_once '../public/user/user_header.php';
    $uid = $_SESSION['uid'];
    $query = "SELECT * FROM users WHERE id = :id LIMIT 1";
    $user = db_query_one($query, ['id' => $uid]);
} else {
    include_once '../public/user/header.php';
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['uid'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $retype_password = trim($_POST['retype_password']);

    // Kiểm tra xem mật khẩu và mật khẩu nhập lại có khớp nhau không
    if ($password == $retype_password) {
        // Nếu khớp, thực hiện cập nhật thông tin người dùng
        $query = "UPDATE users SET username = :username, email = :email";

        // Nếu người dùng cung cấp mật khẩu mới, thêm vào truy vấn
        if (!empty($password)) {
            $query .= ", password = :password";
        }

        $query .= " WHERE id = :id";

        // Tạo mảng dữ liệu cho truy vấn
        $values = [
            'username' => $username,
            'email' => $email,
            'id' => $_SESSION['uid'] // Lấy id của người dùng từ session
        ];

        // Nếu người dùng cung cấp mật khẩu mới, thêm vào mảng dữ liệu
        if (!empty($password)) {
            $values['password'] = $password;
        }

        // Thực hiện truy vấn cập nhật
        db_query($query, $values);
     
    } else {
        echo '<p style="color:#fff">Passwords do not match.</p>';
    }
}

?>
<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../public/assets/css/style1.css">
    <link rel="stylesheet" href="../public/assets/css/preview.css">
    <title>Document</title>
</head>
<style>
    body {
        padding-top: 60px;
    }

    .form-container {
                background-color: rgba(255, 255, 255, 0.2);
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                color: #fff;
                width: 100% ;
                height: 100%;
                text-align: center;
            }
            input[type="text"],
            input[type="file"],
            input[type="email"],
            input[type="password"]
             {
                width: calc(100% - 20px);
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 1rem;
                background: rgba(255, 255, 255, 0.2);
                border: 0;
                backdrop-filter: blur(10px) saturate;
                color: #fff;
            }

            button.submit {
                padding: 10px 20px;
                background-color: #1E90FF;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                transition: background-color 0.3s;
                margin-right: 10px;
            }

            button.submit:hover {
                background-color: #141E46;
            }

</style>
<body>
<div class="main-container" id="main-container">
        <div style="max-width: 500px;margin: auto;">
            <form method="post" action="" class="form-container">
                <h1 style="color:aliceblue">Edit User</h1>
                <?php if (isset($user)): ?>
                    <input type="text" name="username" value="<?= $user['username'] ?>" placeholder="Username">
                    <input type="email" name="email" value="<?= $user['email'] ?>" placeholder="Email">
                    <input type="password" name="password" placeholder="Password (leave empty to keep old one)">
                    <input type="password" name="retype_password" placeholder="Retype Password"><br>
                    <button type="submit" class="submit">Save</button>
                <?php else: ?>
                    <p style='color:#fff'>User not found.</p>
                <?php endif; ?>
            </form>
        </div>
    </div>


</body>

</html>