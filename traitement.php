<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$filiere = $_POST['filiere'] ?? '';

if ($nom === '' || $prenom === '' || $filiere === '') {
echo "error";
exit;
}

// doublon
$check = $pdo->prepare("SELECT id FROM etudiants WHERE nom=? AND prenom=? AND filiere_id=?");
$check->execute([$nom,$prenom,$filiere]);

if ($check->rowCount() > 0) {
echo "exists";
exit;
}

$stmt = $pdo->prepare("INSERT INTO etudiants(nom,prenom,filiere_id) VALUES(?,?,?)");
$stmt->execute([$nom,$prenom,$filiere]);

echo "success";
}
