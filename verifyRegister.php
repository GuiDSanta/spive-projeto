<?php
include("conexaodb.php"); // conexão com o banco


$id_usuario = $_SESSION['id_usuario'];

// --- BUSCAR VEÍCULOS DO USUÁRIO ---
$sql = "SELECT * FROM veiculo WHERE proprietario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$veiculos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $veiculos[] = $row;
    }
} else {
    //echo "<p>Por favor, registre um veículo antes de continuar.</p>";
}

// --- MOSTRAR VEÍCULOS E BUSCAR DISPOSITIVOS ---
// echo "<h3>Veículos Encontrados:</h3>";

foreach ($veiculos as $veiculo) {
   // echo "<hr>";
    //echo "<p><strong>Modelo:</strong> " . htmlspecialchars($veiculo['modelo']) .
        // " | <strong>Placa:</strong> " . htmlspecialchars($veiculo['placa']) .
        //" | <strong>Cor:</strong> " . htmlspecialchars($veiculo['cor']) . "</p>";

    // --- BUSCAR DISPOSITIVOS DO VEÍCULO ---
    $sql2 = "SELECT * FROM dispositivo WHERE veiculo_id = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("i", $veiculo['id_veiculo']);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if ($result2->num_rows > 0) {
        //echo "<p><strong>Informações do Veículo:</strong></p>";
        while ($dispositivo = $result2->fetch_assoc()) {
            //echo "<ul>";
            //echo "<li>Vidro Aberto: " . htmlspecialchars($dispositivo['vidro_aberto']) . "</li>";
           // echo "<li>Temperatura: " . htmlspecialchars($dispositivo['temperatura']) . "</li>";
            //echo "<li>Umidade: " . htmlspecialchars($dispositivo['umidade']) . "</li>";
            //echo "<li>Presença: " . htmlspecialchars($dispositivo['presenca']) . "</li>";
           // echo "<li>Oxigênio: " . htmlspecialchars($dispositivo['oxigenio']) . "</li>";
           // echo "<li>Perigo Temperatura: " . htmlspecialchars($dispositivo['perigo_temp']) . "</li>";
           // echo "<li>Perigo Oxigênio: " . htmlspecialchars($dispositivo['perigo_oxi']) . "</li>";
           // echo "<li>Ar Condicionado: " . htmlspecialchars($dispositivo['ar_ligado']) . "</li>";
           // echo "</ul>";
        }
    } else {
       // echo "<p>Nenhum dispositivo encontrado para este veículo.</p>";
    }

    $stmt2->close();
}

$stmt->close();



$sql = "SELECT * FROM veiculo WHERE proprietario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$veiculos = [];
while ($row = $result->fetch_assoc()) {
    $veiculos[] = $row;
}

// 2️⃣ Verificar se há veículos
if (count($veiculos) === 0) {
    echo "<p>Por favor, registre um veículo antes de continuar.</p>";
    exit;
}

// 3️⃣ Buscar dispositivos do primeiro veículo (ou todos, se quiser)
$id_veiculo = $veiculos[0]['id_veiculo'];
$sql = "SELECT * FROM dispositivo WHERE veiculo_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_veiculo);
$stmt->execute();
$result = $stmt->get_result();

$dispositivo = [];
while ($row = $result->fetch_assoc()) {
    $dispositivo[] = $row;
}

// 4️⃣ Caso não haja dispositivo registrado
if (count($dispositivo) === 0) {
    echo "<p>Por favor, registre um dispositivo para o veículo antes de continuar.</p>";
    exit;
}

?>
