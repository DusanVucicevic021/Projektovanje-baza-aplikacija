<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Lekarska ordinacija</title> 
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
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h2>Istorija pacijenta</h2> 
            <a href="ordinacija.php"><button type="button">Nazad na ordinaciju</button></a>
            
        </header>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="br_kartona">Unesite broj kartona pacijenta:</label><br>
            <input type="text" id="br_kartona" name="br_kartona" style="width: 300px; font-size:25px;"><br><br>
            <button type="submit">Pretraži</button><br><br>
        </form>

        <?php
        
        include_once ("php/baza.php");

        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $br_kartona = $_POST['br_kartona'];

            
            $sql = "SELECT p.br_kartona, p.ime_i_prezime, p.jmbg, p.br_knjizice, d.naziv, d.opis, r.lek
            FROM pacijenti p
            LEFT JOIN dijagnoze d ON p.br_kartona = d.br_kartona
            LEFT JOIN recepti r ON p.br_kartona = r.br_kartona
            WHERE p.br_kartona = '$br_kartona'";

            
            $result = $mysqli->query($sql);

            
            if ($result->num_rows > 0) {
                
                echo "<h2>Podaci o pacijentu</h2>";

                
                echo "<table>";
                echo "<tr><th>Broj kartona</th><th>Ime i prezime</th><th>JMBG</th><th>Broj knjižice</th><th>Naziv dijagnoze</th><th>Opis dijagnoze</th><th>Lek</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['br_kartona'] . "</td>";
                    echo "<td>" . $row['ime_i_prezime'] . "</td>";
                    echo "<td>" . $row['jmbg'] . "</td>";
                    echo "<td>" . $row['br_knjizice'] . "</td>";
                    echo "<td>" . $row['naziv'] . "</td>";
                    echo "<td>" . $row['opis'] . "</td>";
                    echo "<td>" . $row['lek'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                
                echo "<br><h3>Nema rezultata za uneti broj kartona.</h3>";
            }

            
            $result->free();
        }

        
        $mysqli->close();
        ?>
    </div>
    
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