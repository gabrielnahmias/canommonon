<?php

/*!
 * Canommonon v1.1.0
 * http://github.com/terrasoftlabs/canommonon
 *
 * Copyright © 2012 Gabriel Nahmias.
 * Free to use under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * TODO: *Add debugging output to all the output formats!!*
 *		 Make it so if there's more than one of a certain value it is somehow denoted in the results.
 *		 Add Selectify to the results and code areas.
 *		 Add sorting options
 *		 
 */

require "inc/functions.php";

define("NAME", "Canommonon");
define("VER", "1.1.0");

$operation = "";

// Should move this and parse variables for everything appropriately?

import_request_variables("g");

if ( isset($format) && $format == "normal" )
	unset($format);

// If there's no format, display doctype, head, meta, title, and related tags.

if ( !isset($format) ):

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=NAME?> v<?=VER?></title>

<link href="img/favicon.ico" rel="shortcut icon" />

<link href="css/styles.css" rel="stylesheet" type="text/css" />

<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

<script src="js/jquery.selectify.min.js" type="text/javascript"></script>
<script src="js/scripts.js" type="text/javascript"></script>

</head>

<body>

<?php

endif;

if ( !empty($_GET) ) {
	
	if ( !isset($operation) || empty($operation) || $operation == "common" ) {
		
		// Kind of a weird grouping of logic but it works.
		
		$operation = "common";
		
		$sAdj = "Common";
		
	} else {
		
		$sAdj = "Uncommon";
		
	}
	
	$bDuplicates = false;
	$bShowCode = false;
	
	if ( isset($showduplicates) )
		$bDuplicates = true;
	
	if ( isset($showcode) )
		$bShowCode = true;
	
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
			
			$aResults = array_intersect_exact($aFirst, $aSecond);
			
		} else {
					
			$aResults = array_diff($aFirst, $aSecond);
			
		}
		
		if (!$bDuplicates) {
			
			$aResults = array_unique($aResults);
			
		}
		
		// Sort the results by length.
		
		//usort($aResults, 'lsort');
		
	} else {
		
		// Move error display here.
		
	}
	
	// If there is no format specified, output HTML.
	
	if ( !isset($sFormat) ):
	
?>

<h2>
	
	<label class="red title underlined"><?=$sAdj?> Values (<?=count($aResults)?>):</label>
	
	<div>
		
		<?php @displayArray($aResults, false); ?>
		
	</div>
	
</h2>

<?php if ($bShowCode): ?>

<fieldset class="centered code">
	
	<legend>Code for Arrays Containing these Values</legend>
	
	<p>
		
		<strong>PHP:</strong>
		
		<?php @displayArray($aResults, true); ?>
		
	</p>
	
	<p>
		
		<strong>JavaScript:</strong>
		
		<?php @displayArray($aResults, true, "js"); ?>
		
	</p>
	
	<p>
		
		<strong>Ruby:</strong>
		
		<?php @displayArray($aResults, true, "rb"); ?>
		
	</p>
	
	<p>
		
		<strong>Visual Basic:</strong>
		
		<?php @displayArray($aResults, true, "vb"); ?>
		
	</p>

</fieldset>

<?php endif; ?>

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
				
				$iCount++;
				
				if ( $iCount != count($aResults) )
					print ", ";
				
			}
			
			if ($sFormat == "json")
				print "] }";
			
		}
		
	endif;
	
}

if ( !isset( $_GET['hideform'] ) ):
	
	// I'm not sure which arrangement is correct; check hideform or format first.
	
	if ( empty($format) || $format == "normal" ):
	
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
				
				<div id="checkboxes">
					
					<input id="showduplicates" name="showduplicates" type="checkbox"<?php if ( isset($showduplicates) ): if ($showduplicates) mark("checkbox"); endif; ?> /><label for="showduplicates">Show duplicate values</label>
					
					<input id="hideform" name="hideform" type="checkbox"<?php if ( isset($hideform) ): if ($hideform) mark("checkbox"); endif; ?> /><label for="hideform">Hide form</label>
					
					<input id="showcode" name="showcode" type="checkbox"<?php if ( isset($showcode) ): if ($showcode) mark("checkbox"); endif; ?> /><label for="showcode">Show code</label>
					
					<input id="debug" name="debug" type="checkbox"<?php if ( isset($debug) ): if ($debug) mark("checkbox"); endif; ?> /><label for="debug">Debug</label>
					
				</div>
				
				<div id="radio_format">
					
					<label class="pointless">Return format:</label>
					
					<input id="format_normal" name="format" value="normal" type="radio"<?php if ( isset($format) ): if ($format == "text") mark("radio"); endif; ?> /><label for="format_normal">Normal</label>
					<input id="format_json" name="format" value="json" type="radio"<?php if ( isset($format) ): if ($format == "json") mark("radio"); endif; ?> /><label for="format_json">JSON</label>
					<input id="format_text" name="format" value="text" type="radio"<?php if ( isset($format) ): if ($format == "text") mark("radio"); endif; ?> /><label for="format_text">Text</label>
					
				</div>
				
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