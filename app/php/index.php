<?php
$servername = getenv('MYSQL_HOST');
$username = getenv('MYSQL_USER');
$password = getenv('MYSQL_PASSWORD');
$dbname = getenv('MYSQL_DATABASE');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if not exists
$tableCreationQuery = "CREATE TABLE IF NOT EXISTS todos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($tableCreationQuery) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['item'])) {
    $item = $conn->real_escape_string($_POST['item']);
    $insertQuery = "INSERT INTO todos (item, created_at) VALUES ('$item', NOW())";
    if ($conn->query($insertQuery) === FALSE) {
        die("Error: " . $conn->error);
    }
}

// Retrieve items
$selectQuery = "SELECT * FROM todos";
$result = $conn->query($selectQuery);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista To-Do </title>
</head>
<body>
    <h1>Lista To-Do</h1>
    <form method="post" action="">
        <input type="text" name="item" placeholder="Agrega un nuevo elemento a la lista" required>
        <input type="submit" value="Agregar">
    </form>
    <h2>Elementos actuales en la lista To-Do </h2>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['item']) . " - " . $row['created_at'] . "</li>";
            }
        } else {
            echo "<li>No hay elementos en la lista</li>";
        }
        ?>
    </ul>
</body>
</html>
<?php
$conn->close();
?>