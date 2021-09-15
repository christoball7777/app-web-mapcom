<?php

require_once 'database/connection.php';

try {

    $sql = 'UPDATE user SET deleted=TRUE WHERE user_id=?';
    $q = $db->prepare($sql);
    $q->bindParam(1, $_GET['id']);

    if($q->execute()) {
        header("Location: dashboard.php");
    }

} catch (PDOException $e) {
    die("Could not connect to the database" . $e->getMessage());
}

?>