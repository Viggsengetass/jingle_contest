// Importez la bibliothèque Tone.js en tant que module ES6
import * as Tone from 'tone';

// Définissez les paramètres de la synthétiseur et des effets
const synth = new Tone.Synth({
    oscillator: {
        type: 'sine', // Type d'onde (vous pouvez le changer)
    },
    envelope: {
        attack: 0.1,
        decay: 0.2,
        sustain: 0.3,
        release: 0.5,
    },
}).toDestination();

// Créez un objet Pattern pour stocker les notes
const melodyPattern = new Tone.Pattern(
    (time, note) => {
        synth.triggerAttackRelease(note, '4n', time);
    },
    ['C4', 'D4', 'E4', 'F4'], // Vous pouvez changer ces notes
    'up'
);

// Bouton de démarrage
const startButton = document.getElementById('startButton');
startButton.addEventListener('click', () => {
    // Démarrer la synthétisation de la mélodie
    Tone.Transport.start();
    melodyPattern.start();
});

// Bouton d'arrêt
const stopButton = document.getElementById('stopButton');
stopButton.addEventListener('click', () => {
    // Arrêter la synthétisation de la mélodie
    Tone.Transport.stop();
    melodyPattern.stop();
});

// Bouton de réinitialisation
const resetButton = document.getElementById('resetButton');
resetButton.addEventListener('click', () => {
    // Réinitialiser la synthétisation de la mélodie
    melodyPattern.stop();
    melodyPattern.start();
});

// Bouton de téléchargement
const downloadButton = document.getElementById('downloadButton');
downloadButton.addEventListener('click', async () => {
    // Obtenir la séquence audio générée
    const audioBuffer = await Tone.Offline(() => {
        melodyPattern.start(0);
        Tone.Transport.start(0);
    }, melodyPattern.length);

    // Créer un fichier WAV à partir de la séquence audio
    const audioBlob = new Blob([audioBuffer], { type: 'audio/wav' });
    const audioUrl = URL.createObjectURL(audioBlob);

    // Créer un lien de téléchargement
    const downloadLink = document.createElement('a');
    downloadLink.href = audioUrl;
    downloadLink.download = 'jingle.wav';
    downloadLink.click();
});

// Bouton de réinitialisation de la mélodie
const resetButton = document.getElementById('resetButton');
resetButton.addEventListener('click', () => {
    melodyPattern.stop();
    melodyPattern.start();
});
