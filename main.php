<!-- Coleman DeMars -->
<!-- https://coderbyte.com/question/php-application-4t4xvlj062#comment_userbtwiq195f -->
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>Calculator</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<meta charset="UTF-8">
	</head>
	<body>
        <div class="container">
            <div class="result">
                <p><span id="result"></span></p>
            </div>
            <div class="buttons">
                <button class="button action-btn" onclick="displayValue('\(')">(</button>
                <button class="button action-btn" onclick="displayValue('\)')">)</button>
                <button class="button action-btn" onclick="displayValue('\%')">%</button>
                <button class="button calc-btn" onclick="displayValue('')">AC</button>

                <button class="button Seven" onclick="displayValue('7')" >7</button>
                <button class="button eight" onclick="displayValue('8')">8</button>
                <button class="button nine" onclick="displayValue('9')">9</button>
                 <button class="button calc-btn divide" onclick="displayValue('\/')">&#247;</button>

                <button class="button four" onclick="displayValue('4')">4</button>
                <button class="button five" onclick="displayValue('5')">5</button>
                <button class="button six" onclick="displayValue('6')">6</button>
                <button class="button calc-btn" onclick="displayValue('x')">X</button>
                
                <button class="button one" onclick="displayValue('1')">1</button>
                <button class="button two" onclick="displayValue('2')">2</button>
                <button class="button three" onclick="displayValue('3')">3</button>
                <button class="button calc-btn" onclick="displayValue('-')">-</button>

                <button class="button zero" onclick="displayValue('0')">0</button>
                <button class="button decimal" onclick="displayValue('.')">.</button>
                <form><input class="button equals" type="button" name="submit" value="=" onclick="calculate()"></form>
                <button class="button calc-btn" onclick="displayValue('+')">+</button>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
    <script>
        // display the buttons as they are pressed
        function displayValue(x) {
            if(x == ""){
                document.getElementById("result").innerHTML = "";
            }else document.getElementById("result").innerHTML += x;
        }
        function calculate(){
            var str = document.getElementById("result").innerHTML;
            if (str.length == 0) {
                document.getElementById("result").innerHTML = "";
            return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("result").innerHTML = this.responseText;
                    var result = this.responseText;
                    // console.log(result);
                    if (result == 198){
                        launchConfetti();
                    }
                }
            };
            xmlhttp.open("GET", "backend.php?input=" + str, true); //true means we want asynchronous
            xmlhttp.send();
            }
        }


        function launchConfetti(){ 
            var duration = 5 * 1000;
            var animationEnd = Date.now() + duration;
            var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            var interval = setInterval(function() {
            var timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
                return clearInterval(interval);
            }

            var particleCount = 50 * (timeLeft / duration);
            // since particles fall down, start a bit higher than random
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
            }, 250);
        }
    </script>
</html>

