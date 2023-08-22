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
            }
            isPlaying = !isPlaying;
        });

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
});
