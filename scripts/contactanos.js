$(document).ready(function() {
    // Captura el evento de envío del formulario
    $("#formulariocotizacion2").on("submit", function(event) {
        console.log("esta llegando aca-----------------")
        event.preventDefault(); // Evita que se recargue la página
         // Muestra un modal de "Enviando"
         // Validar campos
        var nombre = $("input[name='Nombre']").val();
        var correo = $("input[name='Correo']").val();
        var numero = $("input[name='Numero']").val();
        
        // Validar que los campos estén llenos
        if (nombre.trim() === "" || correo.trim() === "" || numero.trim() === "") {
            Swal.fire({
                title: "Error",
                text: "Por favor completa todos los campos obligatorios",
                icon: "error",
                button: "Cerrar",
            });
            return;
        }
        
         Swal.fire({
            title: "Enviando",
            text: "Por favor espera...",
            icon: "info",
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        });
        // Realiza la petición AJAX
        $.ajax({
            url: "enviar_correo.php", // URL del archivo PHP que procesa el formulario
            type: "POST", // Método de envío del formulario
            data: $(this).serialize(), // Datos del formulario serializados
            success: function(response) {
                Swal.close();
                // Procesa la respuesta del servidor
                // Mostrar el mensaje de retorno como un modal de SweetAlert
                Swal.fire({
                    title: "Mensaje enviado",
                    text: response,
                    icon: "success",
                    button: "Cerrar",
                });
            },
            error: function() {
                Swal.close();
                // Maneja el error si la petición AJAX falla
                Swal.fire({
                    title: "Error",
                    text: "Ocurrió un error al enviar el mensaje",
                    icon: "error",
                    button: "Cerrar",
                });
            }
        });
    });
});
