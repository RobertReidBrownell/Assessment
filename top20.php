<!DOCTYPE html>
<html>
<head>
	<title>Fishing Results</title>
</head>
<body>
	<h1>Top 20 Fishing Results</h1>
	<table>
		<tr>
			<th>Types of fish caught</th><th>Times this outcome was observed</th>
		</tr>
		<?php
        //pull the data and then decode it so that PHP can use it
		$jsonData = json_decode(file_get_contents('https://liquid.fish/fishes.json'));
		//initialize the $results variable as an array
		$results = array();
		//Pull the objects out as $fishingTrip
		foreach ($jsonData as $fishingTrip){
			//initialize the $tripFish variable as an array to hold each trip set of fish
			$tripFish = array();
			//using the property of fish_caught loop through the object
			foreach ($fishingTrip->fish_caught as $fishCaught){
				//check in the $tripFish array for any instances of the current $fishCaught variable
				if(!in_array($fishCaught, $tripFish)) {
					//If there is not already an example of it in the array then add it
					$tripFish[] = $fishCaught;

				}
			}//end of foreach loop

			//Sort the $tripFish variable so that no matter the order the fish were brought into the variable they will be uniform
			sort($tripFish);
			//Count how many fish are in the array so that you can format the output
			$typesCount = count($tripFish);
			//if the $typesCount is equal to 2 then simply add implode the array and add an and between the two
			if($typesCount == 2) {

				$tripResult = implode(' and ', $tripFish);
			//if the $typesCount is greater than or equal to 3 then append an and before the last element of the array and then implode adding a comma
			} elseif ($typesCount >= 3) {

				$tripFish[$typesCount - 1] = 'and ' . $tripFish[$typesCount - 1];

				$tripResult = implode(', ', $tripFish);
				//if the previous two failed then there is only one fish and simply implode the array to a string
			} else {

				$tripResult = implode('', $tripFish);
			}
		//if the $results array does not already have an index matching the $tripResults  then set the value to 0
		if(!isset($results[$tripResult]))  { $results[$tripResult] = 0; }
			//increment the $tripResult by 1
			$results[$tripResult]++;
		}// end of initial foreach loop

		//Sort the array by the $tripResult value keeping the index intact
		arsort($results);
		//set the variable $resultKeys to the results of pulling all the keys out of the $results variable
		$resultKeys = array_keys($results);
		//Loop through the following statement twenty times to get the top 20 fishing results.
		for ($i = 0; $i < 20; $i++){

			echo '<tr><td>'.$resultKeys[$i].'</td><td>'.$results[$resultKeys[$i]].'</td></tr>';
		}
		?>
	</table>
</body>
</html>