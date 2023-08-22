<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $melodies = json_decode($_POST['melodies']);

    // Chemin pour le fichier WAV temporaire
    $tempWavFile = 'temp.wav';

    // Création d'un fichier WAV avec Tone.js
    $wavData = base64_decode($melodies->data);
    file_put_contents($tempWavFile, $wavData);

    // Chemin pour le fichier MP3 de sortie
    $outputMp3File = 'output.mp3';

    // Conversion du fichier WAV en MP3 en utilisant FFmpeg
    // Assurez-vous que FFmpeg est installé sur votre serveur
    $ffmpegPath = 'ffmpeg'; // Chemin par défaut
    $ffmpegCommand = "$ffmpegPath -i $tempWavFile -codec:a libmp3lame -q:a 2 $outputMp3File";
    exec($ffmpegCommand);

    // Nettoyage du fichier WAV temporaire
    unlink($tempWavFile);

    // Envoi du fichier MP3 en téléchargement
    header('Content-Type: audio/mpeg');
    header('Content-Disposition: attachment; filename="jingle.mp3"');
    readfile($outputMp3File);

    // Nettoyage du fichier MP3 de sortie
    unlink($outputMp3File);

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Composition de Jingle</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tone/14.8.26/Tone.js"></script>
</head>
<body>
<h1>Composition de Jingle</h1>
<button id="startButton">Démarrer la Composition</button>
<button id="stopButton" disabled>Arrêter la Composition</button>
<button id="downloadButton" disabled>Télécharger le Jingle (MP3)</button>

<script>
    let isRecording = false;
    let recorder, audioContext;

    // Lorsque le bouton "Démarrer la Composition" est cliqué
    document.getElementById('startButton').addEventListener('click', async () => {
        // Initialisation de l'audioContext
        audioContext = new AudioContext();

        // Création d'un enregistreur audio
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        recorder = new MediaRecorder(stream);

        // Tableau pour stocker les données de l'enregistrement
        const chunks = [];

        recorder.ondataavailable = event => chunks.push(event.data);

        // Lorsque l'enregistreur est arrêté
        recorder.onstop = () => {
            const blob = new Blob(chunks, { type: 'audio/wav' });
            const reader = new FileReader();

            reader.onload = async () => {
                const base64Data = reader.result.split(',')[1];

                // Envoyer les données de l'enregistrement au serveur
                const response = await fetch('composer.php', {
                    method: 'POST',
                    body: JSON.stringify({ melodies: { data: base64Data } }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                // Activer le bouton de téléchargement si la conversion est terminée
                if (response.ok) {
                    document.getElementById('downloadButton').disabled = false;
                }
            };

            reader.readAsDataURL(blob);
        };

        // Commencer l'enregistrement
        recorder.start();
        isRecording = true;

        // Désactiver le bouton "Démarrer la Composition" et activer le bouton "Arrêter la Composition"
        document.getElementById('startButton').disabled = true;
        document.getElementById('stopButton').disabled = false;
    });

    // Lorsque le bouton "Arrêter la Composition" est cliqué
    document.getElementById('stopButton').addEventListener('click', () => {
        if (isRecording) {
            // Arrêter l'enregistrement
            recorder.stop();
            isRecording = false;

            // Désactiver le bouton "Arrêter la Composition"
            document.getElementById('stopButton').disabled = true;
        }
    });

    // Lorsque le bouton "Télécharger le Jingle" est cliqué
    document.getElementById('downloadButton').addEventListener('click', () => {
        // Télécharger le jingle converti en MP3 depuis le serveur
        window.location.href = 'composer.php';
    });
</script>
</body>
</html>
