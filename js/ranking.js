document.addEventListener("DOMContentLoaded", function() {
    const audioPlayers = document.querySelectorAll('.audio-player audio');

    audioPlayers.forEach(function(audio) {
        const audioContainer = audio.parentElement;
        const playPauseButton = audioContainer.querySelector('.play-pause-button');
        const loopButton = audioContainer.querySelector('.loop-button'); // Bouton de bouclage
        const downloadButton = audioContainer.querySelector('.download-button'); // Bouton de téléchargement
        const speedButton = audioContainer.querySelector('.speed-button');
        const progressBar = audioContainer.querySelector('.progress-bar');
        const progressBarFill = audioContainer.querySelector('.progress-bar-fill');
        const timer = audioContainer.querySelector('.timer');

        let isPlaying = false;
        let isLooping = false;

        playPauseButton.addEventListener('click', function() {
            if (isPlaying) {
                audio.pause();
            } else {
                audio.play();
            }
        });

        loopButton.addEventListener('click', function() {
            if (isLooping) {
                audio.removeAttribute('loop');
                isLooping = false;
            } else {
                audio.setAttribute('loop', 'true');
                isLooping = true;
            }
            loopButton.classList.toggle('active', isLooping);
        });

        downloadButton.addEventListener('click', function() {
            // Obtenir le lien de téléchargement depuis la source audio
            const audioSource = audio.querySelector('source');
            const audioSrc = audioSource.getAttribute('src');
            const downloadLink = document.createElement('a');
            downloadLink.href = audioSrc;
            downloadLink.download = audioSrc.split('/').pop();
            downloadLink.click();
        });

        speedButton.addEventListener('click', function() {
            const speeds = [0.5, 1.0, 1.5, 2.0];
            const currentIndex = speeds.indexOf(audio.playbackRate);
            const newIndex = (currentIndex + 1) % speeds.length;
            audio.playbackRate = speeds[newIndex];
            speedButton.textContent = speeds[newIndex] + 'x';
        });

        audio.addEventListener('play', function() {
            isPlaying = true;
            playPauseButton.textContent = '⏸';
            playPauseButton.classList.add('pulse'); // Ajout de l'animation pulse
        });

        audio.addEventListener('pause', function() {
            isPlaying = false;
            playPauseButton.textContent = '▶';
            playPauseButton.classList.remove('pulse'); // Suppression de l'animation pulse
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
    });

    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        seconds = Math.floor(seconds % 60);
        return (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
    }
});
