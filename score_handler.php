<?php
session_start();
include 'db.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playerName = sanitizeInput($_POST['player-name']);
    $score = (int)$_POST['score'];

    $stmt = $conn->prepare("INSERT INTO scores (player_name, score) VALUES (?, ?)");
    $stmt->bind_param("si", $playerName, $score);
    
    if ($stmt->execute()) {
        echo "Score recorded successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}


function getLeaderboard($conn) {
    $sql = "SELECT player_name, score FROM scores ORDER BY score DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Leaderboard</h2><ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . $row["player_name"] . ": " . $row["score"] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No scores found.";
    }
}

getLeaderboard($conn);


closeConnection($conn);
?>
