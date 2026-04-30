<?php
require 'config.php';

if(isset($_POST['ids'])){

$ids = $_POST['ids'];
$placeholders = implode(',', array_fill(0, count($ids), '?'));

$stmt = $pdo->prepare("DELETE FROM etudiants WHERE id IN ($placeholders)");
$stmt->execute($ids);
}

header("Location: index.php");
exit;