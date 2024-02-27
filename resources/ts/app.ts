import "../scss/app.scss";

import videojs from "video.js";
function videoElementSetup( name :string) {
    const videoElm = document.querySelector<HTMLVideoElement>(`#${name}-js`);
    if (videoElm) {
        const player = videojs(videoElm, {
            controls: true,
            preload: "auto",
            playbackRates: [0.25, 0.5, 0.75, 1, 1.5, 2],
            LoadingSpinner: true,
            controlBar: {
                volumePanel: { inline: false },
            },
        });
        const rateInputElm = document.querySelector<HTMLInputElement>(`#${name}-rate-input`);
        if(!rateInputElm) {
            return;
        }
        player.on("ratechange", function() {
            const newRate = player.playbackRate();
            if(newRate) {
                rateInputElm.value = newRate.toString();
            } else {
                console.error('video.js error : playbackRate notfound')
            }
        });
        rateInputElm.addEventListener('input', (e) => {
            if(e.target){
                player.playbackRate(parseFloat(rateInputElm.value));
            }
        });
    }
}

videoElementSetup("video");
