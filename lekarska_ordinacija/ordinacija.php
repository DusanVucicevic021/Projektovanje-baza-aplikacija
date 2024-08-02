<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Podaci o pacijentima</title>
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
    <?php
    session_start();
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: prijava.php");
        exit;
    }
    ?>
    <div class="container">
        <header class="text-center mt-5">
            <h1>Podaci o pacijentima</h1>
            <!-- Forma za izbor lekara -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                class="form-inline justify-content-center mt-3">
                <div class="form-group">
                    <label for="izabrani_lekar" class="mr-2">Izaberite lekara:</label>
                    <select name="izabrani_lekar" id="izabrani_lekar" class="form-control mr-2">
                        <option value="">Izaberite lekara</option>
                        <option value="dr Marko Jovanović">dr Marko Jovanović</option>
                        <option value="dr Ana Petrović">dr Ana Petrović</option>
                        <option value="dr Jovana Popović">dr Jovana Popović</option>
                        <option value="dr Nikola Stojanović">dr Nikola Stojanović</option>
                        <option value="dr Milica Nikolić">dr Milica Nikolić</option>
                        <option value="dr Stefan Đorđević">dr Stefan Đorđević</option>
                        <option value="dr Aleksandar Simić">dr Aleksandar Simić</option>
                        <option value="dr Filip Stevanović">dr Filip Stevanović</option>
                        <option value="dr Ivana Lukić">dr Ivana Lukić</option>
                        <option value="dr Marija Kovačević">dr Marija Kovačević</option>
                        <option value="dr Luka Radovanović">dr Luka Radovanović</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Prikaži pacijente</button>
                </div>
            </form>
            <form method="post" style="position: absolute; top: 10px; right: 10px;">
                <button type="submit" name="logout" class="btn btn-danger">Odjavi se</button>
            </form>
        </header>

        <!-- Linkovi za druge akcije -->
        <div class="text-center mt-4">
            <a href="zakazi_termin.php" class="btn btn-secondary">Zakazi termin</a>
            <a href="unesi_pacijenta.php" class="btn btn-secondary">Unesi novog pacijenta</a>
            <a href="recepti.php" class="btn btn-secondary">Unesi recept</a>
            <a href="dijagnoza.php" class="btn btn-secondary">Unesi dijagnozu</a>
            <a href="zakazani.php" class="btn btn-secondary">Zakazani pacijenti</a>
            <a href="istorija.php" class="btn btn-secondary">Istorija</a>
        </div>

        <br>

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
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['logout'])) {
            if (isset($_POST['izabrani_lekar']) && !empty($_POST['izabrani_lekar'])) {
                $selectedDoctor = $_POST['izabrani_lekar'];
                echo "<h2 class='text-center mt-4'>Izabrani lekar: " . $selectedDoctor . "</h2>";

                // Izvršavanje upita na osnovu izabranog lekara
                $query = $mysqli->query("SELECT * FROM pacijenti WHERE izabrani_lekar = '$selectedDoctor'");

                // Provera rezultata upita
                if ($query) {
                    if ($query->num_rows > 0) {
                        // Prikaz tabele sa podacima pacijenata
                        echo '<div class="table-responsive mt-4">';
                        echo '<table class="table table-bordered">';
                        echo '<thead class="thead-light">';
                        echo '<tr><th>Broj kartona</th><th>Ime i prezime</th><th>Datum rođenja</th><th>JMBG</th><th>LBO</th><th>Broj knjižice</th></tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        // Iteracija kroz rezultate upita
                        while ($data = $query->fetch_object()) {
                            echo '<tr>';
                            echo '<td>' . $data->br_kartona . '</td>';
                            echo '<td>' . $data->ime_i_prezime . '</td>';
                            echo '<td>' . $data->datum_rodjenja . '</td>';
                            echo '<td>' . $data->JMBG . '</td>';
                            echo '<td>' . $data->LBO . '</td>';
                            echo '<td>' . $data->br_knjizice . '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    } else {
                        // Poruka ako nema pacijenata za izabranog lekara
                        echo "<div class='alert alert-warning text-center mt-4'>Nema pacijenata za izabranog lekara.</div>";
                    }
                } else {
                    // Poruka ako je došlo do greške u upitu
                    echo "<div class='alert alert-danger text-center mt-4'>Greška u izvršavanju upita: " . $mysqli->error . "</div>";
                }
            } else {
                // Poruka ako nije izabran lekar
                echo "<div class='alert alert-warning text-center mt-4'>Molimo izaberite lekara.</div>";
            }
        }
        ?>
    </div>

    <!-- Skripte za Bootstrap i jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"
        integrity="sha384-qyyMaHJ8YNL/RpOflXh5UAaAbE9UUOeF7S3Q3slXlqUj5VrQopdpR+DmoZl1Gc9x"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgpsFbYYAjpEYhLGH8ScsCbiD4QWdXOk8V7C6z6pR5K9U5g6Ucm"
        crossorigin="anonymous"></script>
</body>

</html>