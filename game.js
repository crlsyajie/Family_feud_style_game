let questions = [
    { question: "Name a popular pet.", answers: ["Dog", "Cat", "Fish", "Bird"] },
    { question: "Name a fruit.", answers: ["Apple", "Banana", "Orange", "Grape"] },
    { question: "Name a color.", answers: ["Red", "Blue", "Green", "Yellow"] }
];

let currentQuestionIndex = 0;
let totalRounds = questions.length;
let roundNumber = 1;
let countdownTime;
let scoreA = 0;
let scoreB = 0;

document.getElementById('start-game').addEventListener('click', startGame);
document.getElementById('answer-form').addEventListener('submit', submitAnswer);

function startGame() {
    document.getElementById('game-status').innerText = 'Game In Progress';
    document.getElementById('game-status').style.color = 'green';
    roundNumber = 1;
    scoreA = 0;
    scoreB = 0;
    updateScores();
    nextRound();
}

function nextRound() {
    if (roundNumber > totalRounds) {
        endGame();
        return;
    }

    const currentQuestion = questions[currentQuestionIndex];
    document.getElementById('current-question').innerText = currentQuestion.question;
    document.getElementById('current-question').style.display = 'block';

    countdownTime = 30; 
    document.getElementById('countdown-timer').style.display = 'block';
    document.getElementById('countdown-timer').innerText = `Time left: ${countdownTime}s`;

    startCountdown();
}

function startCountdown() {
    const timer = setInterval(() => {
        countdownTime--;
        document.getElementById('countdown-timer').innerText = `Time left: ${countdownTime}s`;

        if (countdownTime <= 0) {
            clearInterval(timer);
            document.getElementById('current-question').style.display = 'none';
            alert("Time's up! No answer submitted.");
            currentQuestionIndex++;
            roundNumber++;
            nextRound();
        }
    }, 1000);
}

function submitAnswer(e) {
    e.preventDefault();
    const answer = document.getElementById('user-answer').value.toLowerCase();
    const currentQuestion = questions[currentQuestionIndex];

    if (currentQuestion.answers.map(a => a.toLowerCase()).includes(answer)) {
        alert("Correct answer!");
        if (roundNumber % 2 === 1) {
            scoreA += 10;
        } else {
            scoreB += 10;
        }
        updateScores();
    } else {
        alert("Incorrect answer.");
    }

    document.getElementById('user-answer').value = '';
    currentQuestionIndex++;
    roundNumber++;
    nextRound();
}

function updateScores() {
    document.getElementById('team-a-score').innerText = scoreA;
    document.getElementById('team-b-score').innerText = scoreB;
}

function endGame() {
    document.getElementById('game-status').innerText = 'Game Over!';
    document.getElementById('current-question').style.display = 'none';
    alert("Final scores - Team A: " + scoreA + ", Team B: " + scoreB);
}