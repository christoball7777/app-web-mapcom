<?php

session_start();
require_once('database/connection.php');

if(isset($_POST['submit']))
{
    if(isset($_POST['name'],$_POST['surname'],$_POST['email'],$_POST['password']) && !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['password']))
    {
        $firstName = trim($_POST['name']);
        $lastName = trim($_POST['surname']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $options = array("cost"=>4);
        $hashPassword = password_hash($password,PASSWORD_BCRYPT,$options);

        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $sql = 'select * from user where identifiant = :email';
            $stmt = $db->prepare($sql);
            $p = ['email'=>$email];
            $stmt->execute($p);

            if($stmt->rowCount() == 0)
            {
                $sql = "insert into user (name, surname, identifiant, `password`, admin) values(:fname,:lname,:email,:pass,:admin)";

                try{
                    $handle = $db->prepare($sql);
                    $params = [];

                    if ($email == 'admin@mapcom.com') {
                        $params = [
                            ':fname'=>$firstName,
                            ':lname'=>$lastName,
                            ':email'=>$email,
                            ':pass'=>$hashPassword,
                            ':admin'=>1
                        ];
                    } else {
                        $params = [
                            ':fname'=>$firstName,
                            ':lname'=>$lastName,
                            ':email'=>$email,
                            ':pass'=>$hashPassword,
                            ':admin'=>0
                        ];
                    }

                    $handle->execute($params);

                    $success = 'Vous êtes désormais un utilisateur de la plateforme';
                    $success .= '<br/><a href="login.php" class="ml-2">Connectez-vous !</a>';

                }
                catch(PDOException $e){
                    $errors[] = $e->getMessage();
                }
            }
            else
            {
                $valFirstName = $firstName;
                $valLastName = $lastName;
                $valEmail = '';
                $valPassword = $password;

                $errors[] = 'Vous êtes déjà inscrit sur la plateforme';
            }
        }
        else
        {
            $errors[] = "Adresse email non valide";
        }
    }
    else
    {
        if(!isset($_POST['name']) || empty($_POST['name']))
        {
            $errors[] = 'Nom requis';
        }
        else
        {
            $valFirstName = $_POST['name'];
        }
        if(!isset($_POST['surname']) || empty($_POST['surname']))
        {
            $errors[] = 'Prénom requis';
        }
        else
        {
            $valLastName = $_POST['surname'];
        }

        if(!isset($_POST['email']) || empty($_POST['email']))
        {
            $errors[] = 'Email requis';
        }
        else
        {
            $valEmail = $_POST['email'];
        }

        if(!isset($_POST['password']) || empty($_POST['password']))
        {
            $errors[] = 'Mot de passe requis';
        }
        else
        {
            $valPassword = $_POST['password'];
        }

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
            <?php
                if(isset($errors) && count($errors) > 0)
                {
                    foreach($errors as $error_msg)
                    {
                        echo '<div class="alert alert-danger">'.$error_msg.'</div>';
                    }
                }

                if(isset($success))
                {

                    echo '<div class="alert alert-success text-center mt-3">'.$success.'</div>';
                }
            ?>
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
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input required type="text" name="name" class="form-control input_user" placeholder="Nom">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input required type="text" name="surname" class="form-control input_user" placeholder="Prénom">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input required type="text" name="email" class="form-control input_user" placeholder="Email">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input required type="password" name="password" class="form-control input_pass" placeholder="Mot de passe">
                        </div>
                        <div class="d-flex justify-content-center mt-3 px-0 login_container">
                            <input name="submit" type="submit" class="btn login_btn" value="Enregistrer">
                        </div>
                    </form>
                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-center links">
                        Déjà inscrit ? <a href="register.php" class="ml-2">Connectez-vous !</a>
                    </div>
                    <!--div class="d-flex justify-content-center links">
                        <a href="#">Forgot your password?</a>
                    </div-->
                </div>
            </div>
        </div>
    </div>
</body>
</html>
