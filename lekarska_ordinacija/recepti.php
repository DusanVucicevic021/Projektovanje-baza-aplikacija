<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unos recepta</title>
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
            <h1>Unos recepta</h1>
        </header>

        
        <form method="post" action="recepti.php">
            <label for="br_kartona">Broj kartona:</label><br>
            <input type="number" id="br_kartona" name="br_kartona" required><br>

            <label for="br_knjizice">Broj knjižice:</label><br>
            <input type="number" id="br_knjizice" name="br_knjizice" required><br>

            <label for="lek">Lek:</label><br>
            <input type="text" id="lek" name="lek" required><br>

            <label for="nacin_upotrebe">Način upotrebe:</label><br>
            <textarea id="nacin_upotrebe" name="nacin_upotrebe" rows="7" style="width: 100%;" required></textarea><br>

            <button type="submit">Unesi recept</button>
            <a href="ordinacija.php"><button type="button">Nazad na ordinaciju</button></a>
        </form>
    </div>

    <?php
    
    include_once ("php/baza.php");

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $sql = "INSERT INTO recepti (br_kartona, br_knjizice, lek, nacin_upotrebe) VALUES (?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            
            $stmt->bind_param("iiss", $param_br_kartona, $param_br_knjizice, $param_lek, $param_nacin_upotrebe);

            
            $param_br_kartona = $_POST['br_kartona'];
            $param_br_knjizice = $_POST['br_knjizice'];
            $param_lek = $_POST['lek'];
            $param_nacin_upotrebe = $_POST['nacin_upotrebe'];

            
            if ($stmt->execute()) {
                echo "Podaci su uspešno uneti.";
            } else {
                echo "Greška prilikom izvršavanja upita: " . $stmt->error;
            }

            
            $stmt->close();
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