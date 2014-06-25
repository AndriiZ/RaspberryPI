<?php
  $dbh = new PDO('sqlite:/home/pi/src/dht22/weather.sl3');
  $temperature = array();
  $humidity = array();

  $mode = $_GET["mode"];
  $delta = $_GET["delta"];
  if ($mode==="delta" &&  is_numeric($delta) === FALSE) {
    $mode = "last";
  } else {
    $delta = $delta / 1000;
 }


  $timezone = "'-3 hour'";

  $sql = "SELECT * FROM weather";
  switch($mode)
  {
    case "today":
      $sql = "select * from weather where time > datetime('now', 'start of day', " . $timezone . ")";
      break;
    case "last":
	$sql = "SELECT * FROM weather order by time desc limit 1";
      break;
    case "delta":
	$sql =  "select * from weather where time > datetime('".$delta."','unixepoch')";
	break;
    case "dbn":
      $sql = "select * from weather where time > datetime('now', '-1 day', "  . $timezone . ")";
      break; 
    case "week":
      $sql = "select * from weather where time > datetime('now', 'weekday 0', '-7 day', "  . $timezone . ")";
      break;
    case "wtn":
      $sql = "select * from weather where time > datetime('now', '-7 day', "  . $timezone . ")";
      break;
    case "mtn":
      $sql = "select * from weather where time > datetime('now', '-1 month', "  . $timezone . ")";
     break;
    case "month":
      $sql = "select * from weather where time > datetime('now', 'start of month', "  . $timezone . ")";
     break;
    case "ytn":
      $sql = "select * from weather where time > datetime('now', '-1 year', "  . $timezone . ")";
     break;
    case "year":
      $sql = "select * from weather where time > datetime('now', 'start of year', "  . $timezone . ")";
     break;
    default: 
      $mode = "all (default)";
  }

  $i = 0;
  foreach($dbh->query($sql) as $row)
  {
    $time = new DateTime($row[0], new DateTimezone('UTC'));
    $temperature[] = array($time->getTimestamp()*1000, round($row[1],2));
    $humidity[] = array($time->getTimestamp()*1000, round($row[2],2));
    $i++;
  }

  ob_start("ob_gzhandler");
  header('Content-type: application/json');
  $rows = array("mode" => $mode, "count" => $i, "temperature" => $temperature, "humidity" => $humidity/*, "sql" => $sql*/);
  echo json_encode($rows, JSON_NUMERIC_CHECK);
  header('Content-Length: ' . ob_get_length());
?>
