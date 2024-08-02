<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unos recepta</title>
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
            <h1>Unos recepta</h1>
        </header>

        <!-- Forma za unos recepta -->
        <form method="post" action="recepti.php">
            <div class="form-group row">
                <label for="br_kartona" class="col-sm-3 col-form-label">Broj kartona:</label>
                <div class="col-sm-9">
                    <input type="number" id="br_kartona" name="br_kartona" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="br_knjizice" class="col-sm-3 col-form-label">Broj knjižice:</label>
                <div class="col-sm-9">
                    <input type="number" id="br_knjizice" name="br_knjizice" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="lek" class="col-sm-3 col-form-label">Lek:</label>
                <div class="col-sm-9">
                    <input type="text" id="lek" name="lek" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="nacin_upotrebe" class="col-sm-3 col-form-label">Način upotrebe:</label>
                <div class="col-sm-9">
                    <textarea id="nacin_upotrebe" name="nacin_upotrebe" class="form-control" rows="7" required></textarea>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary btn-block">Unesi recept</button>
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
    // Uključivanje fajla za konekciju sa bazom
    include_once("php/baza.php");

    // Provera da li je zahtev poslat metodom POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Priprema upita za unos podataka
        $sql = "INSERT INTO recepti (br_kartona, br_knjizice, lek, nacin_upotrebe) VALUES (?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Povezivanje parametara sa promenljivama
            $stmt->bind_param("iiss", $param_br_kartona, $param_br_knjizice, $param_lek, $param_nacin_upotrebe);

            // Postavljanje vrednosti parametara
            $param_br_kartona = $_POST['br_kartona'];
            $param_br_knjizice = $_POST['br_knjizice'];
            $param_lek = $_POST['lek'];
            $param_nacin_upotrebe = $_POST['nacin_upotrebe'];

            // Izvršavanje upita
            if ($stmt->execute()) {
                echo "<div class='alert alert-success mt-3' role='alert'>Podaci su uspešno uneti.</div>";
            } else {
                echo "<div class='alert alert-danger mt-3' role='alert'>Greška prilikom izvršavanja upita: " . $stmt->error . "</div>";
            }

            // Zatvaranje pripremljenog upita
            $stmt->close();
        }

        // Zatvaranje konekcije sa bazom podataka
        $mysqli->close();
    }
    ?>

    <!-- Skripte za Bootstrap i jQuery -->
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
