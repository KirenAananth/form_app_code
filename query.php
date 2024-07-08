<?php
$host = '192.168.0.188';
$db = 'form_app';
$user = 'root';
$pass = 'passwd';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    // Establish database connection
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    header('Content-Type: application/json');
    
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $pdo->prepare("SELECT first_name, last_name, email, phone, city FROM user_input WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        // Fetch the result
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            echo json_encode($user);
        } else {
            echo json_encode(["error" => "No user found with ID $id"]);
        }
    } else {
        echo json_encode(["error" => "No ID provided"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
