<!DOCTYPE html>
<html lang="sk">
<head>
    <?php include "../../includes/header.php" ?>
    <link rel="stylesheet" href="../../styles/styleBody.css">
    <link rel="stylesheet" href="../../styles/studentTestQuestion.css">
    <title>Kresba</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#canvasbtn").click(function(e){
                e.preventDefault();
                let canvass = $("#canvas");
                let canvasdata = canvas.toDataURL();
                let filename = "<?php echo $_GET["filename"]; ?>";
                $.ajax({
                    url: 'saveDrawing.php',
                    type: 'post',
                    data: {canvasdata: canvasdata,
                            filename: filename
                    },
                    success: function(){
                        localStorage.setItem("drawingqid", "<?php echo $_GET["qid"]; ?>");
                        localStorage.setItem("drawingName", filename);
                        window.open('','_self').close();
                    }
                });
            });
        });
    </script>

    <style>
        #canvas {
        border: 1px solid black; 
        }

        .stroke-color {
        border-radius: 50%;
        width: 30px;
        height: 30px;
        }
    </style>
</head>
<body class="draw">
    <button onclick="Restore()" class="btnActivation">Undo</button>
    <button onclick="Clear()" class="btnActivation">Clear</button>
    <input type="color" oninput="stroke_color = this.value" placeholder="Colors">
    </div>
    <input type="range" min="1" max="100" oninput="stroke_width = this.value">
    <br><br>
    <canvas id="canvas" width="600" height="400"></canvas>
    <br><br>
    <button id="canvasbtn" class="btn1">Uložiť</button>
    <script>
        //https://codepen.io/BananaCoding/pen/mdrGjpL
        let canvas = document.getElementById("canvas");
        let context = canvas.getContext("2d");
        context.fillStyle = "white";
        context.fillRect(0, 0, canvas.width, canvas.height);
        let restore_array = [];
        let start_index = -1;
        let stroke_color = 'black';
        let stroke_width = "2";
        let is_drawing = false;

        function change_color(element) {
        stroke_color = element.style.background;
        }

        function change_width(element) {
        stroke_width = element.innerHTML;
        }

        function start(event) {
        is_drawing = true;
        context.beginPath();
        context.moveTo(getX(event), getY(event));
        event.preventDefault();
        }

        function draw(event) {
        if (is_drawing) {
            context.lineTo(getX(event), getY(event));
            context.strokeStyle = stroke_color;
            context.lineWidth = stroke_width;
            context.lineCap = "round";
            context.lineJoin = "round";
            context.stroke();
        }
        event.preventDefault();
        }

        function stop(event) {
        if (is_drawing) {
            context.stroke();
            context.closePath();
            is_drawing = false;
        }
        event.preventDefault();
        restore_array.push(context.getImageData(0, 0, canvas.width, canvas.height));
        start_index += 1;
        }

        function getX(event) {
        if (event.pageX == undefined) {return event.targetTouches[0].pageX - canvas.offsetLeft;} else
        {return event.pageX - canvas.offsetLeft;}
        }


        function getY(event) {
        if (event.pageY == undefined) {return event.targetTouches[0].pageY - canvas.offsetTop;} else
        {return event.pageY - canvas.offsetTop;}
        }

        canvas.addEventListener("touchstart", start, false);
        canvas.addEventListener("touchmove", draw, false);
        canvas.addEventListener("touchend", stop, false);
        canvas.addEventListener("mousedown", start, false);
        canvas.addEventListener("mousemove", draw, false);
        canvas.addEventListener("mouseup", stop, false);
        canvas.addEventListener("mouseout", stop, false);

        function Restore() {
        if (start_index <= 0) {
            Clear();
        } else {
            start_index += -1;
            restore_array.pop();
            if (event.type != 'mouseout') {
            context.putImageData(restore_array[start_index], 0, 0);
            }
        }
        }

        function Clear() {
        context.fillStyle = "white";
        context.clearRect(0, 0, canvas.width, canvas.height);
        context.fillRect(0, 0, canvas.width, canvas.height);
        restore_array = [];
        start_index = -1;
        }
    </script>
</body>
</html>