<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

// =================== DUMPS BUT MIGHT BE USEFUL =================== 
// require_once("../../../src/classes/auth.class.php");
// require_once("../../../src/utils/clean.function.php");
// require_once("../../../src/utils/session.function.php");

// use Src\Classes\Auth;

// $required = '*';
// $email = $password = '';
// $email_err = $password_err = ' ';
// $auth = new Auth();


// if($_SERVER['REQUEST_METHOD'] === 'POST'){
//     $email = cleanInput($_POST['email']);
//     $password = cleanInput($_POST['password']);

//     if(!(filter_var($email, FILTER_VALIDATE_EMAIL) && substr($email, -12) === '@wmsu.edu.ph')){
//         $email_err = "invalid email - use @wmsu.edu.ph";
//     } else if(!($auth->emailExists($email))){
//         $email_err = "email does not exist";
//     }

//     if(strlen($_POST['password']) < 8){
//         $password_err = "minimum 8 characters";
//     }

//     if($email_err == ' ' && $password_err == ' '){
//         if($auth->login($email, $password)){
//             header("Location: ./login.php");
//             exit;
//         } else {
//             $password_err = "incorrect password"; // Temporary, verify later with hashed.
//         }
//     }
// }

// if (isset($_SESSION["is_loggedIn"])) {
//   header("location: ./home.php");
//   exit;
// }

// extract($_SESSION);

// 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="/cssc/resources/css/global.css">
    <link rel="stylesheet" href="/cssc/resources/css/auth.css">
</head>
<body>
    <form id="myForm" action="" method="POST">
        <h3>Login Form</h3>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'];?>">
        <?php if (!empty($_SESSION['feedback'])): ?><span class="success feedback"><?= $_SESSION['feedback'] ?></span><br><?php unset($_SESSION['feedback']); endif; ?>
        <label for="email">Email <span class="error"><?= $required ?></span></label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" tabindex="1">
        <?php if (!empty($email_err)): ?><span class="error auth-err"><?= $email_err ?></span><br><?php endif; ?>
        
        <div class="password-util">
            <label for="password">Password <span class="error"><?= $required ?></span></label>
            <!-- <a href="./forgot-password.php" class="forgot-password">forgot password?</a> -->
            <button type="submit" class="forgot-password" name="form-action" value="forgot-password" tabindex="5">forgot password?</button>
        </div>
        
        <input type="password" name="password" id="password" class="password" value="<?php echo htmlspecialchars($password); ?>"  tabindex="2" >

        <div class="below-input">
            <?php if (!empty($password_err)): ?>
                <span class="error auth-err"><?= $password_err ?></span><br>
            <?php endif; ?>
            <div class="show-password">
                <input class="showpassword-checkbox togglePassword" type="checkbox" onclick="myFunction()" tabindex="-1">
                <p>show password</p>
            </div>
        </div>

        <button type="submit" class="primary-button" name="form-action" value="attempt-login" tabindex="3">login</button>
        <button type="submit" class="secondary-button" name="form-action" value="switch-to-register" tabindex="4">or register</button>
    </form>
    <script src="/cssc/resources/js/show-password.js"></script>
    <script>
    document.getElementById('myForm').onsubmit = function() {
        history.pushState(null, '', location.href); // Prevent back navigation
    };
    </script>
</body>
</html>
