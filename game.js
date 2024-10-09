let questions = [
    "What is something you bring to a party?",
    "Name a popular pet",
    "Name a common household item",
    "What is something you do before going to bed?",
    "Name a fast food restaurant"
];

let correctAnswers = [
    ["food", "drink", "snacks", "gift"],
    ["dog", "cat", "fish", "bird"],
    ["table", "chair", "sofa", "lamp"],
    ["brush teeth", "read", "shower", "set alarm"],
    ["mcdonald's", "burger king", "kfc", "wendy's"]
];

let currentQuestion = 0;
let player1Score = 0;
let player2Score = 0;

const questionElement = document.getElementById('question');
const startBtn = document.getElementById('start-btn');
const buzzerBtn = document.getElementById('buzzer-btn');
const player1Btn = document.getElementById('player1-btn');
const player2Btn = document.getElementById('player2-btn');
const answerInput = document.getElementById('answer');
const submitAnswerBtn = document.getElementById('submit-answer');
const passBtn = document.getElementById('pass-btn');
const timerElement = document.getElementById('timer');
const player1NameInput = document.getElementById('player1-name');
const player2NameInput = document.getElementById('player2-name');
const player1ScoreElement = document.getElementById('player1-score');
const player2ScoreElement = document.getElementById('player2-score');
const player1NameDisplay = document.getElementById('player1-name-display');
const player2NameDisplay = document.getElementById('player2-name-display');
let selectedPlayer = null;
let timerInterval;

// Initially disable the buzzer button
buzzerBtn.disabled = true;

// Start Game
startBtn.addEventListener('click', () => {
    const player1Name = player1NameInput.value.trim();
    const player2Name = player2NameInput.value.trim();
    
    if (!player1Name || !player2Name) {
        alert('Please enter names for both players.');
        return;
    }
    
    player1NameDisplay.innerText = player1Name;
    player2NameDisplay.innerText = player2Name;
    
    buzzerBtn.disabled = false; 
    getRandomQuestion(); 
    resetGameUI();

    // Disable the start button after the game starts
    startBtn.disabled = true; 
});

// Buzzer Functionality
buzzerBtn.addEventListener('click', () => {
    new Audio('buzzer-sound.mp3').play();
    new bootstrap.Modal(document.getElementById('playerModal')).show();
});

// Select Player
player1Btn.addEventListener('click', () => selectPlayer(1));
player2Btn.addEventListener('click', () => selectPlayer(2));

function selectPlayer(player) {
    selectedPlayer = player;
    answerInput.disabled = false;
    submitAnswerBtn.disabled = false;
    passBtn.disabled = false;
    startTimer();
}

// Timer
function startTimer() {
    let timeRemaining = 15;
    timerElement.innerText = timeRemaining;
    
    clearInterval(timerInterval);
    timerInterval = setInterval(() => {
        timeRemaining--;
        timerElement.innerText = timeRemaining;
        if (timeRemaining <= 0) {
            clearInterval(timerInterval);
            checkAnswer(); 
        }
    }, 1000);
}

// Checker
submitAnswerBtn.addEventListener('click', checkAnswer);

function checkAnswer() {
    let answer = answerInput.value.toLowerCase();
    let possibleAnswers = correctAnswers[currentQuestion].map(ans => ans.toLowerCase());
    
    if (possibleAnswers.includes(answer)) {
        if (selectedPlayer === 1) {
            player1Score += 10;
            player1ScoreElement.innerText = player1Score;
        } else {
            player2Score += 10;
            player2ScoreElement.innerText = player2Score;
        }

        if (player1Score >= 30 || player2Score >= 30) {
            const winnerName = selectedPlayer === 1 ? player1NameDisplay.innerText : player2NameDisplay.innerText;
            document.getElementById('winnerMessage').innerText = `${winnerName} wins the game!`;
            new bootstrap.Modal(document.getElementById('winnerModal')).show();
            insertScoreIntoDatabase();
        }
    } else {
        alert('Wrong answer!');
    }

    resetGame();
    getRandomQuestion(); 
}

// pass
passBtn.addEventListener('click', () => {
    getRandomQuestion();
    answerInput.value = '';
    clearInterval(timerInterval); 
    resetGameUI(); 
});

// random question
function getRandomQuestion() {
    currentQuestion = Math.floor(Math.random() * questions.length);
    questionElement.innerText = questions[currentQuestion]; 
}

// Reset 
function resetGame() {
    answerInput.value = '';
    answerInput.disabled = true;
    submitAnswerBtn.disabled = true;
    passBtn.disabled = true;
    clearInterval(timerInterval);
}

// Reset UI elements for the next round
function resetGameUI() {
    answerInput.disabled = true;
    submitAnswerBtn.disabled = true;
    passBtn.disabled = true;
    timerElement.innerText = '15'; 
}

// Insert scores and player names into the database via AJAX
function insertScoreIntoDatabase() {
    const player1Name = player1NameDisplay.innerText;
    const player2Name = player2NameDisplay.innerText;
    
    fetch('game.php', {
        method: 'POST',
        body: JSON.stringify({
            player1Name: player1Name,
            player2Name: player2Name,
            player1Score: player1Score,
            player2Score: player2Score
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log('Scores and names successfully saved to the database.');
        }
    });
}

// music element
const music = document.getElementById('background-music');
const musicToggleButton = document.getElementById('music-toggle-btn');

// mute/unmute music
function toggleMusic() {
    if (music.muted) {
        music.muted = false;
        musicToggleButton.innerText = "Mute Music";
    } else {
        music.muted = true;
        musicToggleButton.innerText = "Unmute Music";
    }
}


