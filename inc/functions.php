<?php

define("TEXT_SEPARATOR", ", ");

function array_intersect_exact($array1, $array2) {
	
	// This compensates for duplicates.
	
	$result = array();
	
	foreach ($array1 as $val) {
		
		if ( ( $key = array_search($val, $array2, TRUE) ) !== false ) {
			
			$result[] = $val;
			
			unset( $array2[$key] );
			
		}
		
	}
	
	return $result;
	
}

function displayArray($a, $bAsCode, $sLanguage, $aRange) {
	
	// Display array as either a plain list or code for an array.
	
	$iCount = 0;
	
	if ( !isset($bAsCode) )
		$bAsCode = false;
	
	if ( !isset($sLanguage) )
		$sLanguage = "php";
	else
		$sLanguage = strtolower($sLanguage);
	
	if ( isset($aRange) )
		$a = array_slice($a, $aRange[0], $aRange[1]);
	
	if ($bAsCode): ?>
		
		<code>
			
			<?php if ($sLanguage == "js"): ?>
				
				<span class="keyword">var</span>
				
			<? endif; ?>
			
			<span class="variable">
				
				<?php if ($sLanguage == "php"): ?>$<?php endif; ?>aCodes
				
			</span>
			
			<span class="operator">=</span>
			
			<?php if ($sLanguage != "js" && $sLanguage != "rb"): ?>
				
				<span class="keyword">
					
					<?php if ($sLanguage == "php"): ?>
						
						a<?php elseif($sLanguage == "vb"): ?>A<?php endif; ?>rray</span><? endif; ?><span class="bracket"><?php if ($sLanguage != "vb" && $sLanguage != "php"): ?>[<?php else: ?>(<?php endif;?></span><?php
			
			// Output contents of array.
			
			foreach($a as $sValue) {
				
				$bMultiple = false;
				
				$iOccurrences = count( array_keys($a, $sValue) );
				
				if ( $iOccurrences > 1 )
					$bMultiple = true;
				
				// NEED TO DO SOMETHING WITH $bMultiple!!!!!!!  Add some notation or whatever.  Prevent it from being
				// output again?
				
				?><span class="string">"<?php
				
				print $sValue;
				
				?>"</span><?php
				
				$iCount++;
				
				// If it's not the last value in the array, add a separator after the output.
				
				if ( $iCount != count($a) )
					print TEXT_SEPARATOR;
				
			}
			
			?><span class="bracket"><?php if ($sLanguage != "vb" && $sLanguage != "php"): ?>]<?php else: ?>)<?php endif;?></span><?php if ($sLanguage == "php" || $sLanguage == "js"): ?>;<?php endif; ?>
			
		</code>
		
	<?php
	
	else:
		
		// If it's not code, simply implode it with the proper separator.
		
		print implode(TEXT_SEPARATOR, $a);
		
	endif;
	
}

function lsort($a, $b) {
	
	// Function to pass to usort that sorts by length.
	
	return strlen($b) - strlen($a);
	
}

function mark($sType) {
	
	import_request_variables("g");
	
	$sWord = "";
	
	if ($sType == "select" || $sType == "radio")
		$sWord = "selected";
	elseif ($sType == "checkbox")
		$sWord = "checked";
	
	print " $sWord=\"$sWord\"";
	
}