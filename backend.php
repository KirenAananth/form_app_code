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

    
    $stmt = $pdo->query("SHOW TABLES LIKE 'user_input'");
    $tableExists = $stmt->rowCount() > 0;
    if (!$tableExists) {
        throw new Exception("Table 'user_input' does not exist in the database.");
    }

   
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $email = $data['email'];
    $phone = $data['phone'];
    $city = $data['city'];

   
    $stmt = $pdo->prepare("INSERT INTO user_input (first_name, last_name, email, phone, city) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$firstName, $lastName, $email, $phone, $city]);

   
    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(400); // Bad request
    echo json_encode(["error" => $e->getMessage()]);
}
?>
