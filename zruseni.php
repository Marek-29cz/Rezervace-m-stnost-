<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS.css">
    <title>Zrušení rezervace</title>
</head>

<body>
<nav>
      <div>
        <a href="rezervace.php">Rezervace místností</a>
      </div>
      <div>
        <a href="zruseni.php">Zrušení rezervace</a>
      </div>
      <div>
        <a href="tabulka.php">Tabulka s rezervacemi</a>
      </div>
    </nav>


    <h1>Zrušení rezervace</h1>
    <div class="texty">
        <form action="" method="get">
        <label for="zruseni">Zadej ID rezervace</label>
        <input type="number" name="zruseni" id="zruseni">
        <input type="submit" name="tlacitko"value="Zrušit rezervaci">
        </form>
    </div>

</body>
</html>


<?php
$soubor="data.json";
$data = json_decode(file_get_contents($soubor), true);

if (isset($_GET["tlacitko"])) {
    if ($data !== null) {
        foreach ($data as $key => $item) {
            if ($item['id'] == $_GET["zruseni"]) {
                unset($data[$key]);
                echo '<div class="vypis">Rezervace byla úspěšně odstraněna.</div>';
                break; 
            } else{
                echo '<div class="vypis">Rezervace neexistuje.</div>';
                break;
                }
    }
    $jsonData = json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if (!file_put_contents($soubor, $jsonData)) {
        echo '<div class="vypis">Chyba při ukládání dat.</div>';
        } 
    } else {
    echo '<div class="vypis">Chyba při čtení JSON souboru.</div>';
    }


    
}

?>

<footer>
  
    <p>Marek Duffek</p>
    <p>2024</p>

</footer>
