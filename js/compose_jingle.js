let isRecording = false;
let recorder, audioContext;
let audioChunks = [];

const startButton = document.getElementById('startButton');
const stopButton = document.getElementById('stopButton');
const downloadButton = document.getElementById('downloadButton');

startButton.addEventListener('click', async () => {
    audioChunks = [];
    isRecording = true;
    startButton.disabled = true;
    stopButton.disabled = false;

    audioContext = new AudioContext();
    recorder = new MediaRecorder(audioContext.createMediaStreamDestination());

    recorder.ondataavailable = event => audioChunks.push(event.data);
    recorder.onstop = () => {
        isRecording = false;
        startButton.disabled = false;
        stopButton.disabled = true;
        downloadButton.disabled = false;
    };

    recorder.start();
});

stopButton.addEventListener('click', () => {
    if (isRecording) {
        recorder.stop();
    }
});

downloadButton.addEventListener('click', () => {
    if (audioChunks.length > 0) {
        const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
        const reader = new FileReader();

        reader.onload = async () => {
            const wavData = new Uint8Array(reader.result);
            const mp3Data = convertWavToMp3(wavData);

            const mp3Blob = new Blob([mp3Data.buffer], { type: 'audio/mp3' });
            const mp3Url = URL.createObjectURL(mp3Blob);

            const downloadLink = document.createElement('a');
            downloadLink.href = mp3Url;
            downloadLink.download = 'jingle.mp3';
            downloadLink.click();
        };

        reader.readAsArrayBuffer(audioBlob);
    }
});

function convertWavToMp3(wavData) {
    const encoder = new lamejs.Mp3Encoder(1, 44100, 128);
    const mp3Data = [];

    const samples = new Int16Array(wavData.buffer);
    const sampleBlockSize = 1152;

    for (let i = 0; i < samples.length; i += sampleBlockSize) {
        const leftChunk = samples.subarray(i, i + sampleBlockSize);
        const mp3Buffer = encoder.encodeBuffer(leftChunk);
        if (mp3Buffer.length > 0) {
            mp3Data.push(new Int8Array(mp3Buffer));
        }
    }

    const mp3Buffer = encoder.flush();
    if (mp3Buffer.length > 0) {
        mp3Data.push(new Int8Array(mp3Buffer));
    }

    const result = new Uint8Array(mp3Data.reduce((acc, chunk) => acc.concat(Array.from(chunk)), []));
    return result;
}
