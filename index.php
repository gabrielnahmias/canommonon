<?php

/**
 * Canommonon v1.0.0
 * http://github.com/terrasoftlabs/canommonon
 *
 * Copyright © 2012 Gabriel Nahmias.
 * Free to use under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * TODO: Make it so if there's more than one of a certain value it is somehow denoted in the results.
 *		 Add Selectify to the results and code areas.
 *	
 */

require "inc/functions.php";

define("NAME", "Canommonon");
define("VER", "1.0.0");

if ( !isset( $_GET['format'] ) ):

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=NAME?> v<?=VER?></title>

<link href="img/favicon.ico" rel="shortcut icon" />

<link href="css/styles.css" rel="stylesheet" type="text/css" />

</head>

<body>

<?php

endif;

if ( !empty($_GET) ) {
	
	import_request_variables("g");
	
	if ( !isset($operation) || empty($operation) || $operation == "common" ) {
		
		// Kind of a weird grouping of logic but it works.
		
		$operation = "common";
		
		$sAdj = "Common";
		
	} else {
		
		$sAdj = "Uncommon";
		
	}
	
	if ( isset($format) )
		$sFormat = strtolower($format);
	
	if ( isset($first) && isset($second) ) {
		
		$aFirst = explode(",", $first);
		$aSecond = explode(",", $second);
		
		if ( isset($debug) && !isset($sFormat) ) {
			
			print "<div class=\"debugging\">\r\n<strong>First set as array:</strong><br />";
			
			print_r($aFirst);
			
			print "\r\n<br />\r\n<br /><strong>Second set as array:</strong>\r\n<br />";
			
			print_r($aSecond);
			
			print "\r\n<br />\r\n<br /><strong>Entire <em>\$_GET</em> array:</strong>\r\n<br />";
			
			print_r($_GET);
			
			print "\r\n</div>";
			
		}
		
		// Compare the two sets of values.
		
		if ($operation == "common") {
			
			$aResults = array_intersect($aFirst, $aSecond);
			
		} else {
					
			$aResults = array_diff($aFirst, $aSecond);
			
		}
		
		// Sort the results by length.
		
		//usort($aResults, 'lsort');
		
	} else {
		
		// Move error display here.
		
	}
	
	if ( !isset($sFormat) ):
	
?>

<h2>
	
	<label class="red title underlined"><?=$sAdj?> Values:</label>
	
	<div>
		
		<?php @displayArray($aResults, false); ?>
		
	</div>
	
</h2>

<fieldset class="centered code">
	
	<legend>Code for Arrays Containing these Values</legend>
	
	<p>
		
		<strong>PHP:</strong>
		
		<?php @displayArray($aResults, true); ?>
		
	</p>
	
	<p>
		
		<strong>Visual Basic:</strong>
		
		<?php @displayArray($aResults, true, "vb"); ?>
		
	</p>

</fieldset>

<?php
	
	else:
		
		// Return JSON.
		
		if ($sFormat == "json") {
			
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-type: application/json');
			
		}
		
		if ( !isset($first) || !isset($second) ) {
			
			// Error message.
			
			if ($sFormat == "json")
				print '{ error: \'';
			
			print 'One of either "first" or "second" GET variables undefined.';
			
			if ($sFormat == "json")
				print '\' }';
				
		} else {
			
			// TODO: Keep adding more options.
			
			$iCount = 0;
			
			if ($sFormat == "json")
				print "{ common: [";
			
			foreach($aResults as $sValue) {
				
				print "\"$sValue\"";
				
				if ( array_key_exists($iCount + 1, $aResults) )
					print ", ";
				
				$iCount++;
				
			}
			
			if ($sFormat == "json")
				print "] }";
			
		}
		
	endif;
	
}

if ( !isset( $_GET['format'] ) ):
	
	if ( !isset( $_GET['hideform'] ) ):
		
?>

<form action="" method="get">
	
	<fieldset class="centered">
		
		<legend>Value Sets to Compare</legend>
			
			<div class="centered">
				
				<textarea cols="50" name="first" placeholder="Enter first set of comma-separated values" rows="15"><?=@$first?></textarea>
				
				<textarea cols="50" name="second" placeholder="Enter second set of comma-delimited values" rows="15"><?=@$second?></textarea>
				
				<select name="operation">
					
					<option value="">Select comparative operation</option>
					
					<option<?php if ( $operation == "common" || !isset($operation) ): ?> selected="selected"<?php endif; ?> value="common">Show common values</option>
					
					<option<?php if ($operation == "uncommon"): ?> selected="selected"<?php endif; ?> value="uncommon">Show uncommon values</option>
					
				</select>
				
				<input type="submit" value="Compare" />
				
			</div>
		
	</fieldset>

</form>

</body>

</html>

<?php
		
	endif;
	
endif;

?>