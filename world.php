<?php
$host = 'localhost';
$username = 'lab5_user'; 
$password = 'password123'; 
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = isset($_GET['country']) ? $_GET['country'] : '';
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : 'countries';

if ($lookup === 'cities') {
    $stmt = $conn->prepare("
        SELECT cities.name AS city_name, cities.district, cities.population
        FROM cities
        JOIN countries ON cities.country_code = countries.code
        WHERE countries.name LIKE :country
    ");
    $stmt->execute(['country' => "%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>City Name</th>";
        echo "<th>District</th>";
        echo "<th>Population</th>";
        echo "</tr>";

        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['city_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['district']) . "</td>";
            echo "<td>" . htmlspecialchars($row['population']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No cities found for the specified country.</p>";
    }
} else {
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
        echo "<p>No results found for the specified country.</p>";
    }
}
?>