<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zakazani termini</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Centralizovanje sadržaja i stilizacija */
        body {
            display: flex;
            justify-content: center;
            margin: 50px 0;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            text-align: center;
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
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h2>Zakazani termini</h2>
            <a href="ordinacija.php" class="btn btn-secondary">Nazad na ordinaciju</a>
        </header>

        <?php
        // Uključivanje fajla za konekciju sa bazom podataka
        include_once ("php/baza.php");

        // Priprema upita za izbor zakazanih termina, br_kartona, ime_i_prezime i izabrani_lekar iz tabele zakazani_termini
        $sql = "SELECT zt.id, zt.datum_vreme_zakazivanja, zt.br_kartona, zt.ime_i_prezime, p.izabrani_lekar 
                FROM zakazani_termini zt
                INNER JOIN pacijenti p ON zt.br_kartona = p.br_kartona
                ORDER BY zt.datum_vreme_zakazivanja ASC";

        // Izvršavanje upita
        $result = $mysqli->query($sql);

        // Provera rezultata upita
        if ($result->num_rows > 0) {
            // Ispis tabele sa zaglavljem
            echo "<table class='table'>";
            echo "<thead class='thead-light'>";
            echo "<tr><th>Vreme zakazivanja</th><th>Broj kartona</th><th>Ime i prezime</th><th>Izabrani lekar</th><th>Akcije</th></tr>";
            echo "</thead><tbody>";

            // Ispis svakog reda rezultata upita
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['datum_vreme_zakazivanja'] . "</td>";
                echo "<td>" . $row['br_kartona'] . "</td>";
                echo "<td>" . $row['ime_i_prezime'] . "</td>";
                echo "<td>" . $row['izabrani_lekar'] . "</td>";
                echo "<td>";
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='termin_id' value='" . $row['id'] . "'>";
                echo "<button type='submit' class='btn btn-danger' name='delete'>Izbriši</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='alert alert-info'>Nema zakazanih termina.</p>";
        }

        // Provera da li je pritisnut dugme za brisanje
        if (isset($_POST['delete'])) {
            $termin_id = $_POST['termin_id'];

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

            // SQL upit za brisanje
            $delete_query = "DELETE FROM zakazani_termini WHERE id = $termin_id";

            // Izvršenje upita i provera uspešnosti
            if ($conn->query($delete_query) === TRUE) {
                echo "<div class='alert alert-success'>Termin je uspešno izbrisan.</div>";
            } else {
                echo "<div class='alert alert-danger'>Greška prilikom brisanja termina: " . $conn->error . "</div>";
            }

            // Zatvaranje konekcije
            $conn->close();
        }

        // Oslobađanje rezultata upita i zatvaranje konekcije sa bazom podataka
        $result->free();
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
