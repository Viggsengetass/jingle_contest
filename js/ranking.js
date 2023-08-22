document.addEventListener("DOMContentLoaded", function() {
    const audioPlayers = document.querySelectorAll('.audio-player audio');
    audioPlayers.forEach(function(audio) {
        const audioContainer = audio.parentElement;
        const playPauseButton = audioContainer.querySelector('.play-pause-button');
        const progressBar = audioContainer.querySelector('.progress-bar');
        const progressBarFill = audioContainer.querySelector('.progress-bar-fill');
        const timer = audioContainer.querySelector('.timer');
        const speedButton = audioContainer.querySelector('.speed-button');
        let isPlaying = false;
        playPauseButton.addEventListener('click', function() {
            if (isPlaying) {
                audio.pause();
            } else {
                audio.play();
            }
        });
        audio.addEventListener('play', function() {
            isPlaying = true;
            playPauseButton.textContent = '⏸';
        });
        audio.addEventListener('pause', function() {
            isPlaying = false;
            playPauseButton.textContent = '▶';
        });
        audio.addEventListener('timeupdate', function() {
            const currentTime = audio.currentTime;
            const duration = audio.duration;
            const progress = (currentTime / duration) * 100;
            progressBarFill.style.width = progress + '%';
            timer.textContent = formatTime(currentTime);
        });
        progressBar.addEventListener('click', function(e) {
            const boundingBox = progressBar.getBoundingClientRect();
            const mouseX = e.clientX - boundingBox.left;
            const progressPercent = (mouseX / boundingBox.width) * 100;
            const seekTime = (progressPercent / 100) * audio.duration;
            audio.currentTime = seekTime;
        });
        let playbackSpeedIndex = 1;
        const playbackSpeeds = [0.5, 1.0, 1.5, 2.0];
        speedButton.addEventListener('click', function() {
            playbackSpeedIndex = (playbackSpeedIndex + 1) % playbackSpeeds.length;
            audio.playbackRate = playbackSpeeds[playbackSpeedIndex];
            speedButton.textContent = playbackSpeeds[playbackSpeedIndex] + 'x';
        });
    });
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        seconds = Math.floor(seconds % 60);
        return (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
    }
});