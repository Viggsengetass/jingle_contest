let isRecording = false;
let audioChunks = [];
let mediaRecorder;

const startButton = document.getElementById('startButton');
const stopButton = document.getElementById('stopButton');
const downloadLink = document.getElementById('downloadLink');

startButton.addEventListener('click', () => {
    isRecording = true;
    startButton.disabled = true;
    stopButton.disabled = false;
    downloadLink.style.display = 'none';
    audioChunks = [];

    navigator.mediaDevices.getUserMedia({ audio: true })
        .then(stream => {
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = event => {
                if (event.data.size > 0) {
                    audioChunks.push(event.data);
                }
            };

            mediaRecorder.onstop = () => {
                isRecording = false;
                startButton.disabled = false;
                stopButton.disabled = true;
                downloadLink.style.display = 'block';

                const audioBlob = new Blob(audioChunks, { type: 'audio/mp3' }); // Modification ici pour le format MP3
                const audioUrl = URL.createObjectURL(audioBlob);
                downloadLink.href = audioUrl;
                downloadLink.download = 'jingle.mp3'; // Modifier ici le nom du fichier si nécessaire
            };

            mediaRecorder.start();
        })
        .catch(error => {
            console.error('Erreur lors de la récupération de l\'accès au microphone:', error);
        });
});

stopButton.addEventListener('click', () => {
    if (isRecording && mediaRecorder) {
        mediaRecorder.stop();
    }
});
