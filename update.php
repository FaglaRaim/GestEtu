<?php
require 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Récupérer étudiant
$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id=?");
$stmt->execute([$id]);
$e = $stmt->fetch();

if (!$e) {
    header("Location: index.php");
    exit;
}

// Récupérer filières
$filieres = $pdo->query("SELECT * FROM filieres")->fetchAll();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $filiere = $_POST['filiere'];

    if ($nom && $prenom && $filiere) {

        // Vérification doublon (sauf lui-même)
        $check = $pdo->prepare("
            SELECT id FROM etudiants
            WHERE nom=? AND prenom=? AND filiere_id=? AND id!=?
        ");
        $check->execute([$nom, $prenom, $filiere, $id]);

        if ($check->rowCount() === 0) {

            $update = $pdo->prepare("
                UPDATE etudiants 
                SET nom=?, prenom=?, filiere_id=? 
                WHERE id=?
            ");
            $update->execute([$nom, $prenom, $filiere, $id]);

            header("Location: index.php");
            exit;
        } else {
            $error = "⚠ Cet étudiant existe déjà dans cette filière";
        }

    } else {
        $error = "Tous les champs sont obligatoires";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier étudiant</title>

<link rel="stylesheet" href="assets/css/style.css">

<style>

/* CONTAINER LOCAL */
.form-box {
    max-width: 500px;
    margin: auto;
}

/* ACTIONS */
.actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
}

/* BOUTONS */
.btn-small {
    width: auto !important;
    padding: 8px 14px;
    font-size: 13px;
}

/* CONFIRMATION */
.btn-confirm {
    background: #3498db;
    color: white;
}

.btn-confirm:hover {
    background: #2980b9;
}

/* RETOUR */
.btn-retour {
    background: #7f8c8d;
    color: white;
}

.btn-retour:hover {
    background: #636e72;
}

/* ERREUR */
.error-msg {
    color: #e74c3c;
    margin-top: 10px;
    text-align: center;
}

</style>

</head>

<body>

<div class="container">

<h2 style="text-align:center;">✏ Modifier un étudiant</h2>

<div class="form-box">

<form method="POST">

<input type="text" name="nom"
value="<?= htmlspecialchars($e['nom']) ?>"
placeholder="Nom">

<input type="text" name="prenom"
value="<?= htmlspecialchars($e['prenom']) ?>"
placeholder="Prénom">

<select name="filiere">
<?php foreach($filieres as $f): ?>
<option value="<?= $f['id'] ?>"
<?= $f['id'] == $e['filiere_id'] ? 'selected' : '' ?>>
<?= htmlspecialchars($f['nom']) ?>
</option>
<?php endforeach; ?>
</select>

<!-- ACTIONS -->
<div class="actions">

<a href="index.php" class="btn-retour btn-small">
⬅ Retour
</a>

<button type="submit" class="btn-confirm btn-small">
✔ Confirmer
</button>

</div>

<?php if($error): ?>
<p class="error-msg"><?= $error ?></p>
<?php endif; ?>

</form>

</div>

</div>

</body>
</html>
