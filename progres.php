<?php
// Conectare la baza de date
$servername = "localhost";
$db_username = "root";
$db_password = "";
$database = "micromind";

$conn = new mysqli($servername, $db_username, $db_password, $database);

if ($conn->connect_error) {
    die("Eroare conexiune: " . $conn->connect_error);
}

// Aici presupunem că părintele vrea să vadă progresul copilului cu ID 1
$user_id = 1; // În viitor, îl vei lua din baza de date din contul părintelui

$sql = "SELECT curs, progres, nota FROM progres_curs WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Statistica progres copil</h2>";
echo "<table border='1' cellpadding='8'>";
echo "<tr><th>Curs</th><th>Progres</th><th>Notă</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['curs']) . "</td>";
    echo "<td>" . $row['progres'] . "%</td>";
    echo "<td>" . $row['nota'] . "</td>";
    echo "</tr>";
}

echo "</table>";

$stmt->close();
$conn->close();
?>



