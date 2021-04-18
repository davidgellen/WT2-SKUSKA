<?php
session_start();

require_once "database/Database.php";
try {
    $conn = (new Database())->getConnection();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if(isset($_POST['email']) && isset($_POST['password'])){
    $sql = "SELECT email,password FROM teacher";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_NUM);

    foreach ($rows as $row) {
        if($row[0] == $_POST['email'] && password_verify($_POST['password'], $row[1])){
            header("Location: teacherProfil.php");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <?php include "includes/header.php" ?>
    <link rel="stylesheet" href="styles/styleBody.css">
</head>
<body>
<body class="d-flex flex-column min-vh-100">
<div class="wrapper flex-grow-1 center-content" id="betterWidth">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php">BohovskaOhromnaAplikacia</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sources.php">Zdroje</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            O nás
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="david_g.php">David Gellen</a>
                            <a class="dropdown-item" href="patrik_i.php">Patrik Ištók</a>
                            <a class="dropdown-item" href="patrik_k.php">Patrik Kupčulák</a>
                            <a class="dropdown-item" href="peter_k.php">Peter Krajčí</a>
                            <a class="dropdown-item" href="zuzana_m.php">Zuzana Medzihradská</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="goals.php">Ciele</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <article>
        <div id="login_form">
            <h1>Prihllásenie</h1>
            <div class="container">
                <div class="row">
                    <button class="col-sm-6 btn btn-info" onclick="activateForm(this)" id="loginStudent">Prihlásiť sa ako žiak</button>
                    <button class="col-sm-6 btn btn-danger" onclick="activateForm(this)" id="loginTeacher">Prihlásiť sa ako učiteľ</button>
                </div>
            </div>
            <br>
            <div id="login_asStudent">
                <form action="index.php" method="post">
                    <div class="form-group">
                        <label for="exam_code">Kód testu:</label><small>(*Zadaj: "QWERT" pre test)</small> <?php //TODO: Po spravnom overeni zmazat ?>
                        <input type="text" class="form-control" id="exam_code" placeholder="Kód" onchange="confirmCode(this)" required>
                    </div>
                    <div id="additional_login" style="display: none;">
                        <div class="form-group">
                            <label for="meno">Meno:</label>
                            <input type="text" class="form-control" id="meno" placeholder="Zadaj meno" required>
                        </div>
                        <div class="form-group">
                            <label for="priezvisko">Priezvisko:</label>
                            <input type="text" class="form-control" id="priezvisko" placeholder="Zadaj priezvisko" required>
                        </div>
                        <div class="form-group">
                            <label for="ais_id">AIS ID:</label>
                            <input type="number" class="form-control" id="ais_id" placeholder="Zadaj AIS ID" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Prihlásiť</button>
                    </div>
                </form>
            </div>
            <div id="login_asTeacher" style="display: none;">
                <form action="index.php" method="post">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Zadaj email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Heslo" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Prihlásiť</button>
                    <a href="register.php"><div class="btn btn-info">Registrácia</div></a>
                </form>
            </div>
        </div>
    </article>
</div>
<script>
    function activateForm(form) {
        let loginStudent = document.getElementById("login_asStudent");
        let loginTeacher = document.getElementById("login_asTeacher");

        if(form.id === "loginStudent"){
            loginStudent.style.display = "block";
            loginTeacher.style.display = "none";
        }
        else{
            loginStudent.style.display = "none";
            loginTeacher.style.display = "block";
        }
    }

    function confirmCode(code){
        let addit_log = document.getElementById("additional_login");
        if(code.value === "QWERT"){ //TODO: Over pomocou kódu, ktorý je v DB
            addit_log.style.display = "block";
        }
        else {
            addit_log.style.display = "none";
        }
    }

</script>
<?php include "includes/footer.php";?>
</body>
</html>