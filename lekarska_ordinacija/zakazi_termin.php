<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zakazi Termin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Stilizacija tela stranice */
        body {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .container {
            width: 60%;
            box-sizing: border-box;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
            border: 2px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            box-sizing: border-box;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input,
        select {
            padding: 10px;
            margin-bottom: 20px;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>

<body>

    <div class="container">
        <header>
            <h1>Zakazi Termin</h1>
        </header>

        <div class="form-container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                Broj kartona: <input type="text" name="br_kartona" class="form-control" required><br><br>
                Ime i prezime: <input type="text" name="ime_i_prezime" class="form-control" required><br><br>
                Datum i vreme zakazivanja:
                <input type="datetime-local" id="datum_vreme_zakazivanja" name="datum_vreme_zakazivanja"
                    class="form-control" required step="900" min="<?php echo $trenutno_vreme; ?>"
                    max="<?php echo $datum_vreme_max; ?>">

                <button type="submit" class="btn btn-primary">Zakaži termin</button>
                <a href="ordinacija.php" class="btn btn-secondary">Nazad na ordinaciju</a>
            </form>

            <?php
            // Funkcija za proveru da li je zakazivanje u okviru radnog vremena
            function proveri_radno_vreme($datum_vreme_zakazivanja)
            {
                // Zamena T znaka sa razmakom za formiranje ispravnog formata datuma i vremena
                $datum_vreme_zakazivanja = str_replace("T", " ", $datum_vreme_zakazivanja);

                // Parsiranje datuma i vremena
                $termin_vreme = date_create_from_format('Y-m-d H:i', $datum_vreme_zakazivanja);

                // Definisanje početka i kraja radnog vremena
                $pocetak_radnog_vremena = date_create($termin_vreme->format('Y-m-d') . ' 07:00');
                $kraj_radnog_vremena = date_create($termin_vreme->format('Y-m-d') . ' 20:00');

                // Provera da li je uspešno parsiran datum i vreme
                if ($termin_vreme === false) {
                    return false;
                }

                // Provera da li je termin unutar radnog vremena ordinacije
                if ($termin_vreme >= $pocetak_radnog_vremena && $termin_vreme <= $kraj_radnog_vremena) {
                    return true; // Unutar radnog vremena
                } else {
                    return false; // Van radnog vremena
                }
            }

            // Provera i obrada podataka iz formulara
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $br_kartona = $_POST['br_kartona']; // Preuzimanje broja kartona
                $ime_i_prezime = $_POST['ime_i_prezime']; // Preuzimanje imena i prezimena
                $datum_vreme_zakazivanja = $_POST['datum_vreme_zakazivanja']; // Preuzimanje datuma i vremena zakazivanja
            
                // Provera radnog vremena
                if (!proveri_radno_vreme($datum_vreme_zakazivanja)) {
                    echo "<div class='alert alert-warning'>Uneli ste termin: [$datum_vreme_zakazivanja]. Molimo izaberite termin između 07:00 i 20:00.</div>";
                } else {
                    // Konekcija sa bazom podataka
                    $host = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "lekarska_ordinacija";

                    // Kreiranje konekcije
                    $conn = new mysqli($host, $username, $password, $dbname);

                    // Provera konekcije
                    if ($conn->connect_error) {
                        die("Neuspela konekcija: " . $conn->connect_error);
                    }

                    // Provera dostupnosti termina
                    $check_query = "SELECT * FROM zakazani_termini WHERE datum_vreme_zakazivanja = '$datum_vreme_zakazivanja'";
                    $result = $conn->query($check_query);
                    if ($result->num_rows > 0) {
                        echo "<div class='alert alert-danger'>Već postoji zakazani termin u izabranom vremenskom intervalu.</div>";
                    } else {
                        // SQL upit za ubacivanje podataka u tabelu
                        $sql = "INSERT INTO zakazani_termini (br_kartona, ime_i_prezime, datum_vreme_zakazivanja) 
                        VALUES ('$br_kartona', '$ime_i_prezime', '$datum_vreme_zakazivanja')";

                        // Izvršenje upita i provera uspešnosti
                        if ($conn->query($sql) === TRUE) {
                            echo "<div class='alert alert-success'>Termin je uspešno zakazan.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Greška prilikom zakazivanja termina: " . $conn->error . "</div>";
                        }
                    }

                    // Zatvaranje konekcije
                    $conn->close();
                }
            }
            ?>
        </div>
    </div>

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
