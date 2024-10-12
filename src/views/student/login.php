<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../../classes/auth.class.php");
require_once("../../helpers/clean.function.php");
require_once("../../helpers/session.function.php");

$required = '*';
$email = $password = '';
$email_err = $password_err = '';
$auth = new Auth();


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = cleanInput($_POST['email']);
    $password = cleanInput($_POST['password']);

    if(!(filter_var($email, FILTER_VALIDATE_EMAIL) && substr($email, -12) === '@wmsu.edu.ph')){
        $email_err = "invalid email";
    }

    if(!($auth->emailExists($email))){
        $email_err = "email does not exist";
    }

    if(strlen($_POST['password']) < 8){
        $password_err = "Password must be at least 8 characters long.";
    }

    if($email_err == '' && $password_err == ''){
        if($auth->studentLogin($email)){
            header("Location: ./login.php");
            exit;
        } else {
            $password_err = "incorrect password"; // Temporary, verify later with hashed.
        }
    }
}

if (isset($_SESSION["is_loggedIn"])) {
  header("location: ./home.php");
  exit;
}

extract($_SESSION);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login Form</title>
    <link rel="stylesheet" href="/cssc/public/assets/css/global.css">
    <link rel="stylesheet" href="/cssc/public/assets/css/auth.css">
</head>
<body>
    <form action="" method="POST">
        <h3>Student Account</h3>
        <label for="email">Email <span class="error"><?= $required ?></span></label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
        <?php if (!empty($email_err)): ?><span class="error auth-err"><?= $email_err ?></span><br><?php endif; ?>
        
        <div class="password">
            <label for="password">Password <span class="error"><?= $required ?></span></label>
            <a href="./forgot-password.php" class="forgot-password">forgot password?</a>
        </div>
        
        <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password); ?>" required>
        <?php if (!empty($password_err)): ?>
            <span class="error auth-err"><?= $password_err ?></span><br>
        <?php endif; ?>

        <button type="submit" class="primary-button">login</button>
        <a href="./register.php"><button type="button" class="secondary-button">or register</button></a>
    </form>
</body>
</html>
