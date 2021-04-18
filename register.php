<?php
session_start();

require_once "database/Database.php";
try {
    $conn = (new Database())->getConnection();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

function teacherExist($conn) {
    $email = $_POST['email'];

    $sql = "SELECT email FROM teacher";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_NUM);

    foreach ($rows as $row){
        echo 'test';
        if($row[0] == $email){
            return false;
        }
    }
    return true;
}

if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['password'])) {
    if(teacherExist($conn)){
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $sql = "INSERT INTO teacher (name, surname, email, password) VALUES ('$name','$surname','$email','".password_hash($_POST['password'], PASSWORD_DEFAULT )."')";
        $stmt= $conn->prepare($sql);
        $stmt->execute();
        session_destroy();
        header("Location: index.php");
    }
}

?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <?php include "includes/header.php" ?>
    <link rel="stylesheet" href="styles/styleBody.css">
    <link rel="stylesheet" href="styles/about.css">
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
    <article id="register_form">
        <form action="register.php" method="post">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="name">Meno</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Zadaj meno" required>
                </div>
                <div class="form-group col-sm-6">
                    <label for="surname">Priezvisko</label>
                    <input type="text" name="surname" class="form-control" id="surname" placeholder="Zadaj priezvisko" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Zadaj email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Heslo" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrovať sa</button>
        </form>
    </article>
</div>
<?php include "includes/footer.php";?>
</body>
</html>