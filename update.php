<?php
require 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
$stmt->execute([$id]);
$etudiant = $stmt->fetch();

$filieres = $pdo->query("SELECT * FROM filieres")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $filiere = $_POST['filiere'];

    if (!empty($nom) && !empty($prenom) && !empty($filiere)) {

        $sql = "UPDATE etudiants 
                SET nom = ?, prenom = ?, filiere_id = ?
                WHERE id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $filiere, $id]);

        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">

<h1>🎓 Gestion des Étudiants</h1>

<h2>Modifier un étudiant</h2>

<form method="POST" id="form">
    <input type="text" name="nom" value="<?= htmlspecialchars($etudiant['nom']) ?>">
    <input type="text" name="prenom" value="<?= htmlspecialchars($etudiant['prenom']) ?>">

    <select name="filiere">
        <option value="">-- Choisir une filière --</option>
        <?php foreach ($filieres as $f): ?>
            <option value="<?= $f['id'] ?>" <?= $f['id'] == $etudiant['filiere_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($f['nom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Modifier</button>

    <p id="error"></p>
</form>

<a href="index.php" class="btn-retour">⬅ Retour</a>

</div>

<script src="assets/js/script.js"></script>

</body>
</html>
