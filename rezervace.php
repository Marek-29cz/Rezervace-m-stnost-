<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS.css">
    <title>Rezervace místností</title>
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
</body>

</html>

  <h1>Přidání rezervace</h1>
  <div class="texty">
    <form action="" method="get">
      <label for="mistnost">Název místnosti</label>
      <select name="mistnost" id="mistnost">
      <option value="konferenční místnost 1">konferenční místnost 1</option>
      <option value="konferenční místnost 2">konferenční místnost 2</option>
      <option value="zasedací místnost 1">zasedací místnost 1</option>
      <option value="zasedací místnost 2">zasedací místnost 2</option>
      <option value="společenská místnost 1">společenská místnost 1</option>
      <option value="společenská místnost 2">společenská místnost 2</option>
      </select>
      <br>
      <label for="datum">Datum rezervace</label>
      <input type="date" name="datum" id="datum">
      <br>
      <label for="cas_od">Čas rezervace Od</label>
      <input type="time" name="cas_od" id="cas_od">
      <label for="cas_do">Do</label>
      <input type="time" name="cas_do" id="cas_do">
      <br>
      <label for="jmeno">Jméno rezervace</label>
      <input type="text" name="jmeno" id="jmeno">
      <br>
      <label for="tlacitko">Potvrzení rezervace</label>
      <input type="submit" name="tlacitko" value="potvrdit">
    </form>
  </div>



<?php


$soubor="data.json";
#$soubor = file_get_contents($soubor);
$existujiciData = [];
if (file_exists($soubor)) {
    $existujiciData = json_decode(file_get_contents($soubor), true);
}




if (isset($_GET["tlacitko"])) 
 { if (
    !empty($_GET["jmeno"]) AND       #zjišťuje jestli jsou vyplněné všechny informace
    !empty($_GET["mistnost"]) AND
    !empty($_GET["datum"]) AND
    !empty($_GET["cas_od"]) AND
    !empty($_GET["cas_do"])
      ){
    if (($_GET["cas_od"])<($_GET["cas_do"])) { #validace času
      if ($_GET["datum"]>date("Y-m-d")){     #validace datumu
        
        $kolize = false;
        foreach ($existujiciData as $rezervace) {   #validace již zarezervované místnosti
          if (
            $rezervace['datum'] === $_GET['datum'] AND 
            $rezervace['mistnost'] === $_GET['mistnost'] AND 
            !( # kontrola, zda časy nepřekrývají
              $_GET['cas_do'] <= $rezervace['cas_od'] OR
              $_GET['cas_od'] >= $rezervace['cas_do']
            )
            ) {
              $kolize = true;
              echo '<div class="vypis">Místnost je již zarezervovaná v daném čase.</div>';
              break;
              }
              }
          if (!$kolize) {
            $maxId = 0;
                foreach ($existujiciData as $rezervace) {
                    if ($rezervace['id'] > $maxId) {
                        $maxId = $rezervace['id'];
                    }
                }
                $id = $maxId + 1;
                
            $novaData=["id" => $id,
                      "jmeno" => trim(htmlspecialchars(strip_tags($_GET["jmeno"]))),       #uklada načtená data do proměné
                      "mistnost" => $_GET["mistnost"],
                      "datum" => $_GET["datum"],
                      "cas_od" => $_GET["cas_od"],
                      "cas_do" => $_GET["cas_do"]];

            $existujiciData[]=$novaData;     #ukládá nová data do existujících dat 
    
            if (file_put_contents($soubor, json_encode($existujiciData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {    #ukládá data do souboru 
              echo '<div class="vypis">Rezervace byla úspěšně přidána.</div>';
            } else {
                echo '<div class="vypis">Chyba při ukládání nových dat.</div>';
            } 
          } 
      } else {
          echo '<div class="vypis">Datum musí být v budoucnu</div>' ;
        } 
    } else {
        echo '<div class="vypis">Čas začátku musí být dříve než čas konce</div>' ;
        }
  } else {
      echo '<div class="vypis">Špatně vyplněná rezervace</div>';
    }  
  }



?>

<footer>
  
    <p>Marek Duffek</p>
    <p>2024</p>

</footer>
