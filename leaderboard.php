<?php
// leaderboard.php

// Database connection (update with your own connection details)
$servername = "127.0.0.1:4306";
$username = "root";
$password = "";
$dbname = "family_fued";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch leaderboard data
$sql = "SELECT team_a_score, team_b_score, created_at FROM leaderboard ORDER BY created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Include your custom CSS -->
</head>
<body>

<header id="game-header" class="bg-primary text-white text-center py-4">
    <h1>Family Feud Game Leaderboard</h1>
</header>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">Family Feud</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Leaderboard</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<section class="container mt-4">
    <h2 class="text-center">Game Leaderboard</h2>

    <table class="table table-striped table-bordered score-table text-center">
        <thead class="thead-dark">
            <tr>
                <th>Team A Score</th>
                <th>Team B Score</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output each row of data
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row['team_a_score'] . "</td><td>" . $row['team_b_score'] . "</td><td>" . $row['created_at'] . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No scores available</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</section>
</body>
</html>

