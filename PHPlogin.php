<?php
session_start(); // dacă vrei sesiuni mai târziu

// Conectare la baza de date
$servername = "localhost";
$db_username = "root";
$db_password = "";
$database = "micromind";

$conn = mysqli_connect($servername, $db_username, $db_password, $database);

if (!$conn) {
    die("❌ Conexiune eșuată: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Căutăm utilizatorul în baza de date
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    // Verificăm dacă utilizatorul există
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verificare parolă (cu hash)
        if (password_verify($password, $row["password"])) {
            echo "✅ Logare reușită. Bine ai venit, " . htmlspecialchars($username) . "!";
            // poți face aici redirect: header("Location: dashboard.html");
        } else {
            echo "❌ Parolă incorectă.";
        }
    } else {
        echo "❌ Utilizatorul nu există în baza de date.";
    }

    $stmt->close();
    $conn->close();
}
?>


