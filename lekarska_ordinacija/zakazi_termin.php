<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Zakazi termin</title> 
    <link rel="stylesheet" href="css/style.css"> 
</head>
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

<body>

    <div class="container">
        <header>
            <h1>Zakazi Termin</h1> 
        </header>

        <div class="form-container">
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                
                Broj kartona: <input type="text" name="br_kartona" required><br><br>
                Ime i prezime: <input type="text" name="ime_i_prezime" required><br><br>
                Datum i vreme zakazivanja:
                <input type="datetime-local" id="datum_vreme_zakazivanja" name="datum_vreme_zakazivanja" required
                    step="900" min="<?php echo $trenutno_vreme; ?>" max="<?php echo $datum_vreme_max; ?>">

                <button type="submit">Zakaži termin</button> 
                <a href="ordinacija.php"><button type="button">Nazad na ordinaciju</button></a>
                
            </form>

            <?php
            
            function proveri_radno_vreme($datum_vreme_zakazivanja)
            {
                
                $datum_vreme_zakazivanja = str_replace("T", " ", $datum_vreme_zakazivanja);

                
                $termin_vreme = date_create_from_format('Y-m-d H:i', $datum_vreme_zakazivanja);

                
                $pocetak_radnog_vremena = date_create($termin_vreme->format('Y-m-d') . ' 07:00');
                $kraj_radnog_vremena = date_create($termin_vreme->format('Y-m-d') . ' 20:00');

                
                if ($termin_vreme === false) {
                    return false;
                }

                
                if ($termin_vreme >= $pocetak_radnog_vremena && $termin_vreme <= $kraj_radnog_vremena) {
                    return true; 
                } else {
                    return false; 
                }
            }

            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $br_kartona = $_POST['br_kartona']; 
                $ime_i_prezime = $_POST['ime_i_prezime']; 
                $datum_vreme_zakazivanja = $_POST['datum_vreme_zakazivanja'];
            
                
                if (!proveri_radno_vreme($datum_vreme_zakazivanja)) {
                    echo "Uneli ste termin: [$datum_vreme_zakazivanja]. Molimo izaberite termin između 07:00 i 20:00.";
                } else {
                    
                    $host = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "lekarska_ordinacija";

                    
                    $conn = new mysqli($host, $username, $password, $dbname);

                    
                    if ($conn->connect_error) {
                        die("Neuspela konekcija: " . $conn->connect_error);
                    }

                    
                    $check_query = "SELECT * FROM zakazani_termini WHERE datum_vreme_zakazivanja = '$datum_vreme_zakazivanja'";
                    $result = $conn->query($check_query);
                    if ($result->num_rows > 0) {
                        echo "Već postoji zakazani termin u izabranom vremenskom intervalu.";
                    } else {
                        
                        $sql = "INSERT INTO zakazani_termini (br_kartona, ime_i_prezime, datum_vreme_zakazivanja) 
                    VALUES ('$br_kartona', '$ime_i_prezime', '$datum_vreme_zakazivanja')";

                        
                        if ($conn->query($sql) === TRUE) {
                            echo "Termin je uspešno zakazan.";
                        } else {
                            echo "Greška prilikom zakazivanja termina: " . $conn->error;
                        }
                    }

                    
                    $conn->close();
                }
            }
            ?>

        </div>
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