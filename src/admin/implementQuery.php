<?php
/**
 * Php file that implements the given query.
 *
 * @author Alvin John Cutay
 */
function saveChanges($query) {
    include '../includes/database.php';
    $stmt = $database->stmt_init();
    $stmt->prepare($query);
    $stmt->execute();
    $stmt->close();
}