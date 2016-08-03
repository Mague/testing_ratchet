<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ratchet Testing</title>
</head>

<body>
    <textarea id="msg"></textarea>
    <button type="button" onclick="enviar()">Enviar</button>

    <script>
        var host = "localhost"
        var port = "8080"
        var conn
        window.onload = function() {
            conn = new WebSocket("ws://" + host + ":" + port)
            conn.onopen = function(e) {
                console.log("Conexion establecida")
            }
            conn.onmessage = function(e) {
                console.log(e.data)
            }
        }

        function enviar() {
            var input = document.getElementById("msg")
            var msg = input.value
            input.value = ""
            conn.send(msg)
        }
    </script>
</body>

</html>