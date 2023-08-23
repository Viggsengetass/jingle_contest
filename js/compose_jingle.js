let isRecording = false;
let audioChunks = [];
let mediaRecorder;
let audioStream;
let audioContext;
let mp3Data = [];

const startButton = document.getElementById('startButton');
const stopButton = document.getElementById('stopButton');
const downloadLink = document.getElementById('downloadLink');

startButton.addEventListener('click', async () => {
    isRecording = true;
    startButton.disabled = true;
    stopButton.disabled = false;
    downloadLink.style.display = 'none';
    audioChunks = [];
    mp3Data = [];

    audioContext = new (window.AudioContext || window.webkitAudioContext)();
    audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });
    mediaRecorder = new MediaRecorder(audioStream);

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

        const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });

        const reader = new FileReader();
        reader.onload = async () => {
            const wavData = new Uint8Array(reader.result);
            convertWavToMp3(wavData, (mp3Array) => {
                mp3Data = new Uint8Array(mp3Array);
                const mp3Blob = new Blob([mp3Data], { type: 'audio/mp3' });
                const mp3Url = URL.createObjectURL(mp3Blob);
                downloadLink.href = mp3Url;
                downloadLink.download = 'jingle.mp3';
            });
        };
        reader.readAsArrayBuffer(audioBlob);
    };

    mediaRecorder.start();
});

stopButton.addEventListener('click', () => {
    if (isRecording && mediaRecorder) {
        mediaRecorder.stop();
        audioStream.getTracks().forEach(track => track.stop());
    }
});

function convertWavToMp3(wavData, callback) {
    const encoder = new lamejs.Mp3Encoder(1, audioContext.sampleRate, 128);
    const samples = new Int16Array(wavData.buffer);

    const mp3Data = [];

    for (let i = 0; i < samples.length; i += 1152) {
        const leftChunk = samples.subarray(i, i + 1152);
        const mp3buf = encoder.encodeBuffer(leftChunk);
        if (mp3buf.length > 0) {
            mp3Data.push(new Int8Array(mp3buf));
        }
    }

    const mp3buf = encoder.flush();
    if (mp3buf.length > 0) {
        mp3Data.push(new Int8Array(mp3buf));
    }

    const result = new Uint8Array(mp3Data.reduce((acc, chunk) => acc.concat(Array.from(chunk)), []));
    callback(result);
}
