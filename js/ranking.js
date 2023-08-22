document.addEventListener("DOMContentLoaded", function() {
    // Sélectionnez tous les éléments audio
    const audioPlayers = document.querySelectorAll('.audio-player audio');
    const audioContainers = document.querySelectorAll('.audio-player');

    // Créez un tableau pour stocker les objets Howler
    const audioObjects = [];

    // Parcourez chaque élément audio
    audioPlayers.forEach(function(audio, index) {
        const audioContainer = audioContainers[index];

        // Créez un objet Howler pour chaque élément audio
        const sound = new Howl({
            src: [audio.getAttribute('src')],
            html5: true, // Utilisez HTML5 pour la lecture audio
            volume: 1.0, // Volume par défaut (1.0 = 100%)
            rate: 1.0, // Taux de lecture par défaut (1.0 = normal)
            onplay: function() {
                audioContainer.classList.add('playing');
            },
            onpause: function() {
                audioContainer.classList.remove('playing');
            },
            onend: function() {
                audioContainer.classList.remove('playing');
            }
        });

        // Ajoutez l'objet Howler à la liste
        audioObjects.push(sound);

        // Ajoutez des fonctionnalités supplémentaires au lecteur audio
        const playPauseButton = audioContainer.querySelector('.play-pause-button');
        const progressBar = audioContainer.querySelector('.progress-bar');
        const progressBarFill = audioContainer.querySelector('.progress-bar-fill');
        const timer = audioContainer.querySelector('.timer');
        const speedButton = audioContainer.querySelector('.speed-button');
        const speedOptions = [0.5, 1.0, 1.5, 2.0]; // Options de vitesse
        let speedIndex = 1; // Indice de la vitesse par défaut

        // Gérez la lecture/pause du lecteur audio
        playPauseButton.addEventListener('click', function() {
            if (sound.playing()) {
                sound.pause();
            } else {
                sound.play();
            }
        });

        // Mise à jour de la barre de progression
        sound.on('play', function() {
            setInterval(function() {
                const progress = (sound.seek() / sound.duration()) * 100;
                progressBarFill.style.width = progress + '%';
                timer.textContent = formatTime(Math.floor(sound.seek()));
            }, 1000);
        });

        // Gérez le déplacement dans la piste audio en cliquant sur la barre de progression
        progressBar.addEventListener('click', function(event) {
            const boundingBox = progressBar.getBoundingClientRect();
            const mouseX = event.clientX - boundingBox.left;
            const progressPercent = (mouseX / boundingBox.width) * 100;
            const seekTime = (progressPercent / 100) * sound.duration();
            sound.seek(seekTime);
        });

        // Gérez la vitesse de lecture
        speedButton.addEventListener('click', function() {
            speedIndex = (speedIndex + 1) % speedOptions.length;
            sound.rate(speedOptions[speedIndex]);
            speedButton.textContent = 'x' + speedOptions[speedIndex];
        });
    });

    // Fonction pour formater le temps en mm:ss
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        seconds = seconds % 60;
        return (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
    }
});
