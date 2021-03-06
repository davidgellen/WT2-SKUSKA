<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#imageFile').change(function(evt) {

                var files = evt.target.files;
                var file = files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('preview').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }

                if (window.File && window.FileReader && window.FileList && window.Blob) {
                    if (file) {
                        var reader1 = new FileReader();
                        reader1.onload = function(e) {
                            var img = document.createElement("img");
                            img.src = e.target.result;

                            var canvas = document.createElement("canvas");
                            var ctx = canvas.getContext("2d");
                            ctx.drawImage(img, 0, 0);

                            var MAX_WIDTH = 400;
                            var MAX_HEIGHT = 400;
                            var width = img.width;
                            var height = img.height;

                            if (width > height) {
                                if (width > MAX_WIDTH) {
                                    height *= MAX_WIDTH / width;
                                    width = MAX_WIDTH;
                                }
                            } else {
                                if (height > MAX_HEIGHT) {
                                    width *= MAX_HEIGHT / height;
                                    height = MAX_HEIGHT;
                                }
                            }
                            canvas.width = width;
                            canvas.height = height;
                            var ctx = canvas.getContext("2d");
                            ctx.drawImage(img, 0, 0, width, height);

                            dataurl = canvas.toDataURL(file.type);
                            document.getElementById('output').src = dataurl;
                        }
                        reader1.readAsDataURL(file);
                    }
                }
                else {
                    alert('The File APIs are not fully supported in this browser.');
                }
            });
            $("#savebtn").click(function(e){
                e.preventDefault();
                let img = document.getElementById("output");

                let canvas = document.createElement('canvas');
                canvas.height = img.height;
                canvas.width = img.width;
                let ctx = canvas.getContext('2d');

                ctx.drawImage(img, 0, 0);
                let canvasdata = canvas.toDataURL();
                let filename = "<?php echo $_GET["filename"]; ?>";
                $.ajax({
                    url: 'savePhoto.php',
                    type: 'post',
                    data: {canvasdata: canvasdata,
                            filename: filename
                    },
                    success: function(){
                        window.close();
                    }
                })
            });
        });
    </script>

    <title>Document</title>
</head>
<body>
    <p>Stla??en??m tla????tka Vybra?? s??bor m????ete odfoti?? va??u odpove??. Preh??ad obr??zka sa v??m zobraz?? na tejto str??nke. Ak sa obr??zok nepodarilo na????ta??, tak nastal neo??ak??van?? probl??m pri jeho kompresi??, sk??ste to znova.
        Ak probl??m pretrv??va, tak sk??ste zn????i?? kvalitu fotografie. Ak sa obr??zok podarilo na????ta??, m????ete ho ulo??i?? do testu tla????tkom ulo??i??.
    </p>
    <input id="imageFile" name="imageFile" type="file" class="imageFile"  accept="image/*" capture="camera"   /> 
    <br/>
    <img src="" id="preview" style="display: none;" >
    <img src="" id="output">
    <br>
    <button id="savebtn">Ulo??i??</button>
</body>
</html>
