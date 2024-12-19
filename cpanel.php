<?php
// Configuración de conexión
$host = "190.107.177.32";
$database = "cte4240_ivmsCpanel";
$username = "cte4240_ivmsUser";
$password = "Telco.088red";

// Establecer la conexión usando PDO
try {
    $dsn = "mysql:host=$host;dbname=$database;charset=utf8";
    $pdo = new PDO($dsn, $username, $password);

    // Configurar PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa a MySQL.";

    // Prueba de consulta simple a la tabla authRecords
    $query = "SELECT * FROM authRecords LIMIT 100";
    $stmt = $pdo->query($query);

    // Mostrar resultados
    echo "<table border='1'>";
    echo "<tr><th>employeeID</th><th>authDateTime</th><th>authDate</th><th>authTime</th><th>direction</th><th>deviceName</th><th>deviceSN</th><th>personName</th><th>cardNo</th></tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['employeeID']) . "</td>";
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
    $pdo = null;

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
