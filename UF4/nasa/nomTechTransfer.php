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

    // URL de la API
    $url = 'https://api.nasa.gov/techtransfer/patent/?engine&api_key=aUIXxjfCydc4B3itJvUHry0AX1y1maYJBbZ7RGFl';

    // Obtener datos de la API
    $data = file_get_contents($url);
    $jsonData = json_decode($data, true);

    // Iterar sobre los primeros 5 resultados y insertar en la base de datos
    $counter = 0;
    foreach ($jsonData['results'] as $result) {
        $result_id = $result[0];
        $code = $result[1];
        $name = $result[2];
        $description = $result[3];
        $document_number = $result[4];
        $category = $result[5];
        $field1 = $result[6];
        $field2 = $result[7];
        $field3 = $result[8];
        $center = $result[9];
        $image_url = $result[10];
        $extra_field = $result[11];
        $value = $result[12];

        // Consulta SQL para insertar datos en la tabla
        $sql = "INSERT INTO results (result_id, code, name, description, document_number, category, field1, field2, field3, center, image_url, extra_field, value)
                VALUES (:result_id, :code, :name, :description, :document_number, :category, :field1, :field2, :field3, :center, :image_url, :extra_field, :value)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':result_id' => $result_id,
            ':code' => $code,
            ':name' => $name,
            ':description' => $description,
            ':document_number' => $document_number,
            ':category' => $category,
            ':field1' => $field1,
            ':field2' => $field2,
            ':field3' => $field3,
            ':center' => $center,
            ':image_url' => $image_url,
            ':extra_field' => $extra_field,
            ':value' => $value
        ]);

        $counter++;
        if ($counter >= 5) {
            break;
        }
    }

    echo "Las primeras 5 filas de datos han sido insertadas correctamente.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
