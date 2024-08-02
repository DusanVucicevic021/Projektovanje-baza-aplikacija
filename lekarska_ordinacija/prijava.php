<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css"> <!-- Povezuje eksterni CSS fajl -->

</head>
<style>
    /* Opšti stil */
    body {
        font-family: Arial, sans-serif;
    }

    /* Stil za header */
    header {
        text-align: center;
        margin-bottom: 20px;
    }

    h1 {
        margin-top: 0;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    /* Stil za formu */
    form {
        text-align: center;
        margin-bottom: 20px;
    }

    select,
    button {
        padding: 8px;
        font-size: 16px;
    }

    button {
        cursor: pointer;
    }

    /* Stil za tabelu */
    table {
        border-collapse: collapse;
        width: 80%;
        margin: 0 auto;
    }

    th,
    td {
        border: 1px solid #2F4858;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }
</style>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mt-5">Prijava</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="username">Korisničko ime</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Lozinka</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Prijavi se</button>
                </form>

                <?php
                // Podaci za konekciju na bazu
                $host = "localhost";
                $username = "root";
                $password = "";
                $dbname = "lekarska_ordinacija";

                // Konekcija na bazu
                $mysqli = new mysqli($host, $username, $password, $dbname);
                if ($mysqli->connect_error) {
                    die('Error:(' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
                }

                // Provera da li je forma podneta
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    // Upit za proveru kredencijala
                    $query = $mysqli->prepare("SELECT * FROM lekari WHERE username = ? AND password = ?");
                    $query->bind_param("ss", $username, $password);
                    $query->execute();
                    $result = $query->get_result();

                    if ($result->num_rows == 1) {
                        // Uspešna prijava
                        header("Location: ordinacija.php");
                        exit();
                    } else {
                        // Neuspešna prijava
                        echo "<div class='alert alert-danger mt-3'>Neispravno korisničko ime ili lozinka.</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>