let isRecording = false;
let audioChunks = [];
let mediaRecorder;
let audioContext;

const startButton = document.getElementById('startButton');
const stopButton = document.getElementById('stopButton');
const downloadLink = document.getElementById('downloadLink');

startButton.addEventListener('click', async () => {
    isRecording = true;
    startButton.disabled = true;
    stopButton.disabled = false;
    downloadLink.style.display = 'none';
    audioChunks = [];

    audioContext = new AudioContext();
    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
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

        const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
        const audioBuffer = await audioBlob.arrayBuffer();

        // Convertir audio WAV en MP3
        const mp3Data = await convertWavToMp3(audioBuffer);

        const mp3Blob = new Blob([mp3Data], { type: 'audio/mp3' });
        const mp3Url = URL.createObjectURL(mp3Blob);
        downloadLink.href = mp3Url;
        downloadLink.download = 'jingle.mp3';
    };

    mediaRecorder.start();
});

stopButton.addEventListener('click', () => {
    if (isRecording && mediaRecorder) {
        mediaRecorder.stop();
        audioContext.close();
    }
});

async function convertWavToMp3(wavData) {
    const audioBuffer = await audioContext.decodeAudioData(wavData);
    const mp3Encoder = new lamejs.Mp3Encoder(1, audioBuffer.sampleRate, 128);
    const leftData = audioBuffer.getChannelData(0);
    const mp3Data = [];

    for (let i = 0; i < leftData.length; i += 1152) {
        const leftChunk = leftData.subarray(i, i + 1152);
        const mp3buf = mp3Encoder.encodeBuffer(leftChunk);
        if (mp3buf.length > 0) {
            mp3Data.push(new Int8Array(mp3buf));
        }
    }

    const mp3buf = mp3Encoder.flush();
    if (mp3buf.length > 0) {
        mp3Data.push(new Int8Array(mp3buf));
    }

    const result = new Uint8Array(mp3Data.reduce((acc, chunk) => acc.concat(Array.from(chunk)), []));
    return result;
}
