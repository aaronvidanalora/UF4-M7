<?php

// Datos de conexión a la base de datos
$host = 'localhost';
$dbname = 'usuaris';
$username = 'postgres';
$password = 'postgres';

try {
    // Conexión a la base de datos
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL para seleccionar todos los datos de la tabla
    $sql = "SELECT * FROM results";
    $stmt = $pdo->query($sql);

    // Comienza la tabla HTML
    echo "<table border='1'>";
    echo "<tr><th>Result ID</th><th>Code</th><th>Name</th><th>Description</th><th>Document Number</th><th>Category</th><th>Field 1</th><th>Field 2</th><th>Field 3</th><th>Center</th><th>Image URL</th><th>Extra Field</th><th>Value</th></tr>";

    // Iterar sobre los resultados y mostrar en la tabla
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['result_id'] . "</td>";
        echo "<td>" . $row['code'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['document_number'] . "</td>";
        echo "<td>" . $row['category'] . "</td>";
        echo "<td>" . $row['field1'] . "</td>";
        echo "<td>" . $row['field2'] . "</td>";
        echo "<td>" . $row['field3'] . "</td>";
        echo "<td>" . $row['center'] . "</td>";
        echo "<td>" . $row['image_url'] . "</td>";
        echo "<td>" . $row['extra_field'] . "</td>";
        echo "<td>" . $row['value'] . "</td>";
        echo "</tr>";
    }

    // Cierra la tabla HTML
    echo "</table>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
