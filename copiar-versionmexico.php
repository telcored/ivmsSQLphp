<?php
// Configuración de conexión a SQL Server
$serverName = "127.0.0.1";
$databaseSQL = "ivmsLocal";
$usernameSQL = "sa";
$passwordSQL = "Telco.088red";

// Configuración de conexión a MySQL
$host = "162.241.62.82";
$db_mysql = "theotoko_ivmsCpanel";
$user_mysql = "theotoko_ivmsUser";
$pass_mysql = "Telcored.2024mx";

try {
    // Conexión a SQL Server
    $connSQL = new PDO("sqlsrv:Server=$serverName;Database=$databaseSQL", $usernameSQL, $passwordSQL);
    $connSQL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Conexión a MySQL
    $connMySQL = new PDO("mysql:host=$hostMySQL;dbname=$databaseMySQL;charset=utf8", $usernameMySQL, $passwordMySQL);
    $connMySQL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    while (true) {
        // Obtener el último authDateTime en MySQL
        $query = "SELECT MAX(authDateTime) as lastSyncTime FROM authRecords";
        $stmtMySQL = $connMySQL->query($query);
        $lastSyncTime = $stmtMySQL->fetchColumn();

        // Consultar solo los registros nuevos en SQL Server
        $sqlQuery = "SELECT * FROM attlog WHERE authDateTime > :lastSyncTime ORDER BY authDateTime ASC";
        $stmtSQL = $connSQL->prepare($sqlQuery);
        $stmtSQL->bindParam(':lastSyncTime', $lastSyncTime);
        $stmtSQL->execute();
        $newRecords = $stmtSQL->fetchAll(PDO::FETCH_ASSOC);

        // Insertar nuevos registros en MySQL
        $insertQuery = "INSERT INTO authRecords (employeeID, authDateTime, authDate, authTime, direction, deviceName, deviceSN, personName, cardNo) 
                        VALUES (:employeeID, :authDateTime, :authDate, :authTime, :direction, :deviceName, :deviceSN, :personName, :cardNo)";
        $stmtMySQLInsert = $connMySQL->prepare($insertQuery);

        $recordCount = 0;
        foreach ($newRecords as $record) {
            $stmtMySQLInsert->execute([
                ':employeeID' => $record['employeeID'],
                ':authDateTime' => $record['authDateTime'],
                ':authDate' => $record['authDate'],
                ':authTime' => $record['authTime'],
                ':direction' => $record['direction'],
                ':deviceName' => $record['deviceName'],
                ':deviceSN' => $record['deviceSN'],
                ':personName' => $record['personName'],
                ':cardNo' => $record['cardNo']
            ]);
            $recordCount++;
        }

        echo "Sincronización completada: $recordCount nuevos registros copiados.\n";

        // Esperar 30 segundos antes de la próxima sincronización
        sleep(10);
    }

} catch (PDOException $e) {
    echo "Error en la sincronización: " . $e->getMessage();
}
?>
