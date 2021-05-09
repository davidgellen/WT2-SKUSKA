<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../scripts/qrcodelibrary/qrcode.min.js"></script>
    <title>QR kód</title>
</head>
<body>
    <p>Po odfotení a uložení odpovede, dajte hotovo</p>
    <br>
    <div id="qrcode"></div>
    <br>
    <button onclick="hotovo()">Hotovo</button>

    <script type="text/javascript">
        base = window.location.href;
        qid = "<?php echo $_GET["qid"]; ?>";
        filename = "<?php echo $_GET["filename"]; ?>";
        stringReplaced = "qrcode.php?qid="+qid+"&filename="+filename;
        stringReplacing = "photoPage.php?qid="+qid+"&filename="+filename;
        base = base.replace(stringReplaced, stringReplacing);
        console.log(base);
        new QRCode(document.getElementById("qrcode"), base);
        function hotovo(){
            window.close();
            localStorage.setItem("drawingqid", "<?php echo $_GET["qid"]; ?>");
            localStorage.setItem("drawingName", filename);
        }
    </script>
</body>
</html>