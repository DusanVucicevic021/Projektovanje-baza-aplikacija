<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Unesi Pacijenta</title> 
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

        
        <form action="unesi_pacijenta.php" method="POST">

            <label for="ime_i_prezime">Ime i prezime:</label>
            <input type="text" id="ime_i_prezime" name="ime_i_prezime" required>
            

            <label for="datum_rodjenja">Datum rođenja:</label>
            <input type="date" id="datum_rodjenja" name="datum_rodjenja" required> 

            <label for="JMBG">JMBG:</label>
            <input type="text" id="JMBG" name="JMBG" required> 

            <label for="LBO">LBO:</label>
            <input type="text" id="LBO" name="LBO" required> 

            <label for="br_knjizice">Broj knjižice:</label>
            <input type="text" id="br_knjizice" name="br_knjizice" required> 

            <label for="izabrani_lekar">Izabrani lekar:</label>
            <select id="izabrani_lekar" name="izabrani_lekar"> 
                <option>Izaberite lekara</option>
                <option>dr Marko Jovanović</option>
                <option>dr Ana Petrović</option>
                <option>dr Jovana Popović</option>
                <option>dr Nikola Stojanović</option>
                <option>dr Milica Nikolić</option>
                <option>dr Stefan Đorđević</option>
                <option>dr Aleksandar Simić</option>
                <option>dr Filip Stevanović</option>
                <option>dr Ivana Lukić</option>
                <option>dr Marija Kovačević</option>
                <option>dr Luka Radovanović</option>
            </select>

            <button type="submit">Unesi Pacijenta</button> 
            <a href="ordinacija.php"><button type="button">Nazad na ordinaciju</button></a>
            
        </form>
    </div>

    <?php
    
    include_once ("php/baza.php");

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $ime_i_prezime = $_POST['ime_i_prezime'];
        $datum_rodjenja = $_POST['datum_rodjenja'];
        $JMBG = $_POST['JMBG'];
        $LBO = $_POST['LBO'];
        $br_knjizice = $_POST['br_knjizice'];
        $izabrani_lekar = $_POST['izabrani_lekar'];

        
        $sql = "INSERT INTO pacijenti (ime_i_prezime, datum_rodjenja, JMBG, LBO, br_knjizice, izabrani_lekar)
                VALUES ('$ime_i_prezime', '$datum_rodjenja', '$JMBG', '$LBO', '$br_knjizice', '$izabrani_lekar')";

        
        if ($mysqli->query($sql) === TRUE) {
            
            header("Location: ordinacija.php");
            exit();
        } else {
            
            echo "Greška prilikom dodavanja pacijenta: " . $mysqli->error;
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