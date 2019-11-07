<?php
	include '/var/www/html/php/db_conn.php';
        $pipe = new db_Conn();

	$output = shell_exec("curl -s 'https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=MSFT&apikey=demo'");

	$dat2 = json_decode($output, TRUE);
	preg_match_all('/(.+?)\sPrices.+$/m', $dat2["Meta Data"]["1. Information"], $mstr, PREG_SET_ORDER, 0);
	$freq = strtolower($mstr[0][1]);
	$sym = strtolower($dat2["Meta Data"]["2. Symbol"]);
	$lr = $dat2["Meta Data"]["3. Last Refreshed"];
	$os = strtolower($dat2["Meta Data"]["4. Output Size"]);
	$stmnt = 'INSERT INTO dev_testing_environment.time_series_meta(created, frequency, symbol, last_refreshed, output_size) VALUES(CURDATE(),"' . $freq . '","' . $sym . '","' . $lr . '","' . $os . '");';
	
	$pipe->send_insert($stmnt);
	$id = $pipe->get_last_id();

	foreach($dat2["Time Series (Daily)"] as $entry => $values) {
		$o = $values["1. open"];
		$h = $values["2. high"];
		$l = $values["3. low"];
		$c = $values["4. close"];
		$v = $values["5. volume"];
		$stmnt = 'INSERT INTO dev_testing_environment.time_series_data(meta_id,open,high,low,close,volume) VALUES(' . $id . "," .  $o . "," . $h . "," . $l . "," . $c . "," . $v . ');';
		$pipe->send_insert($stmnt);
	}
	
?>
