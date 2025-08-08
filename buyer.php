<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

header('Content-Type: application/json');

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Sanitize form inputs
$firstName = htmlspecialchars($_POST["first_name"] ?? '');
$lastName  = htmlspecialchars($_POST["last_name"] ?? '');
$phone     = htmlspecialchars($_POST["phone"] ?? '');
$email     = htmlspecialchars($_POST["email"] ?? '');
$website   = htmlspecialchars($_POST["website"] ?? '');
$address   = htmlspecialchars($_POST["address"] ?? '');
$orgType   = htmlspecialchars($_POST["org_type"] ?? '');
$custType  = htmlspecialchars($_POST["cust_type"] ?? '');
$terms     = isset($_POST["terms"]) ? 'Yes' : 'No';

// Validate required fields
if (!$firstName || !$email || !$phone) {
    echo json_encode(['success' => false, 'message' => 'Required fields missing']);
    exit;
}

$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info.datagrowinnovation@gmail.com';  // Your Gmail
    $mail->Password   = 'gygx vtze pwdp ljcp';    // App password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Email Settings
    $mail->setFrom($email, "$firstName $lastName");
    $mail->addAddress('info.datagrowinnovation@gmail.com'); // Receiver address (same as contact form)

    $mail->isHTML(true);
    $mail->Subject = 'New Buyer/Supplier Form Submission';
    $mail->Body    = "
        <h3>Buyer/Supplier Form Submission</h3>
        <p><strong>First Name:</strong> $firstName</p>
        <p><strong>Last Name:</strong> $lastName</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Website:</strong> $website</p>
        <p><strong>Address:</strong> $address</p>
        <p><strong>Organization Type:</strong> $orgType</p>
        <p><strong>Customer Type:</strong> $custType</p>
        <p><strong>Agreed to Terms:</strong> $terms</p>
    ";

    $mail->send();

    // Redirect on success
    header("Location: thank-you.html");
    exit;

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $mail->ErrorInfo]);
}
?>
