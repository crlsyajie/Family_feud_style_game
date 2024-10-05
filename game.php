<?php
// error handling
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// database connection
try {
    $conn = new PDO('mysql:host=127.0.0.1:4306;dbname=familyfeud', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Handle POST request to store scores and player names
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['player1Name'], $data['player2Name'], $data['player1Score'], $data['player2Score'])) {
        // Capture player names and scores from the incoming request
        $player1Name = $data['player1Name'];
        $player2Name = $data['player2Name'];
        $player1Score = $data['player1Score'];
        $player2Score = $data['player2Score'];

        // Prepare the SQL statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO scores (player1_name, player1_score, player2_name, player2_score) 
                                VALUES (:player1Name, :player1Score, :player2Name, :player2Score)");

        // Execute the statement with the provided data
        $stmt->execute([
            'player1Name' => $player1Name,
            'player1Score' => $player1Score,
            'player2Name' => $player2Name,
            'player2Score' => $player2Score
        ]);

        // Return a success response
        echo json_encode(['status' => 'success']);
    } else {
        // Return an error if data is missing
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
    }
}
?>