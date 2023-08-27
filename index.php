<?php
$dbc = mysqli_connect('localhost', 'root', '12345', 'test');
if (!$dbc) {
    die("Error in connection." . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["input_country"])) {
        $inputCountry = $_POST["input_country"];
        $inputPlayer = $_POST["player"];
        $inputRank = $_POST["rank"];
        $sql = "INSERT INTO country (country, player, rank) VALUES ('$inputCountry', '$inputPlayer', '$inputRank')";
        $dbc->query($sql);
    }

    if (isset($_POST["country"])) {
        $selectedCountry = $_POST["country"];
        $sql2 = "SELECT * FROM country WHERE country = '$selectedCountry' ORDER BY rank ASC";
        $playersResult = $dbc->query($sql2);
        $playerNames = array();

        if ($playersResult->num_rows > 0) {
            while ($row = $playersResult->fetch_assoc()) {
                $playerNames[] = $row;
            }
        }
    }
    //for multi delete
    if (isset($_POST["multiDeleteCountry"])) {
        $mCountry = $_POST["multiDeleteCountry"];
        $sql2 = "SELECT * FROM country WHERE country = '$mCountry' ORDER BY rank ASC";
        $playersResult = $dbc->query($sql2);
        $mPlayers = array();

        if ($playersResult->num_rows > 0) {
            while ($row = $playersResult->fetch_assoc()) {
                $mPlayers[] = $row;
            }
        }
    }
    //Delete multiple players
    if (isset($_POST["multiDeleteCountry"])) {
        $mc = $_POST["multiDeleteCountry"];
        $sql2 = "SELECT * FROM country WHERE country = '$mc' ORDER BY rank ASC";
        $playersResult = $dbc->query($sql2);
        $multiDeletePlayers = array();

        if ($playersResult->num_rows > 0) {
            while ($row = $playersResult->fetch_assoc()) {
                $multiDeletePlayers[] = $row;
            }
        }
    }
    if (isset($_POST['mPlayer'])) {
        $num = 0;
        foreach ($_POST['mPlayer'] as $pl) {
            $sql = "DELETE FROM country WHERE player = '$pl'";
            $dbc->query($sql);
            $num++;
        }
    }

    //Search Player
    if (isset($_POST["playerName"])) {
        $playerName = $_POST["playerName"];
        $sql3 = "SELECT * FROM country WHERE player = '$playerName'";
        $result = $dbc->query($sql3);
        $results = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }
        }
    }

    // Update player
    if (isset($_POST["updateCountry"])) {
        $ucInput = $_POST["updateCountry"];
        $upInput = $_POST["updatePlayer"];
        $urInput = $_POST["updateRank"];
        $uId = $_POST["updateId"];
        $sql3 = "UPDATE country SET country = '$ucInput', player='$upInput', rank='$urInput' WHERE id='$uId'";
        if ($dbc->query($sql3)) {
            $updated = "updated";
        }
    }

    // Add Multiple Player
    if (isset($_POST["multipleCountry"])) {
        $multipleCountry = $_POST["multipleCountry"];
        $multipleInput = $_POST["multiplePlayer"];
        $multipleRank = $_POST["multipleRank"];
        $multiplePlayers = explode(",", $multipleInput);
        foreach ($multiplePlayers as $singlePlayer) {
            $sql = "INSERT INTO country (country, player, rank) VALUES ('$multipleCountry', '$singlePlayer', '$multipleRank')";
            $dbc->query($sql);
            $multipleRank++;
        }
    }

    //Delete player
    if (isset($_POST["playerDelete"])) {
        $deletePlayer = $_POST["playerDelete"];
        $sql = "DELETE FROM country WHERE player = '$deletePlayer'";
        if ($dbc->query($sql)) {
            $deleted = $deletePlayer . " is deleted from database";
        }
    }
}

$sql = "SELECT DISTINCT country FROM country";
$result = $dbc->query($sql);
$options = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row["country"];
    }
}

$dbc->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Cric States</title>
</head>
<body>
    <div class="nav-bar">
      <div class="heading">
        <h3>Cric Stats</h3>
      </div>
      <div class="search">
        <form class="search-container">
          <a href="#"><img class="search-icon" src="http://www.endlessicons.com/wp-content/uploads/2012/12/search-icon.png"></a>
          <input type="text" id="search-bar" placeholder="Search for a country or player">
        </form>
      </div>
    </div>
    <div class="side-bar">
      <ul>
      <?php foreach ($options as $option): ?>
        <li><a href="#" onclick="selectCountry('<?php echo $option; ?>')"><?php echo $option; ?></a></li>
      <?php endforeach;?>
      </ul>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
