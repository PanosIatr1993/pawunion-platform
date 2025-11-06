<?php
session_start();

// Checks if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Checks if user is admin — using email
function isAdmin() {
    return isset($_SESSION['user_email']) && $_SESSION['user_email'] === 'admin@pawunion.com';
}

// Refines user input
function sanitize($data) {
    $data = trim($data); // Removes whitespace from beginning and end
    $data = stripslashes($data); // Removes backslashes
    $data = htmlspecialchars($data); // Converts special chars to HTML entities
    return $data;
}

// Return a random supportive message
function getSupportMessage() {
    $messages = [
        "Every hour counts! Start searching now.",
        "You're not alone in this journey.",
        "Stay strong - many pets are found within 48 hours.",
        "Your community is here to support you.",
        "Take a deep breath - we'll help you through this.",
        "Remember to take care of yourself while searching.",
        "Thousands of pets are reunited with their families every day.",
        "Your dedication makes all the difference.",
        "Don't lose hope - persistence is key to finding your pet.",
        "Your pet is looking for you too.",
        "We understand your worry - let us help you through this process.",
        "Take it one step at a time - you're doing great.",
        "Reach out for help when you need it - that's what we're here for.",
        "Remember to check shelters daily - new pets arrive constantly.",
        "Your detailed report increases the chances of finding your pet."
    ];
    return $messages[array_rand($messages)];
}

// Relay email from one user to another without revealing addresses
function sendRelayEmail($from_id, $to_id, $subject, $message) {
    global $conn;

    // Get sender and receiver emails
    $user_query = $conn->prepare("SELECT email FROM users WHERE user_id = ?");
    
    $user_query->bind_param("i", $from_id);
    $user_query->execute();
    $from_result = $user_query->get_result();
    $from_email = $from_result->fetch_assoc()['email'] ?? null;

    $user_query->bind_param("i", $to_id);
    $user_query->execute();
    $to_result = $user_query->get_result();
    $to_email = $to_result->fetch_assoc()['email'] ?? null;

    $user_query->close();

    if (!$from_email || !$to_email) return false;

    $headers = "From: PawUnion <no-reply@pawunion.local>\r\n";
    $headers .= "Reply-To: " . $from_email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    return mail($to_email, $subject, $message, $headers);
}
?>