<?php

function displayArray($a, $bAsCode, $sLanguage, $aRange) {
	
	// Display array as either a plain list or PHP code for an array.
	
	if ( !isset($bAsCode) )
		$bAsCode = false;
	
	if ( !isset($sLanguage) )
		$sLanguage = "php";
	else
		$sLanguage = strtolower($sLanguage);
	
	if ( isset($aRange) )
		$a = array_slice($a, $aRange[0], $aRange[1]);
	
	$iCount = 0;
	
	if ($bAsCode): ?><code><span class="variable"><?php if ($sLanguage == "php"): ?>$<?php endif; ?>aCodes</span> <span class="operator">=</span> <span class="keyword"><?php if ($sLanguage == "php"): ?>a<?php elseif($sLanguage == "vb"): ?>A<?php endif; ?>rray</span><span class="bracket">(</span><?php endif;
	
	foreach($a as $sValue) {
		
		if ($bAsCode): ?><span class="string">"<?php endif;
		
		print $sValue;
		
		if ($bAsCode): ?>"</span><?php endif;
		
		if ( array_key_exists($iCount + 1, $a) )
			print ", ";
		
		$iCount++;
		
	}
	
	if ($bAsCode): ?><span class="bracket">)</span><?php if ($sLanguage == "php"): ?>;<?php endif; ?></code><?php endif;
	
}

function lsort($a, $b) {
	
	// Function to sort by length
	
	return strlen($b) - strlen($a);
	
}