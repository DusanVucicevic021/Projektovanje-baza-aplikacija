<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Unos dijagnoze</title> 
    <link rel="stylesheet" href="css/style.css"> 
    <style>
        
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
            border: 2px solid #2F4858;
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
            <h1>Unesi Pacijenta</h1> 
        </header>

        
        <form action="dijagnoza.php" method="post">
            <label for="br_kartona">Broj kartona pacijenta:</label><br>
            <input type="text" id="br_kartona" name="br_kartona" required><br><br>

            <label for="naziv">Naziv dijagnoze:</label><br>
            <input type="text" id="naziv" name="naziv" required><br><br>

            <label for="opis">Opis dijagnoze:</label><br>
            <textarea id="opis" name="opis" style="width: 100%;" rows="10" required></textarea><br><br>

            <button type="submit">Unesi dijagnozu</button> 
            <a href="ordinacija.php"><button type="button">Nazad na ordinaciju</button></a>
            
        </form>
    </div>
</body>

</html>

<?php

include_once("php/baza.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $br_kartona = $_POST['br_kartona'];
    $naziv = $_POST['naziv'];
    $opis = $_POST['opis'];

    
    $check_sql = "SELECT * FROM dijagnoze WHERE br_kartona = '$br_kartona' AND naziv = '$naziv'";

    
    $check_result = $mysqli->query($check_sql);

    
    if ($check_result->num_rows > 0) {
        echo "Dijagnoza već postoji za ovog pacijenta.";
    } else {
        
        $sql = "INSERT INTO dijagnoze (br_kartona, naziv, opis)
                VALUES ('$br_kartona', '$naziv', '$opis')";

        
        if ($mysqli->query($sql) === TRUE) {
            
            header("Location: ordinacija.php");
            exit();
        } else {
            
            echo "Greška prilikom dodavanja dijagnoze: " . $mysqli->error;
        }
    }

    
    $mysqli->close();
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