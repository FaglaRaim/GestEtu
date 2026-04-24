document.getElementById("form").addEventListener("submit", function(e){
    let nom = document.querySelector("input[name='nom']").value;
    let prenom = document.querySelector("input[name='prenom']").value;

    if(nom === "" || prenom === ""){
        alert("Tous les champs sont obligatoires !");
        e.preventDefault();
    }
});