<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$country = isset($_GET['country']) ? $_GET['country'] : '';

if ($country) {
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->execute(['country' => "%$country%"]);
} else {
    $stmt = $conn->query("SELECT * FROM countries");
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<ul>";
foreach ($results as $row) {
    echo "<li>" . htmlspecialchars($row['name']) . " is ruled by " . htmlspecialchars($row['head_of_state']) . "</li>";
}
echo "</ul>";
?>