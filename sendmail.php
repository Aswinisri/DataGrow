<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

header('Content-Type: application/json');

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get form data safely
$name    = $_POST['name'] ?? '';
$email   = $_POST['email'] ?? '';
$mobile  = $_POST['mobile'] ?? '';
$message = $_POST['message'] ?? '';
$subject = $_POST['subject'] ?? 'New Contact Message';

if (!$name || !$email || !$message) {
    echo json_encode(['success' => false, 'message' => 'Required fields missing']);
    exit;
}

$mail = new PHPMailer(true);

try {
    // SMTP Config
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ashusrini07@gmail.com';
    $mail->Password   = 'dfwk mpjt zttq stxb'; // App password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // From and To
    $mail->setFrom($email, $name);
    $mail->addAddress('ashusrini07@gmail.com');

    // Email content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = "
        <h3>Contact Form Submission</h3>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Mobile:</strong> $mobile</p>
        <p><strong>Message:</strong><br>$message</p>
    ";

    $mail->send();

    // Redirect after success
   header("Location: contact.html?success=true");
exit;

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $mail->ErrorInfo]);
}
