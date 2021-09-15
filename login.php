<?php

session_start();
require_once('database/connection.php');

if(isset($_POST['submit']))
{
    if(isset($_POST['email'], $_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']))
    {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $sql = "select * from user where identifiant = :email ";
            $handle = $db->prepare($sql);
            $params = ['email'=>$email];
            $handle->execute($params);
            if($handle->rowCount() > 0)
            {
                $getRow = $handle->fetch(PDO::FETCH_ASSOC);
                if(password_verify($password, $getRow['password']))
                {
                    unset($getRow['password']);
                    $_SESSION = $getRow;
                    header('location:dashboard.php');
                    exit();
                }
                else
                {
                    $errors[] = "Veuillez revérifier vos paramètres de connexion";
                }
            }
            else
            {
                $errors[] = "Veuillez revérifier vos paramètres de connexion";
            }

        }
        else
        {
            $errors[] = "Adresse email non valide";
        }

    }
    else
    {
        $errors[] = "Email et mot de passe requis";
    }

}

?>


<!DOCTYPE html>
<html>

<head>
    <title>My Awesome Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <div class="container h-100">
        <div class="d-flex flex-column align-items-center justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="images/mapcom.jpg" class="brand_logo" alt="Logo">
                    </div>
                </div>
                <div class="d-flex justify-content-center form_container">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input required type="email" name="email" class="form-control input_user" placeholder="Email">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input required type="password" name="password" class="form-control input_pass" placeholder="Mot de passe">
                        </div>
                        <div class="d-flex justify-content-center mt-3 px-0 login_container">
                            <input name="submit" type="submit" class="btn login_btn" value="Se connecter">
                        </div>
                    </form>
                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-center links">
                        Pas de compte ? <a href="register.php" class="ml-2">Inscrivez-vous !</a>
                    </div>
                    <!--div class="d-flex justify-content-center links">
                        <a href="#">Forgot your password?</a>
                    </div-->
                </div>
            </div>
            <?php
                if(isset($errors) && count($errors) > 0)
                {
                    foreach($errors as $error_msg)
                    {
                        echo '<div class="alert alert-danger text-center">'.$error_msg.'</div>';
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
