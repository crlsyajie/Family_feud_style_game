<?php
// Start session for player details
session_start();

// Database connection
$host = '127.0.0.1:4306';
$dbname = 'game_scores';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Handle player score submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['player_name'], $_POST['score'])) {
    $playerName = $_POST['player_name'];
    $score = $_POST['score'];

    if (!empty($playerName) && !empty($score)) {
        $stmt = $pdo->prepare("INSERT INTO scores (player_name, score) VALUES (?, ?)");
        $stmt->execute([$playerName, $score]);
        echo "Score saved successfully!";
    } else {
        echo "Please provide valid input.";
    }
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

// Fetch leaderboard data
$leaderboardQuery = $pdo->query("SELECT player_name, score, game_date FROM scores ORDER BY score DESC LIMIT 10");
$leaderboard = $leaderboardQuery->fetchAll(PDO::FETCH_ASSOC);
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
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Rules</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Leaderboard</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="container mt-4">
    <h2>Game Introduction</h2>
    <p>The Family Feud Game is a fun way to test your knowledge of popular survey questions. Players will have a chance to guess answers that are most frequently given by a group of people, and points are awarded based on the popularity of the answers.</p>
    
    <div id="game-container" class="p-4" style="max-width: 800px; margin: auto;">
        <h2>Game Setup</h2>

        <div id="current-question" class="alert alert-info" style="display: none;"></div> <!-- Question display -->
        
        <!-- Leaderboard Table -->
        <h3>Leaderboard</h3>
        <table class="table score-table text-center">
            <thead>
                <tr>
                    <th>Player Name</th>
                    <th>Score</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaderboard as $entry): ?>
                    <tr>
                        <td><?= htmlspecialchars($entry['player_name']) ?></td>
                        <td><?= htmlspecialchars($entry['score']) ?></td>
                        <td><?= htmlspecialchars($entry['game_date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Answer Form -->
        <form id="answer-form" method="POST" class="d-flex mb-3">
            <input type="text" id="user-answer" class="form-control mr-2" placeholder="Enter your answer" required>
            <button type="submit" id="submit-answer" class="btn btn-primary">Submit Answer</button>
        </form>

        <footer>
            <h3 id="game-status">Game Over!</h3>
            <button id="start-game" class="btn btn-primary">Start Game</button>
            <a href="?logout=true" class="btn btn-danger">Logout</a>
        </footer>
    </div>
</section>

<script src="game.js"></script>
</body>
</html>
