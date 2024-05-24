<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Podaci o pacijentima</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
    
    body {
        font-family: Arial, sans-serif;
    }

    
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

    <header>
        <h1>Podaci o pacijentima</h1>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <nav>
                <span>Izaberite lekara:</span>
                <select name="izabrani_lekar">
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
                <button type="submit">Prikaži pacijente</button>
            </nav>
        </form>
    </header>

    
    <div style="text-align: center; margin-top: 20px;">
        <a href="zakazi_termin.php"><button>Zakazi termin</button></a>
        <a href="unesi_pacijenta.php"><button>Unesi novog pacijenta</button></a>
        <a href="recepti.php"><button>Unesi recept</button></a>
        <a href="dijagnoza.php"><button>Unesi dijagnozu</button></a>
        <a href="zakazani.php"><button>Zakazani pacijenti</button></a>
        <a href="istorija.php"><button>Istorija</button></a>
    </div>

    <br>

    <?php
    
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lekarska_ordinacija";

    
    $mysqli = new mysqli($host, $username, $password, $dbname);
    if ($mysqli->connect_error) {
        die('Error:(' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
    }

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['izabrani_lekar']) && !empty($_POST['izabrani_lekar'])) {
            $selectedDoctor = $_POST['izabrani_lekar'];
            echo "<h2>Izabrani lekar: " . $selectedDoctor . "</h2>";

            
            $query = $mysqli->query("SELECT * FROM pacijenti WHERE izabrani_lekar = '$selectedDoctor'");

            
            if ($query) {
                if ($query->num_rows > 0) {
                    
                    echo '<table>';
                    echo '<tr><th>Broj kartona</th><th>Ime i prezime</th><th>Datum rođenja</th><th>JMBG</th><th>LBO</th><th>Broj knjižice</th></tr>';
                    
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
                    echo '</table>';
                } else {
                    
                    echo "<div style='text-align: center; margin-top: 50px;'><p>Nema pacijenata za izabranog lekara.</p></div>";
                }
            } else {
                
                echo "<div style='text-align: center; margin-top: 50px;'><p>Greška u izvršavanju upita: " . $mysqli->error . "</p></div>";
            }
        } else {
            
            echo "<div style='text-align: center; margin-top: 50px;'><p>Molimo izaberite lekara.</p></div>";
        }
    }
    ?>

    
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