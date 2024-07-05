// https://codepen.io/matteobruni/pen/BaOLEqW

import { tsParticles } from "https://cdn.jsdelivr.net/npm/@tsparticles/engine@3.0.3/+esm";
import { loadFull } from "https://cdn.jsdelivr.net/npm/tsparticles@3.0.3/+esm";

const yeahbutton = document.getElementById("yeahbutton");

async function loadParticles(options) {
    await loadFull(tsParticles);

    return await tsParticles.load({ options });
}

const configs = {
    fullScreen: {
        zIndex: -30
    },
    particles: {
        move: {
            angle: {
                value: 30
            },
            enable: true,
            direction: "top",
            outModes: "destroy",
        },
        shape: {
            type: "image",
            options: {
                image: {
                    src:
                        "https://res.cloudinary.com/browntulstar/image/private/s--tnUWgV2B--/ar_1:1,c_scale,w_400/f_webp/com.browntulstar/img/browntulstar-avatar-v1-1.png",
                    width: 256,
                    height: 256
                }
            }
        },
        size: {
            value: 32
        }
    }
};

loadParticles(configs).then((container) => {
    //   const rect = yeahbutton.getBoundingClientRect();

    yeahbutton.addEventListener("click", (e) => {
        container.particles.addParticle({
            x: e.clientX,
            y: e.clientY
        });
    });
});