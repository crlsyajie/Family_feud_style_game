<?php
// error 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// connect database
try {
    $conn = new PDO('mysql:host=127.0.0.1:4306;dbname=familyfeud', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">Family Feud</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Leaderboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Leaderboard</h1>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th scope="col">Player 1 Name</th>
                    <th scope="col">Player 1 Score</th>
                    <th scope="col">Player 2 Name</th>
                    <th scope="col">Player 2 Score</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // query to select all columns 
                $stmt = $conn->query("SELECT * FROM scores ORDER BY created_at DESC");

                // results and displaying 
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>{$row['player1_name']}</td>
                            <td>{$row['player1_score']}</td>
                            <td>{$row['player2_name']}</td>
                            <td>{$row['player2_score']}</td>
                            <td>" . date("Y-m-d H:i:s", strtotime($row['created_at'])) . "</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>