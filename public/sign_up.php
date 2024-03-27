<?php
include "../app/core/functions.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {

    // Sanitize username to prevent SQL injection
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);

    // Validate username format (optional)
    if (!preg_match('/^[a-zA-Z0-9_.-]+$/', $username)) {
        message('Tài khoản chứa ký tự không hợp lệ.');
        goto skip_signup; // Jump to message display without executing the query
    }

    $values = [
        'username' => $username,
    ];

    // Connect to database (assuming db_query_one exists)
    $row = db_query_one("insert into users (" . implode(',', array_keys($values)) . ") VALUES (:" . implode(', :', array_keys($values)) . ")", $values);

    if ($row !== false) {
        authenticate($row);
        message('Sign up successful!');
        redirect('admin');
    } else {
        message('Sign up failed. Please try again.');
    }

    skip_signup: // Label for optional jump
}

// Include header template
?>

<section class="content">
    <div class="signup-holder">
    <link rel="stylesheet" href="../public/assets/css/style.css">
        <?php if (message()): ?>
            <div class="alert"><?= message('', true) ?></div>
        <?php endif; ?>

        <form method="post">
            <center><img src="assets/images/logo.jpg" style="width: 150px;border-radius: 50%;border: solid thin #ccc;"></center>
            <h2>Sign Up</h2>
            <input value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" class="my-1 form-control" type="text" name="username" placeholder="Username">
            <input class="my-1 form-control" type="password" name="password" placeholder="Password">
            <button class="my-1 btn" style="background-color: purple; color: aliceblue">Sign Up</button>
        </form>
    </div>
</section>

<?php require page('includes/footer'); ?>
