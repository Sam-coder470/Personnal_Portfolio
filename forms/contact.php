<?php
// Activer l'affichage des erreurs pour le debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Charger PHPMailer
require '../assets/vendor/php-email-form/PHPMailer-master/src/PHPMailer.php';
require '../assets/vendor/php-email-form/PHPMailer-master/src/SMTP.php';
require '../assets/vendor/php-email-form/PHPMailer-master/src/Exception.php';

// Adresse email de réception
$receiving_email_address = 'samloik.codotoafode.77@edu.uiz.ac.ma';

// Vérifier si la requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si tous les champs sont bien remplis
    if (!isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
        die("Erreur : Tous les champs sont obligatoires.");
    }

    // Nettoyage et validation des entrées
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Erreur : Adresse e-mail invalide.");
    }

    // Instancier PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = "samloik.codotoafode.77@edu.uiz.ac.ma"; // Remplace par ton email Gmail
        $mail->Password = "fzom vaui altb ldf"; // ⚠️ Utilise un mot de passe d’application Gmail !
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Paramètres de l'email
        $mail->setFrom($email, $name);
        $mail->addAddress($receiving_email_address);
        $mail->addReplyTo($email, $name); // Pour répondre directement à l'expéditeur
        $mail->Subject = $subject;
        $mail->Body = "Nom: $name\nEmail: $email\n\nMessage:\n$message";
        $mail->CharSet = 'UTF-8';

        // Envoyer l'email
        if ($mail->send()) {
            header("Location: index.html"); // 🔄 Redirection automatique après envoi
            exit();
        } else {
            echo "Erreur : L'email n'a pas pu être envoyé.";
        }
    } catch (Exception $e) {
        echo "Erreur : {$mail->ErrorInfo}";
    }
} else {
    die("Erreur : Méthode non autorisée.");
}
