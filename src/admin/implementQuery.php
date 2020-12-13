<?php
function saveChanges($query) {
    include '../includes/database.php';
    $stmt = $database->stmt_init();
    $stmt->prepare($query);
    $stmt->execute();
    $stmt->close();
}