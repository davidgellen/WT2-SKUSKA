<!DOCTYPE html>
<html lang="sk">
<head>
    <?php include "../../includes/header.php" ?>
    <link rel="stylesheet" href="../../styles/styleBody.css">
    <link rel="stylesheet" href="../../styles/studentTestQuestion.css">
    <title>QR kód</title>
    <script src="../../scripts/qrcodelibrary/qrcode.min.js"></script>

</head>
<body class="qrcode">
    <h1>Sken QR kódu z obrázka</h1>
    <p>Po odfotení a uložení odpovede, dajte hotovo</p>
    <br>
    <div id="qrcode" style="display: inline-block;"></div>
    <br><br>
    <button onclick="hotovo()" class="btn1">Hotovo</button>

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