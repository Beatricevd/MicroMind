<?php
// Conectare la baza de date
$servername = "localhost";
$username_db = "root";
$password_db = "";
$database = "micromind";

$conn = mysqli_connect($servername, $username_db, $password_db, $database);

if (!$conn) {
    die("❌ Conexiune eșuată: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        die("❌ Parolele nu se potrivesc.");
    }

    // Hash parola
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Inserare în tabelul users
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "✅ Cont creat cu succes!";
    } else {
        echo "❌ Eroare: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>



