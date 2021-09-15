<?php

require_once 'database/connection.php';

try {

    $sql = 'DELETE FROM user WHERE user_id=?';
    $q = $db->prepare($sql);
    $q->bindParam(1, $_GET['id']);

    if($q->execute()) {
        header("Location: dashboard.php");
    }

} catch (PDOException $e) {
    die("Could not connect to the database" . $e->getMessage());
}

?>