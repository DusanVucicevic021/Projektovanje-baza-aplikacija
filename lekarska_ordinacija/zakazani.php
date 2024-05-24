<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Zakazani termini</title> 
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
            <a href="ordinacija.php"><button type="button">Nazad na ordinaciju</button></a>
            
        </header>

        <?php
        
        include_once ("php/baza.php");

        
        $sql = "SELECT zt.datum_vreme_zakazivanja, zt.br_kartona, zt.ime_i_prezime, p.izabrani_lekar 
                FROM zakazani_termini zt
                INNER JOIN pacijenti p ON zt.br_kartona = p.br_kartona
                ORDER BY zt.datum_vreme_zakazivanja ASC";

        
        $result = $mysqli->query($sql);

        
        if ($result->num_rows > 0) {
            
            echo "<table border='1'>";
            echo "<tr><th>Vreme zakazivanja</th><th>Broj kartona</th><th>Ime i prezime</th><th>Izabrani lekar</th></tr>";

            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['datum_vreme_zakazivanja'] . "</td>";
                echo "<td>" . $row['br_kartona'] . "</td>";
                echo "<td>" . $row['ime_i_prezime'] . "</td>";
                echo "<td>" . $row['izabrani_lekar'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Nema zakazanih termina."; 
        }

        
        $result->free();
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