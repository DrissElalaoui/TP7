<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["Name"] ?? ''));
    $email = htmlspecialchars(trim($_POST["Email"] ?? ''));
    $password = $_POST["Password"] ?? '';
    $confirmPassword = $_POST["ConfirmPasswod"] ?? '';
    $username = htmlspecialchars(trim($_POST["Username"] ?? ''));
    $phone = htmlspecialchars(trim($_POST["PhoneNumber"] ?? ''));

    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword) || empty($phone)) {
        echo "Veuillez remplir tous les champs obligatoires.";
        exit;
    }

    if ($password !== $confirmPassword) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $host = "localhost";
    $dbname = "form";
    $usernameDB = "root";
    $passwordDB = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usernameDB, $passwordDB);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO users (email, name, username, phone, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$email, $name, $username, $phone, $hashedPassword]);

        echo "Données enregistrées avec succès.";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Méthode non autorisée.";
}
?>
