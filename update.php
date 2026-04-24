<?php
require 'config/db.php';

// Vérifier si id existe
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Récupérer étudiant
$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
$stmt->execute([$id]);
$etudiant = $stmt->fetch();

// Vérifier si étudiant existe
if (!$etudiant) {
    header("Location: index.php");
    exit();
}

// Récupérer filières
$filieres = $pdo->query("SELECT * FROM filieres")->fetchAll();

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $filiere = $_POST['filiere'];

    if (!empty($nom) && !empty($prenom)) {

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
    <title>Modifier étudiant</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">
    <h2>Modifier un étudiant</h2>

    <form method="POST" id="form">
        <input type="text" name="nom" value="<?= htmlspecialchars($etudiant['nom']) ?>" placeholder="Nom">
        <input type="text" name="prenom" value="<?= htmlspecialchars($etudiant['prenom']) ?>" placeholder="Prénom">

        <select name="filiere">
            <?php foreach ($filieres as $f): ?>
                <option value="<?= $f['id'] ?>"
                    <?= $f['id'] == $etudiant['filiere_id'] ? 'selected' : '' ?>>
                    <?= $f['nom'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Modifier</button>
    </form>

    <a href="index.php" class="btn-retour">⬅ Retour</a>
</div>

<script src="assets/js/script.js"></script>

</body>
</html>