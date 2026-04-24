<?php
require 'config/db.php';

if(isset($_POST['nom'], $_POST['prenom'], $_POST['filiere'])){

    $sql = "INSERT INTO etudiants (nom, prenom, filiere_id)
            VALUES (?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['filiere']
    ]);

    header("Location: index.php");
}
?>