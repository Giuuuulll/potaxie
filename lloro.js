document.getElementById("registroForm").addEventListener("submit", function(event) {
    event.preventDefault();
    let formData = new FormData(this);
    
    fetch("registro.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.respuesta === "ok") {
            Swal.fire("Registro exitoso!", "Bienvenido!", "success")
            .then(() => {
                window.location.href = "index.php"; 
            });
        } else {
            Swal.fire("Oops...", data.mensaje || "Algo salió mal", "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "No se pudo procesar la solicitud", "error");
        console.error(error);
    });
});
