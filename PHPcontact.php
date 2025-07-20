<?php

// Conectare la baza de date
$host = "localhost";
$user = "root";
$password = "";
$database = "micromind";

// Creăm conexiunea
$conn = new mysqli($host, $user, $password, $database);

// Verificăm conexiunea
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

// Verificăm dacă formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preluăm datele din formular
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Pregătim interogarea SQL (metodă sigură)
    $stmt = $conn->prepare("INSERT INTO micromind (name, email, subject, message) VALUES (?, ?, ?, ?)");

    // Legăm valorile
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    // Executăm interogarea
    if ($stmt->execute()) {
       print "Formularul a fost trimis cu succes!";
    } else {
       print "Eroare la trimitere: " . $stmt->error;
    }

    // Închidem statement-ul
    $stmt->close();
}

// Închidem conexiunea
$conn->close();
?>

