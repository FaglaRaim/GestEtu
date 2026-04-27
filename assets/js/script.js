document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("form");

    if (form) {
        form.addEventListener("submit", function (e) {

            e.preventDefault();

            let formData = new FormData(form);

            let nom = formData.get("nom").trim();
            let prenom = formData.get("prenom").trim();
            let filiere = formData.get("filiere");

            let error = document.getElementById("error");
            let success = document.getElementById("success");

            if (error) error.textContent = "";
            if (success) success.textContent = "";

            if (nom === "" || prenom === "" || filiere === "") {
                if (error) error.textContent = "Tous les champs sont obligatoires";
                return;
            }

            fetch("traitement.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                if (data === "success") {
                    if (success) success.textContent = "Étudiant ajouté avec succès ";
                    form.reset();
                    loadStudents();
                }
            });

        });
    }

    const searchInput = document.getElementById("search");

    if (searchInput) {
        searchInput.addEventListener("keyup", function () {

            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll("#tableBody tr");

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(value) ? "" : "none";
            });

        });
    }

});

function loadStudents() {
    fetch("index.php")
        .then(res => res.text())
        .then(html => {
            let parser = new DOMParser();
            let doc = parser.parseFromString(html, "text/html");
            let newBody = doc.querySelector("#tableBody");
            document.querySelector("#tableBody").innerHTML = newBody.innerHTML;
        });
}
