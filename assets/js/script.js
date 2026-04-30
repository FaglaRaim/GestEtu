// assets/js/script.js
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form');

    if (form) {
        form.addEventListener('submit', function(e) {
            const nom = document.querySelector('input[name="nom"]').value.trim();
            const prenom = document.querySelector('input[name="prenom"]').value.trim();
            const filiere = document.querySelector('select[name="filiere"]').value;

            // Vérification des champs [cite: 94, 95, 96]
            if (nom === "" || prenom === "" || filiere === "") {
                e.preventDefault(); // Empêche l'envoi [cite: 97]
                alert("Veuillez remplir tous les champs (Nom, Prénom et Filière) !"); [cite: 98]
            }
        });
    }
});