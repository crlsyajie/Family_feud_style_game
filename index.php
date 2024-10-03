<?php
// index.php

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the team scores from the request
    $team_a_score = intval($_POST['team_a_score']);
    $team_b_score = intval($_POST['team_b_score']);

    // Insert the scores into the leaderboard table
    $sql = "INSERT INTO leaderboard (team_a_score, team_b_score) VALUES ('$team_a_score', '$team_b_score')";

    if ($conn->query($sql) === TRUE) {
        echo "Scores inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Family Feud Game</title>
</head>
<body>

<header id="game-header" class="bg-primary text-white text-center py-4">
    <h1>Family Feud Game</h1>
</header>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Family Feud</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="leaderboard.php">Leaderboard</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="container mt-4">
    <h2>Game Introduction</h2>
    <p>The Family Feud Game is a fun way to test your knowledge of popular survey questions.</p>

    <div id="game-container" class="p-4" style="max-width: 800px; margin: auto;">
        <!-- Team name form -->
        <form id="team-names-form" method="POST" class="mb-4">
            <h3>Enter Team Names</h3>
            <div class="form-group">
                <label for="team-a-name">Team A Name:</label>
                <input type="text" id="team-a-name" name="team_a_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="team-b-name">Team B Name:</label>
                <input type="text" id="team-b-name" name="team_b_name" class="form-control" required>
            </div>
            <button type="submit" id="submit-names" class="btn btn-primary">Start Game</button>
        </form>

        <!-- Game status -->
        <div id="game-status" class="alert alert-info">Waiting for players...</div>

        <!-- Question display -->
        <div id="current-question" class="alert alert-info" style="display: none;"></div>

        <!-- Timer -->
        <div id="countdown-timer" class="alert alert-warning" style="display: none;"></div>
        
        <!-- Answer Form -->
        <form id="answer-form" method="POST" class="d-flex mb-3" style="display:none;">
            <input type="text" id="user-answer" class="form-control mr-2" placeholder="Enter your answer" required>
            <button type="submit" id="submit-answer" class="btn btn-primary">Submit Answer</button>
        </form>

        <!-- Scores -->
        <h3>Scores</h3>
        <table class="table text-center">
            <thead>
                <tr>
                    <th>Team A</th>
                    <th>Team B</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="team-a-score">0</td>
                    <td id="team-b-score">0</td>
                </tr>
            </tbody>
        </table>

        <footer>
            <a href="?logout=true" class="btn btn-danger">Logout</a>
        </footer>
    </div>
</section>

<script src="game.js"></script>
</body>
</html>
