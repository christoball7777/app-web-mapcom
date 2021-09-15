<?php
require_once 'database/connection.php';

try {

    $sql = 'SELECT * FROM user WHERE deleted = 0';
    $sql2 = 'SELECT * FROM user WHERE deleted = 1';
    $q = $db->query($sql);
    $q2 = $db->query($sql2);
    $q->setFetchMode(PDO::FETCH_ASSOC);
    $q2->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not connect to the database" . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Document</title>
    <style>
        body {
            background: #dd5e89;
            background: -webkit-linear-gradient(to left, #dd5e89, #f7bb97);
            background: linear-gradient(to left, #dd5e89, #f7bb97);
            min-height: 100vh;
            color: black;
        }
    </style>
</head>

<body>

    <!-- Demo header-->
    <div class="container">
        <div class="row">
            <div class="col-md-12 p-3">
                <nav class="nav nav-tabs">
                    <a class="nav-item nav-link active" href="#p1" data-toggle="tab">Agents enregistrés</a>
                    <a class="nav-item nav-link" href="#p2" data-toggle="tab">Agents supprimés</a>
                </nav>
                <div class="tab-content">
                    <div class="tab-pane active" id="p1">
                        <section class="pb-5 header text-center">
                            <div class="container py-5 text-white">
                                <header class="py-5">
                                    <h1 class="display-4">Liste des agents</h1>
                                </header>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-7 mx-auto">
                                        <div class="card border-0 shadow">
                                            <div class="card-body p-5">
                                                <!-- Responsive table -->
                                                <div class="table-responsive">
                                                    <table class="table m-0">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">N°</th>
                                                                <th scope="col">Nom</th>
                                                                <th scope="col">Prénom</th>
                                                                <th scope="col">Email</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            while ($row = $q->fetch()) :
                                                            ?>

                                                                <th scope="row"><?php echo htmlspecialchars($row['user_id']) ?></th>
                                                                <td><?php echo htmlspecialchars($row['name']) ?></td>
                                                                <td><?php echo htmlspecialchars($row['surname']) ?></td>
                                                                <td><?php echo htmlspecialchars($row['identifiant']) ?></td>
                                                                <td>
                                                                    <!-- Call to action buttons -->
                                                                    <ul class="list-inline m-0">
                                                                        <li class="<?php echo ($row['user_id'] == 1) ? 'list-inline-item' : 'd-none'?>">
                                                                            <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                                                                        </li>
                                                                        <li class="<?php echo ($row['user_id'] == 1) ? 'list-inline-item' : 'd-none'?>">
                                                                            <a href="delete-agent-temp.php?id=<?php echo $row['user_id']; ?>"><button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            <?php
                                                            endwhile;
                                                            ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="tab-pane" id="p2">
                        <section class="pb-5 header text-center">
                            <div class="container py-5 text-white">
                                <header class="py-5">
                                    <h1 class="display-4">Liste des agents</h1>
                                </header>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-7 mx-auto">
                                        <div class="card border-0 shadow">
                                            <div class="card-body p-5">
                                                <!-- Responsive table -->
                                                <div class="table-responsive">
                                                    <table class="table m-0">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">N°</th>
                                                                <th scope="col">Nom</th>
                                                                <th scope="col">Prénom</th>
                                                                <th scope="col">Email</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            while ($row = $q2->fetch()) :
                                                            ?>

                                                                <tr>
                                                                    <th scope="row"><?php echo htmlspecialchars($row['user_id']) ?></th>
                                                                    <td><?php echo htmlspecialchars($row['name']) ?></td>
                                                                    <td><?php echo htmlspecialchars($row['surname']) ?></td>
                                                                    <td><?php echo htmlspecialchars($row['identifiant']) ?></td>
                                                                    <td>
                                                                        <!-- Call to action buttons -->
                                                                        <ul class="list-inline m-0">
                                                                            <li class="<?php echo ($row['user_id'] == 1) ? 'list-inline-item' : 'd-none'?>">
                                                                                <a href="delete-agent-def.php?id=<?php echo $row['user_id']; ?>"><button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></a>
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            endwhile;
                                                            ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="text-center">
                        <a href="logout.php"><button class="btn btn-primary font-weight-bold">Déconnexion</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>