<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Composition de Jingle</title>
    <?php include 'common.php'; ?>
    <link rel="stylesheet" href="/style/compose_jingle.css">
</head>
<body>
<h1>Composition de Jingle</h1>
<button id="startButton">Démarrer la Composition</button>
<button id="stopButton" disabled>Arrêter la Composition</button>
<button id="downloadButton" disabled>Télécharger le Jingle (MP3)</button>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tone/14.8.26/Tone.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lamejs/1.2.0/lame.min.js"></script>
<script src="/js/compose_jingle.js"></script>
</body>
</html>
