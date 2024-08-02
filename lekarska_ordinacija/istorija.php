<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Istorija pacijenta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            display: flex;
            justify-content: center;
            margin: 50px 0;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            text-align: center;
            box-sizing: border-box;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
            padding: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #2F4858;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #F5F3CB;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h2>Istorija pacijenta</h2>
            <a href="ordinacija.php"><button type="button" class="btn btn-primary">Nazad na ordinaciju</button></a>
        </header>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="row">
            <div class="form-group col-md-6 offset-md-3">
                <label for="br_kartona">Unesite broj kartona pacijenta:</label>
                <input type="text" id="br_kartona" name="br_kartona" class="form-control" style="font-size: 25px;" required>
            </div>
            <div class="form-group col-md-6 offset-md-3">
                <button type="submit" class="btn btn-primary btn-block">Pretraži</button><br><br>
            </div>
        </form>

        <?php
        // Uključivanje konekcije sa bazom
        include_once("php/baza.php");

        // Provera da li je forma poslata
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Čitanje broja kartona iz forme
            if (isset($_POST['br_kartona'])) {
                $br_kartona = $_POST['br_kartona'];

                // SQL upit za čitanje podataka iz baze
                $sql = "SELECT p.br_kartona, p.ime_i_prezime, p.jmbg, p.br_knjizice, d.naziv, d.opis, r.lek
                FROM pacijenti p
                LEFT JOIN dijagnoze d ON p.br_kartona = d.br_kartona
                LEFT JOIN recepti r ON p.br_kartona = r.br_kartona
                WHERE p.br_kartona = '$br_kartona'";

                // Izvršavanje upita
                $result = $mysqli->query($sql);

                // Provera rezultata upita
                if ($result && $result->num_rows > 0) {
                    // Ispis naslova "Podaci o pacijentu"
                    echo "<h2>Podaci o pacijentu</h2>";

                    // Ispis tabele sa rezultatima
                    echo "<table class='table'>";
                    echo "<thead class='thead-light'>";
                    echo "<tr><th>Broj kartona</th><th>Ime i prezime</th><th>JMBG</th><th>Broj knjižice</th><th>Naziv dijagnoze</th><th>Opis dijagnoze</th><th>Lek</th><th>Akcije</th></tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['br_kartona']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['ime_i_prezime']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['jmbg']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['br_knjizice']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['naziv']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['opis']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['lek']) . "</td>";
                        echo "<td>";
                        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                        echo "<input type='hidden' name='br_kartona' value='" . $row['br_kartona'] . "'>";
                        echo "<button type='submit' name='edit' class='btn btn-sm btn-warning'>Izmeni</button> ";
                        echo "<button type='submit' name='delete' class='btn btn-sm btn-danger'>Izbriši</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    // Poruka ako nema rezultata
                    echo "<br><h3>Nema rezultata za uneti broj kartona.</h3>";
                }

                // Oslobađanje rezultata upita
                if ($result) {
                    $result->free();
                }
            } else {
                // Poruka ako broj kartona nije unet
                echo "<br><h3>Nije unet broj kartona.</h3>";
            }
        }

        // Ako je pritisnuto dugme za izmenu
        if (isset($_POST['edit'])) {
            $br_kartona = $_POST['br_kartona'];

            // Dobavljanje postojećih podataka za dijagnozu i lek
            $select_query_dijagnoza = "SELECT naziv, opis FROM dijagnoze WHERE br_kartona = '$br_kartona'";
            $select_query_lek = "SELECT lek FROM recepti WHERE br_kartona = '$br_kartona'";

            $result_dijagnoza = $mysqli->query($select_query_dijagnoza);
            $result_lek = $mysqli->query($select_query_lek);

            if ($result_dijagnoza && $result_lek) {
                $row_dijagnoza = $result_dijagnoza->fetch_assoc();
                $row_lek = $result_lek->fetch_assoc();

                $naziv = $row_dijagnoza['naziv'];
                $opis = $row_dijagnoza['opis'];
                $lek = $row_lek['lek'];

                // Forma za izmenu dijagnoze i leka
                echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' class='row'>";
                echo "<div class='form-group col-md-6 offset-md-3'>";
                echo "<input type='hidden' name='br_kartona' value='" . $br_kartona . "'>";
                echo "<label for='naziv'>Naziv dijagnoze:</label>";
                echo "<input type='text' id='naziv' name='naziv' class='form-control' style='font-size: 25px;' value='" . $naziv . "' required>";
                echo "</div>";
                echo "<div class='form-group col-md-6 offset-md-3'>";
                echo "<label for='opis'>Opis dijagnoze:</label>";
                echo "<textarea id='opis' name='opis' class='form-control' rows='3' required>" . $opis . "</textarea>";
                echo "</div>";
                echo "<div class='form-group col-md-6 offset-md-3'>";
                echo "<label for='lek'>Lek:</label>";
                echo "<input type='text' id='lek' name='lek' class='form-control' value='" . $lek . "' required>";
                echo "</div>";
                echo "<div class='form-group col-md-6 offset-md-3'>";
                echo "<button type='submit' name='update' class='btn btn-primary'>Sačuvaj izmene</button>";
                echo "</div>";
                echo "</form>";

                // Oslobađanje rezultata
                $result_dijagnoza->free();
                $result_lek->free();
            } else {
                echo "<div class='alert alert-danger'>Greška prilikom čitanja podataka: " . $mysqli->error . "</div>";
            }
        }

        // Ako je pritisnuto dugme za ažuriranje
        if (isset($_POST['update'])) {
            $br_kartona = $_POST['br_kartona'];
            $naziv = $_POST['naziv'];
            $opis = $_POST['opis'];
            $lek = $_POST['lek'];

            // Provera da li su sva polja popunjena
            if (!empty($br_kartona) && !empty($naziv) && !empty($opis) && !empty($lek)) {
                // SQL upit za ažuriranje dijagnoze
                $update_query_dijagnoza = "UPDATE dijagnoze SET naziv = '$naziv', opis = '$opis' WHERE br_kartona = '$br_kartona'";
                $update_query_lek = "UPDATE recepti SET lek = '$lek' WHERE br_kartona = '$br_kartona'";

                // Izvršavanje upita
                if ($mysqli->query($update_query_dijagnoza) === TRUE && $mysqli->query($update_query_lek) === TRUE) {
                    echo "<div class='alert alert-success'>Uspešno ste ažurirali dijagnozu i lek za pacijenta sa brojem kartona: " . $br_kartona . "</div>";
                } else {
                    echo "<div class='alert alert-danger'>Greška prilikom ažuriranja: " . $mysqli->error . "</div>";
                }
            } else {
                // Poruka ako nisu sva polja popunjena
                echo "<div class='alert alert-danger'>Molimo popunite sva polja.</div>";
            }
        }

        // Ako je pritisnuto dugme za brisanje
        if (isset($_POST['delete'])) {
            $br_kartona = $_POST['br_kartona'];

            // SQL upit za brisanje dijagnoze
            $delete_query_dijagnoza = "DELETE FROM dijagnoze WHERE br_kartona = '$br_kartona'";
            $delete_query_lek = "DELETE FROM recepti WHERE br_kartona = '$br_kartona'";

            // Izvršavanje upita
            if ($mysqli->query($delete_query_dijagnoza) === TRUE && $mysqli->query($delete_query_lek) === TRUE) {
                echo "<div class='alert alert-success'>Uspešno ste izbrisali dijagnozu i lek za pacijenta sa brojem kartona: " . $br_kartona . "</div>";
            } else {
                echo "<div class='alert alert-danger'>Greška prilikom brisanja: " . $mysqli->error . "</div>";
            }
        }

        // Zatvaranje konekcije sa bazom
        $mysqli->close();
        ?>
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

