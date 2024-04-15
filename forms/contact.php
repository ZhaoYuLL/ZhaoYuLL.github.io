<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $name = strip_tags(trim($_POST["name"]));
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $subject = strip_tags(trim($_POST["subject"]));
  $message = strip_tags(trim($_POST["message"]));

  // Validate form data
  if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    http_response_code(400);
    echo "Please fill out all fields.";
    exit;
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Invalid email address.";
    exit;
  }

  // Recipient email address
  $to = "zlin36@stevens.edu";

  // Email headers
  $headers = "From: " . $email . "\r\n";
  $headers .= "Reply-To: " . $email . "\r\n";
  $headers .= "X-Mailer: PHP/" . phpversion();

  // Send email
  if (mail($to, $subject, $message, $headers)) {
    http_response_code(200);
    echo "Thank you for contacting us!";
  } else {
    http_response_code(500);
    echo "Oops! Something went wrong and we couldn't send your message.";
  }
} else {
  http_response_code(403);
  echo "There was a problem with your submission, please try again.";
}
?>