let questions = [
    { question: "Name a popular pet.", answers: ["Dog", "Cat", "Fish", "Bird"] },
    { question: "Name a fruit.", answers: ["Apple", "Banana", "Orange", "Grape"] },
    { question: "Name a color.", answers: ["Red", "Blue", "Green", "Yellow"] }
];

let currentQuestionIndex = 0;
let scoreA = 0;
let scoreB = 0;
let countdownTime = 30; // Initial time for each round
let timer; // Variable to store the timer
const targetScore = 100; // Score needed to win
let gameEnded = false; // Flag to track if the game has ended

document.getElementById('submit-names').addEventListener('click', startGame);
document.getElementById('answer-form').addEventListener('submit', submitAnswer);

function startGame(e) {
    e.preventDefault();
    const teamAName = document.getElementById('team-a-name').value;
    const teamBName = document.getElementById('team-b-name').value;

    // Store team names in session
    sessionStorage.setItem('team_a_name', teamAName);
    sessionStorage.setItem('team_b_name', teamBName);
    
    document.getElementById('game-status').innerText = 'Game In Progress';
    document.getElementById('game-status').style.color = 'green';
    document.getElementById('team-names-form').style.display = 'none'; // Hide team names form
    document.getElementById('answer-form').style.display = 'block'; // Show answer form
    scoreA = 0;
    scoreB = 0;
    updateScores();
    nextRound();
}

function nextRound() {
    if (gameEnded) return; // Prevent continuing if the game has already ended

    // Check if either team has reached the target score
    if (scoreA >= targetScore || scoreB >= targetScore) {
        endGame();
        return;
    }

    // Check if there are still questions left
    if (currentQuestionIndex >= questions.length) {
        currentQuestionIndex = 0; // Reset questions to loop again
    }

    const currentQuestion = questions[currentQuestionIndex];
    document.getElementById('current-question').innerText = currentQuestion.question;
    document.getElementById('current-question').style.display = 'block';

    countdownTime = 10; // Reset countdown time for each round
    document.getElementById('countdown-timer').style.display = 'block';
    startCountdown();
}

function startCountdown() {
    timer = setInterval(() => {
        countdownTime--;
        document.getElementById('countdown-timer').innerText = `Time left: ${countdownTime}s`;

        if (countdownTime <= 0) {
            clearInterval(timer);
            determineWinner(); // Determine the winner when time is up
        }
    }, 1000);
}

function submitAnswer(e) {
    e.preventDefault();
    const answer = document.getElementById('user-answer').value.toLowerCase();
    const currentQuestion = questions[currentQuestionIndex];

    // Check for a correct answer
    if (currentQuestion.answers.map(a => a.toLowerCase()).includes(answer)) {
        alert("Correct answer!");
        if (currentQuestionIndex % 2 === 0) {
            scoreA += 10; // Team A scores
        } else {
            scoreB += 10; // Team B scores
        }
        updateScores();
    } else {
        alert("Incorrect answer.");
    }

    // Pause the timer after an answer
    clearInterval(timer);
    document.getElementById('user-answer').value = '';
    currentQuestionIndex++;
    nextRound(); // Move to the next round
}

function updateScores() {
    document.getElementById('team-a-score').innerText = scoreA;
    document.getElementById('team-b-score').innerText = scoreB;
}

function determineWinner() {
    if (gameEnded) return; // Prevent multiple triggers

    clearInterval(timer);
    gameEnded = true; // Mark game as ended

    let winnerMessage;

    if (scoreA >= targetScore) {
        winnerMessage = "Team A wins!";
    } else if (scoreB >= targetScore) {
        winnerMessage = "Team B wins!";
    } else {
        winnerMessage = "Time's up! Final scores - Team A: " + scoreA + ", Team B: " + scoreB;
    }

    // Insert final scores into the leaderboard
    document.getElementById('game-status').innerText = winnerMessage;
    document.getElementById('current-question').style.display = 'none';
    alert(winnerMessage);

    // Post to the server to save the winner in the leaderboard
    const formData = new FormData();
    formData.append('team_a_score', scoreA);
    formData.append('team_b_score', scoreB);

    fetch('index.php', {
        method: 'POST',
        body: formData,
    }).then(response => response.text())
      .then(data => {
          console.log(data); // Show success message in console
          // Redirect to the leaderboard after successful database insertion
          window.location.href = 'leaderboard.php'; 
      });
}

function endGame() {
    if (gameEnded) return; // Prevent re-executing end game logic

    gameEnded = true; // Set the game as ended
    clearInterval(timer);
    document.getElementById('game-status').innerText = 'Game Over!';
    document.getElementById('current-question').style.display = 'none';
    alert("Final scores - Team A: " + scoreA + ", Team B: " + scoreB);

    determineWinner(); // Ensure winner logic and database insert are called
}
