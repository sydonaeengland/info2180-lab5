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

if ($results) {
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Country Name</th>";
    echo "<th>Continent</th>";
    echo "<th>Independence Year</th>";
    echo "<th>Head of State</th>";
    echo "</tr>";

    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
        echo "<td>" . htmlspecialchars($row['independence_year'] ?? "N/A") . "</td>";
        echo "<td>" . htmlspecialchars($row['head_of_state'] ?? "N/A") . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No results found.</p>";
}
?>
