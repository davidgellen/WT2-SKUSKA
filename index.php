<?php

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
        <div id="login_form" class="debug">
            <h1>Prihllásenie</h1>
            <div class="container">
                <div class="row">
                    <button class="col-sm-6 btn btn-info" onclick="activateForm(this)" id="loginStudent">Prihlásiť sa ako žiak</button>
                    <button class="col-sm-6 btn btn-danger" onclick="activateForm(this)" id="loginTeacher">Prihlásiť sa ako učiteľ</button>
                </div>
            </div>
            <br>
            <div id="login_asStudent">
                <form>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Zadaj email" pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Heslo" required>
                    </div>
                    <div class="form-group">
                        <label for="exam_code">Kód testu</label>
                        <input type="text" class="form-control" id="exam_code" placeholder="Kód" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Prihlásiť</button>
                </form>
            </div>
            <div id="login_asTeacher" style="display: none;">
                <form>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Zadaj email" pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Heslo" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Prihlásiť</button>
                </form>
            </div>
        </div>
    </article>
</div>
<script>
    function activateForm(form) {
        let loginStudent = document.getElementById("login_asStudent");
        let loginTeacher = document.getElementById("login_asTeacher");

        loginStudent.style.cursor = "pointer";
        loginTeacher.style.cursor = "pointer";

        if(form.id === "loginStudent"){
            loginStudent.style.display = "block";
            loginTeacher.style.display = "none";
        }
        else{
            loginStudent.style.display = "none";
            loginTeacher.style.display = "block";
        }
    }

</script>
<?php include "includes/footer.php";?>
</body>
</html>