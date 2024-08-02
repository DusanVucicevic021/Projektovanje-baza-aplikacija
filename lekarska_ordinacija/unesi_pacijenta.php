<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unesi Pacijenta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Centralizovanje sadržaja i stilizacija kontejnera */
        body {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .container {
            width: 80%;
            box-sizing: border-box;
        }

        /* Stilizacija zaglavlja */
        header {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Stilizacija forme */
        form {
            border: 2px solid #2F4858;
            padding: 20px;
            border-radius: 10px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>

    <div class="container">
        <header>
            <h1>Unesi Pacijenta</h1>
        </header>

        <!-- Forma za unos pacijenata -->
        <form action="unesi_pacijenta.php" method="POST">
            <div class="form-group row">
                <label for="ime_i_prezime" class="col-sm-3 col-form-label">Ime i prezime:</label>
                <div class="col-sm-9">
                    <input type="text" id="ime_i_prezime" name="ime_i_prezime" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="datum_rodjenja" class="col-sm-3 col-form-label">Datum rođenja:</label>
                <div class="col-sm-9">
                    <input type="date" id="datum_rodjenja" name="datum_rodjenja" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="JMBG" class="col-sm-3 col-form-label">JMBG:</label>
                <div class="col-sm-9">
                    <input type="text" id="JMBG" name="JMBG" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="LBO" class="col-sm-3 col-form-label">LBO:</label>
                <div class="col-sm-9">
                    <input type="text" id="LBO" name="LBO" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="br_knjizice" class="col-sm-3 col-form-label">Broj knjižice:</label>
                <div class="col-sm-9">
                    <input type="text" id="br_knjizice" name="br_knjizice" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="izabrani_lekar" class="col-sm-3 col-form-label">Izabrani lekar:</label>
                <div class="col-sm-9">
                    <select id="izabrani_lekar" name="izabrani_lekar" class="form-control">
                        <option>Izaberite lekara</option>
                        <option>dr Marko Jovanović</option>
                        <option>dr Ana Petrović</option>
                        <option>dr Jovana Popović</option>
                        <option>dr Nikola Stojanović</option>
                        <option>dr Milica Nikolić</option>
                        <option>dr Stefan Đorđević</option>
                        <option>dr Aleksandar Simić</option>
                        <option>dr Filip Stevanović</option>
                        <option>dr Ivana Lukić</option>
                        <option>dr Marija Kovačević</option>
                        <option>dr Luka Radovanović</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary btn-block">Unesi Pacijenta</button>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <a href="ordinacija.php" class="btn btn-secondary btn-block">Nazad na ordinaciju</a>
                </div>
            </div>
        </form>
    </div>

    <?php
    // Uključivanje fajla za konekciju sa bazom podataka
    include_once("php/baza.php");

    // Provera da li je forma poslata
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Preuzimanje podataka iz forme
        $ime_i_prezime = $_POST['ime_i_prezime'];
        $datum_rodjenja = $_POST['datum_rodjenja'];
        $JMBG = $_POST['JMBG'];
        $LBO = $_POST['LBO'];
        $br_knjizice = $_POST['br_knjizice'];
        $izabrani_lekar = $_POST['izabrani_lekar'];

        // SQL upit za unos podataka u tabelu 'pacijenti'
        $sql = "INSERT INTO pacijenti (ime_i_prezime, datum_rodjenja, JMBG, LBO, br_knjizice, izabrani_lekar)
                VALUES (?, ?, ?, ?, ?, ?)";

        // Priprema SQL upita
        if ($stmt = $mysqli->prepare($sql)) {
            // Povezivanje parametara sa promenljivama
            $stmt->bind_param("ssssss", $ime_i_prezime, $datum_rodjenja, $JMBG, $LBO, $br_knjizice, $izabrani_lekar);

            // Izvršavanje upita
            if ($stmt->execute()) {
                // Preusmeravanje na glavnu stranicu ako je unos uspešan
                header("Location: ordinacija.php");
                exit();
            } else {
                // Ispis poruke o grešci ako unos nije uspešan
                echo "<div class='alert alert-danger mt-3' role='alert'>Greška prilikom dodavanja pacijenta: " . $stmt->error . "</div>";
            }

            // Zatvaranje pripremljenog upita
            $stmt->close();
        }

        // Zatvaranje konekcije sa bazom podataka
        $mysqli->close();
    }
    ?>

    <!-- Skripte za jQuery, Popper.js i Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</body>

</html>
