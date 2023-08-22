<<<<<<< HEAD
document.addEventListener("DOMContentLoaded", function () {
    const audioPlayers = document.querySelectorAll(".audio-player");

    audioPlayers.forEach((player) => {
        const audio = player.querySelector("audio");
        const playPauseButton = player.querySelector(".play-pause-button");
        const progressBar = player.querySelector(".audio-progress-bar");
        const audioTimer = player.querySelector(".audio-timer");
        const loopButton = player.querySelector(".loop-button");

        let isPlaying = false;

        playPauseButton.addEventListener("click", () => {
            if (isPlaying) {
                audio.pause();
                playPauseButton.textContent = "▶";
            } else {
                audio.play();
                playPauseButton.textContent = "⏸";
=======
document.addEventListener("DOMContentLoaded", function() {
    // Sélectionnez tous les éléments audio
    const audioPlayers = document.querySelectorAll('.audio-player audio');

    // Sélectionnez tous les boutons de lecture/pause personnalisés
    const playPauseButtons = document.querySelectorAll('.play-pause-button');

    // Ajoutez un gestionnaire de clic à chaque bouton de lecture/pause
    playPauseButtons.forEach(function(button, index) {
        const audio = audioPlayers[index];
        const audioContainer = audio.parentElement;

        button.addEventListener('click', function() {
            if (audio.paused) {
                audio.play();
                audioContainer.classList.add('playing');
            } else {
                audio.pause();
                audioContainer.classList.remove('playing');
>>>>>>> parent of b402809 (add_functions)
            }
            isPlaying = !isPlaying;
        });
<<<<<<< HEAD

        audio.addEventListener("timeupdate", () => {
            const currentTime = audio.currentTime;
            const duration = audio.duration;
            const progressBarWidth = (currentTime / duration) * 100;
            progressBar.style.width = progressBarWidth + "%";

            const minutes = Math.floor(currentTime / 60);
            const seconds = Math.floor(currentTime % 60);
            audioTimer.textContent = `${minutes}:${seconds}`;
        });

        progressBar.addEventListener("click", (e) => {
            const progressBarRect = progressBar.getBoundingClientRect();
            const clickX = e.clientX - progressBarRect.left;
            const progressBarWidth = progressBarRect.width;
            const seekTime = (clickX / progressBarWidth) * audio.duration;
            audio.currentTime = seekTime;
        });

        loopButton.addEventListener("click", () => {
            audio.loop = !audio.loop;
            if (audio.loop) {
                loopButton.style.backgroundColor = "#0056b3";
            } else {
                loopButton.style.backgroundColor = "#007bff";
            }
        });
    });
=======
    });

    // Ajoutez un gestionnaire d'événement pour mettre à jour le bouton de lecture en fonction de l'état de lecture
    audioPlayers.forEach(function(audio, index) {
        const audioContainer = audio.parentElement;
        const playPauseButton = audioContainer.querySelector('.play-pause-button');

        audio.addEventListener('play', function() {
            playPauseButton.textContent = "\u23F8"; // Icône de pause (carré)
        });

        audio.addEventListener('pause', function() {
            playPauseButton.textContent = "\u25B6"; // Icône de lecture (triangle droit)
        });

        audio.addEventListener('ended', function() {
            playPauseButton.textContent = "\u25B6"; // Réinitialise l'icône de lecture à la fin de la piste
        });
    });

    // Ajoutez des animations au survol des lignes du tableau
    const tableRows = document.querySelectorAll('.table tbody tr');
    tableRows.forEach(function(row) {
        row.addEventListener('mouseenter', function() {
            row.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
        });

        row.addEventListener('mouseleave', function() {
            row.style.backgroundColor = 'transparent';
        });
    });

    // Ajoutez une animation au titre principal
    const title = document.querySelector('h1');
    title.addEventListener('mouseenter', function() {
        title.style.fontSize = '40px';
    });

    title.addEventListener('mouseleave', function() {
        title.style.fontSize = '36px';
    });
>>>>>>> parent of b402809 (add_functions)
});
