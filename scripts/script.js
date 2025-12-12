document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("cadastroForm");

    if (form) {
        form.addEventListener("submit", function(event) {
            const pnomeVal = document.getElementById("pnome").value.trim();
            const lnomeVal = document.getElementById("lnome").value.trim();
            const emailVal = document.getElementById("email").value.trim();
            const usuarioVal = document.getElementById("usuario").value.trim();
            const senhaVal = document.getElementById("senha").value.trim();
            const confirmaVal = document.getElementById("confirmasenha").value.trim();

            const formato = document.querySelector("input[name='fav_formato']:checked");
            const generosSelecionados = [...document.querySelectorAll("input[name='genero']:checked")];

            // Validações básicas
            if (!pnomeVal || !lnomeVal || !emailVal || !usuarioVal) {
                alert("Preencha todos os dados pessoais.");
                event.preventDefault();
                return;
            }

            if (!senhaVal || senhaVal !== confirmaVal) {
                alert("As senhas não coincidem!");
                event.preventDefault();
                return;
            }

            if (!formato) {
                alert("Selecione seu formato favorito.");
                event.preventDefault();
                return;
            }

            if (generosSelecionados.length === 0) {
                alert("Selecione ao menos um gênero.");
                event.preventDefault();
                return;
            }

            // Se passou nas validações, o formulário segue para register.php
        });
    }
});