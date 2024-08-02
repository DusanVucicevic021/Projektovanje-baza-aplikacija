<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> <!-- Postavlja kodnu stranicu na UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Osigurava responzivnost stranice -->
    <title>Unos dijagnoze</title> <!-- Naslov stranice -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> <!-- Povezuje Bootstrap CSS fajl -->
    <link rel="stylesheet" href="css/style.css"> <!-- Povezuje eksterni CSS fajl -->
    <style>
        /* Stilizacija kontejnera */
        .container {
            margin-top: 50px;
        }

        /* Stilizacija forme */
        form {
            border: 2px solid #2F4858;
            padding: 20px;
            border-radius: 10px;
            box-sizing: border-box;
            background-color: #F5F3CB;
        }

        /* Stilizacija dugmadi */
        button {
            width: 100%;
            margin-bottom: 10px;
        }

        /* Stilizacija zaglavlja */
        header {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Stilizacija tekstualnih polja */
        textarea {
            resize: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Unesi Pacijenta</h1> <!-- Naslov stranice -->
        </header>

        <!-- Forma za unos dijagnoze -->
        <form action="dijagnoza.php" method="post" class="row">
            <div class="form-group col-md-12">
                <label for="br_kartona">Broj kartona pacijenta:</label>
                <input type="text" id="br_kartona" name="br_kartona" class="form-control" required>
            </div>

            <div class="form-group col-md-12">
                <label for="naziv">Naziv dijagnoze:</label>
                <input type="text" id="naziv" name="naziv" class="form-control" required>
            </div>

            <div class="form-group col-md-12">
                <label for="opis">Opis dijagnoze:</label>
                <textarea id="opis" name="opis" class="form-control" rows="10" required></textarea>
            </div>

            <div class="form-group col-md-12">
                <button type="submit" class="btn btn-primary btn-block">Unesi dijagnozu</button> <!-- Dugme za unos dijagnoze -->
                <a href="ordinacija.php" class="btn btn-secondary btn-block">Nazad na ordinaciju</a> <!-- Dugme za povratak na glavnu stranicu -->
            </div>
            
        </form>
    </div>

    <?php
    // Uključivanje fajla za konekciju sa bazom podataka
    include_once("php/baza.php");

    // Provera da li je zahtev poslat metodom POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Preuzimanje podataka iz forme
        $br_kartona = $_POST['br_kartona'];
        $naziv = $_POST['naziv'];
        $opis = $_POST['opis'];

        // Priprema SQL upita za provjeru postojanja dijagnoze za određenog pacijenta
        $check_sql = "SELECT * FROM dijagnoze WHERE br_kartona = '$br_kartona' AND naziv = '$naziv'";

        // Izvršavanje SQL upita za provjeru
        $check_result = $mysqli->query($check_sql);

        // Provjera da li dijagnoza već postoji za određenog pacijenta
        if ($check_result->num_rows > 0) {
            echo "Dijagnoza već postoji za ovog pacijenta.";
        } else {
            // Priprema SQL upita za unos podataka u tabelu dijagnoze
            $sql = "INSERT INTO dijagnoze (br_kartona, naziv, opis)
                    VALUES ('$br_kartona', '$naziv', '$opis')";

            // Izvršavanje SQL upita
            if ($mysqli->query($sql) === TRUE) {
                // Preusmeravanje na glavnu stranicu ako je unos uspešan
                header("Location: ordinacija.php");
                exit();
            } else {
                // Prikaz greške ako unos nije uspešan
                echo "Greška prilikom dodavanja dijagnoze: " . $mysqli->error;
            }
        }

        // Zatvaranje konekcije sa bazom podataka
        $mysqli->close();
    }
    ?>

    <!-- Skripte za Bootstrap i jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>
