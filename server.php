<!DOCTYPE html>
<html lang="es">

<head>
    <!--Aqui agregamos BootStrap-->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <meta charset="UTF-8">
    <title>Ejercicio columnas y filas</title>



</head>

<body>

    <?php
    // Configuración de conexión
    $serverName = "127.0.0.1";
    $database = "ivmsLocal";
    $username = "sa";
    $password = "Telco.088red";

    try {
        // Estableciendo la conexión utilizando PDO
        $dsn = "sqlsrv:Server=$serverName;Database=$database";
        $conn = new PDO($dsn, $username, $password);

        // Establecer el modo de error a excepción
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "Conexión exitosa a SQL Server.";

        // Prueba de consulta simple a la tabla attlog
        $query = "SELECT TOP 100 * FROM attlog";
        $stmt = $conn->query($query);

        // Mostrar resultados
        echo "<table class='table table-bordered table-sm'>";
        echo "<tr><th>employeeID</th><th>authDateTime</th><th>authDate</th><th>authTime</th><th>direction</th><th>deviceName</th><th>deviceSN</th><th>personName</th><th>cardNo</th></tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['employeeID']) . "</td>";

            // Asegúrate de que las columnas de fecha sean tratadas correctamente
            echo "<td>" . htmlspecialchars($row['authDateTime']) . "</td>";
            echo "<td>" . htmlspecialchars($row['authDate']) . "</td>";
            echo "<td>" . htmlspecialchars($row['authTime']) . "</td>";
            echo "<td>" . htmlspecialchars($row['direction']) . "</td>";
            echo "<td>" . htmlspecialchars($row['deviceName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['deviceSN']) . "</td>";
            echo "<td>" . htmlspecialchars($row['personName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['cardNo']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Cerrar conexión
        $conn = null; // PDO se cierra automáticamente al finalizar el script

    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
    ?>
</body>

<footer>
   
</footer>

</html>