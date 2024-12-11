<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS.css">
    <title>Tabulka s rezervacemi</title>
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
<h1>Tabulka s rezervacemi</h1> 






</body>

</html>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Jméno</th>
            <th>Místnost</th>
            <th>Od</th>
            <th>Do</th>
            <th>Datum</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = file_get_contents('data.json');
        $data = json_decode($data, true);

        usort($data, function($a, $b) {
          return strcmp($a['datum'], $b['datum']);
      });

      foreach ($data as $item) {
        
        $datum = date('d. m. Y', strtotime($item['datum']));
        
            echo "<tr>";
            echo "<td>" . $item['id'] . "</td>";
            echo "<td>" . $item['jmeno'] . "</td>";
            echo "<td>" . $item['mistnost'] . "</td>";
            echo "<td>" . $item['cas_od'] . "</td>";
            echo "<td>" . $item['cas_do'] . "</td>";
            echo "<td>" . $datum . "</td>";
            echo "</tr>";
        }
      
        ?>
    </tbody>
</table>
</body>

<footer>
  
    <p>Marek Duffek</p>
    <p>2024</p>

</footer>
