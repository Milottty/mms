<?php

    include_once 'config.php';

    $sql = "DELETE FROM users WHERE id=:id";

    $id = $_GET['id'];

    $sqlUsers = $conn->prepare($sql);
    $sqlUsers->bindParam(":id", $id);
    $sqlUsers->execute();

    header("Location:dashboard.php");