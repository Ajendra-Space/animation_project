<!DOCTYPE html>
<html>
<head>
    <title>Delivery Pizza Animation</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-position: 0 0;
        }

        @keyframes scrollBackground {
            0% { background-position: 0 0; }
            100% { background-position: -3000px 0; }
        }

        .foreground {
            position: absolute;
            width: 100%;
            height: 100%;
            background: url("{{ asset('images/image.jpg') }}") repeat-x bottom,
                        url("{{ asset('images/image1.jpg') }}") repeat-x bottom;
            background-size: cover;
            background-repeat: repeat-x;
            z-index: 0;
        }

        #horse {
            position: absolute;
            top: 300px;
            left: -200px;
            width: 200px;
            z-index: 2;
            display: none;
        }

        @keyframes runHorse {
            0% { left: -200px; }
            100% { left: 100%; }
        }

        #startBtn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px 40px;
            font-size: 24px;
            background: #ff6600;
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            z-index: 5;
            box-shadow: 0 0 15px rgba(0,0,0,0.4);
        }
    </style>
</head>
<body>

    <div class="foreground" id="foreground"></div>
    <img id="horse" src="{{ asset('images/horse.gif') }}" alt="Running Horse">

    <audio id="bgMusic" src="{{ asset('audio/background.mp3') }}" loop></audio>

    <button id="startBtn">Start Animation</button>

    <script>
        let horse = document.getElementById('horse');
        let foreground = document.getElementById('foreground');
        let music = document.getElementById('bgMusic');
        let startBtn = document.getElementById('startBtn');
        let speed = 5;

        let backgrounds = [
            {
                mountains: "{{ asset('images/image3.png') }}",
                ground: "{{ asset('images/image3.png') }}"
            },
            {
                mountains: "{{ asset('images/image1.jpg') }}",
                ground: "{{ asset('images/image1.jpg') }}"
            },
            {
                mountains: "{{ asset('images/image2.png') }}",
                ground: "{{ asset('images/image2.png') }}"
            }
        ];

        let bgIndex = 0;
        let speedInterval;

        startBtn.addEventListener('click', () => {
            music.play();
            startBtn.style.display = 'none';
            horse.style.display = 'block';
            horse.style.animation = `runHorse ${speed}s linear infinite`;
            document.body.style.animation = "scrollBackground 30s linear infinite";

            speedInterval = setInterval(speedUp, 3000);
        });

        function speedUp() {
            if (speed > 1) {
                speed -= 0.5;
                horse.style.animationDuration = speed + 's';
            } else {
                speed = 5;
                horse.style.animationDuration = speed + 's';
            }
        }

        horse.addEventListener('animationiteration', () => {
            bgIndex++;
            if (bgIndex < backgrounds.length) {
                let bg = backgrounds[bgIndex];
                foreground.style.backgroundImage = `url('${bg.mountains}'), url('${bg.ground}')`;
            } else {
                clearInterval(speedInterval);
                document.body.innerHTML = `<img src="{{ asset('images/thankyou.jpg') }}" style="width:100%; height:100%;">`;
            }
        });
    </script>

</body>
</html>
