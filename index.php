<?php require 'config.php'; ?>

<?php
$filieres = $pdo->query("SELECT * FROM filieres")->fetchAll();

$etudiants = $pdo->query("
    SELECT e.*, f.nom as filiere
    FROM etudiants e
    JOIN filieres f ON e.filiere_id = f.id
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des étudiants</title>

<link rel="stylesheet" href="assets/css/style.css">

<style>

/* ===== HEADER ===== */
.header {
    text-align: center;
    margin-bottom: 30px;
}

/* ===== CARDS ===== */
.card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}

/* ===== FORM INLINE ===== */
.form-row {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.form-row input,
.form-row select {
    flex: 1;
}

/* ===== BOUTON AJOUT (BLEU) ===== */
.btn-add {
    width: auto !important;
    padding: 10px 18px;
    background: #3498db;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    transition: 0.2s;
}

.btn-add:hover {
    background: #2980b9;
}

/* ===== PETITS BOUTONS ===== */
.btn-small {
    width: auto !important;
    padding: 6px 10px;
    font-size: 13px;
}

/* ===== CHECKBOX ===== */
input[type="checkbox"] {
    width: auto !important;
    transform: scale(1.2);
}

/* ===== ESPACE BOUTONS ===== */
td a {
    margin: 2px;
}

.search-box {
    margin-bottom: 15px;
}

</style>

</head>

<body>

<div class="container">

<!-- HEADER -->
<div class="header">
<h1>🎓 Gestion des Étudiants</h1>
<p style="color:#7f8c8d;">Application de gestion simple et professionnelle</p>
</div>

<!-- =======================
     FORM AJOUT
======================= -->
<div class="card">

<h2>Ajouter un étudiant</h2>

<form id="form">

<div class="form-row">
    <input type="text" name="nom" placeholder="Nom">
    <input type="text" name="prenom" placeholder="Prénom">

    <select name="filiere">
        <option value="">Filière</option>
        <?php foreach($filieres as $f): ?>
            <option value="<?= $f['id'] ?>">
                <?= htmlspecialchars($f['nom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" class="btn-add">
        Ajouter
    </button>
</div>

<p id="error"></p>
<p id="success"></p>

</form>

</div>

<!-- =======================
     LISTE
======================= -->
<div class="card">

<h2>Liste des étudiants</h2>

<div class="search-box">
<input type="text" id="search" placeholder="🔍 Rechercher...">
</div>

<form method="POST" action="delete_multiple.php">

<table>
<thead>
<tr>
<th><input type="checkbox" id="selectAll"></th>
<th>Nom</th>
<th>Prénom</th>
<th>Filière</th>
<th>Actions</th>
</tr>
</thead>

<tbody id="tableBody">
<?php foreach($etudiants as $e): ?>
<tr>

<td>
<input type="checkbox" name="ids[]" value="<?= $e['id'] ?>">
</td>

<td><?= htmlspecialchars($e['nom']) ?></td>
<td><?= htmlspecialchars($e['prenom']) ?></td>
<td><?= htmlspecialchars($e['filiere']) ?></td>

<td>
<a href="update.php?id=<?= $e['id'] ?>" class="btn-update btn-small">Modifier</a>
<a href="delete.php?id=<?= $e['id'] ?>" class="btn-delete btn-small" onclick="return confirm('Supprimer ?')">Supprimer</a>
</td>

</tr>
<?php endforeach; ?>
</tbody>
</table>

<button type="submit" class="btn-delete btn-small" style="margin-top:10px;"
onclick="return confirm('Supprimer la sélection ?')">
Supprimer la sélection
</button>

</form>

</div>

</div>

<script src="assets/js/script.js"></script>

<script>
// SELECT ALL
document.getElementById("selectAll")?.addEventListener("change", function(){
    document.querySelectorAll("input[name='ids[]']").forEach(cb=>{
        cb.checked = this.checked;
    });
});
</script>

</body>
</html>
