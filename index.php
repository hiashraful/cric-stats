<?php
$dbc = mysqli_connect('localhost', 'root', '12345', 'cric_stats');
if (!$dbc) {
    die('Error in connection.' . mysqli_connect_error());
}

$sql = 'SELECT DISTINCT country FROM player';
$result = $dbc->query($sql);
$options = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row['country'];
    }
}

function fetchPlayers($query)
{
    global $dbc;
    $playersResult = $dbc->query($query);
    $players = array();

    if ($playersResult->num_rows > 0) {
        while ($row = $playersResult->fetch_assoc()) {
            $players[] = $row;
        }
    }

    return $players;
}

//show players
if (isset($_POST["country"])) {
    $selectedCountry = $_POST["country"];
    $sql = "SELECT * FROM player WHERE country = '$selectedCountry' ORDER BY rank";
    $playersResult = $dbc->query($sql);
    $playerNames = fetchPlayers($sql);
}

$dbc->close();
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css' integrity='sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65' crossorigin='anonymous'>
    <link rel='stylesheet' href='style.css'>
    <title>Cric States</title>
</head>
<body>
    <div class='nav-bar'>
      <div class='heading'>
        <h3>Cric Stats</h3>
      </div>
      <div class='search'>
        <form class='search-container'>
          <a href='#'><img class='search-icon' src='http://www.endlessicons.com/wp-content/uploads/2012/12/search-icon.png'></a>
          <input type='text' id='search-bar' placeholder='Search for a country or player'>
        </form>
      </div>
    </div>
    <form action="" method="post" id="trigger">
        <input type="hidden" name="country" id="countrySelect">
    </form>
    <div class='side-bar'>
      <ul>
        <?php foreach ($options as $option): ?>
          <li><a href="#" onclick="selectCountry('<?php echo $option; ?>')"><?php echo $option; ?></a></li>
          <?php endforeach;?>
        </ul>    
    </div>
    <div class="show-player">
    <?php
if (isset($playerNames)) {
    foreach ($playerNames as $player) {
        echo "<div class='player-container'>
              <img src='img/shakib.png' alt='' id='img'>
              <div class='player'>
                <div class='player-details'>
                  <div id='icc' class='item'>
                    <h3 id='ranking'>" . $player['rank'] . "</h3>
                    <p>ICC Ranking</p>
                  </div>
                  <div id='line' class='item'></div>
                  <div id='name-type'>
                    <h4 id='name' class='item'>" . $player['name'] . "</h4>
                    <p id='p-type'>" . $player['type'] . "</p>
                  </div>
                </div>
                <div class='player-runs'>
                  <div id='odi' class='item'>
                    <h3>" . $player['odi'] . "</h3>
                    <p>odi runs</p>
                  </div>
                  <div id='t20' class='item'>
                    <h3>" . $player['t20'] . "</h3>
                    <p>t20 runs</p>
                  </div>
                  <div id='test' class='item'>
                    <h3>" . $player['test'] . "</h3>
                    <p>test runs</p>
                  </div>
                  <div id='wicket' class='item'>
                    <h3>" . $player['wicket'] . "</h3>
                    <p>total wickets</p>
                  </div>
                </div>
              </div>
            </div>";
    }
}
?>
</div>
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js' integrity='sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V' crossorigin='anonymous'></script>
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4' crossorigin='anonymous'></script>

  <script>
    function selectCountry(country) {
        document.getElementById('countrySelect').value = country;
        document.getElementById('trigger').submit();
        console.log('Form submitted');
    }
</script>

</body>
</html>
