<?php

namespace App\Libraries;

Class MyLibrary 
{
	/**
	* Expects a string and converts it to it's greeklish equivalent
	* @param string
	*
	* @return string
	*/
	function greeklish($string) 
	{
		$greek   = array('α','ά','Ά','Α','β','Β','γ', 'Γ', 'δ','Δ','ε','έ','Ε','Έ','ζ','Ζ','η','ή','Η','θ','Θ','ι','ί','ϊ','ΐ','Ι','Ί', 'κ','Κ','λ','Λ','μ','Μ','ν','Ν','ξ','Ξ','ο','ό','Ο','Ό','π','Π','ρ','Ρ','σ','ς', 'Σ','τ','Τ','υ','ύ','Υ','Ύ','φ','Φ','χ','Χ','ψ','Ψ','ω','ώ','Ω','Ώ',' ',"'","'",',', '(', ')');
		$english = array('a', 'a','A','A','b','B','g','G','d','D','e','e','E','E','z','Z','i','i','I','th','TH', 'i','i','i','i','I','I','k','K','l','L','m','M','n','N','x','X','o','o','O','O','p','P' ,'r','R','s','s','S','t','T','u','u','Y','Y','f','F','x','X','ps','Ps','o','o','O','O','-','-','-','-', '-', '-');
		$string  = str_replace($greek, $english, $string);
		return $string;
	}

	/**
	* Convert a number to text
	* @param number
	*
	* @return string
	*/
	function numberToGreekText($number) 
	{
		$monades = ["", "ΕΝΑ ", "ΔΥΟ ", "ΤΡΙΑ ", "ΤΕΣΣΕΡΑ ", "ΠΕΝΤΕ ", "ΕΞΙ ", "ΕΠΤΑ ", "ΟΚΤΩ ", "ΕΝΝΙΑ ", "ΔΕΚΑ ", "ΕΝΤΕΚΑ ", "ΔΩΔΕΚΑ ", "ΔΕΚΑΤΡΙΑ "];
		$dekades = ["", "ΔΕΚΑ", "ΕΙΚΟΣΙ ", "ΤΡΙΑΝΤΑ ", "ΣΑΡΑΝΤΑ ", "ΠΕΝΗΝΤΑ ", "ΕΞΗΝΤΑ ", "ΕΒΔΟΜΗΝΤΑ ", "ΟΓΔΟΝΤΑ ", "ΕΝΝΕΝΗΝΤΑ "];
		$ekatontades = [ 
			["", "ΕΚΑΤΟΝ ", "ΔΙΑΚΟΣΙΕΣ ", "ΤΡΙΑΚΟΣΙΕΣ ", "ΤΕΤΡΑΚΟΣΙΕΣ ", "ΠΕΝΤΑΚΟΣΙΕΣ ", "ΕΞΑΚΟΣΙΕΣ ", "ΕΠΤΑΚΟΣΙΕΣ ", "ΟΚΤΑΚΟΣΙΕΣ ", "ΕΝΝΙΑΚΟΣΙΕΣ ", "ΧΙΛΙΕΣ "], 
			["", "ΕΚΑΤΟΝ ", "ΔΙΑΚΟΣΙΑ ", "ΤΡΙΑΚΟΣΙΑ ", "ΤΕΤΡΑΚΟΣΙΑ ", "ΠΕΝΤΑΚΟΣΙΑ ", "ΕΞΑΚΟΣΙΑ ", "ΕΠΤΑΚΟΣΙΑ ", "ΟΚΤΑΚΟΣΙΑ ", "ΕΝΝΙΑΚΟΣΙΑ ", "ΧΙΛΙΑ "], 
			["", "ΕΚΑΤΟΝ ", "ΔΙΑΚΟΣΙΟΙ ", "ΤΡΙΑΚΟΣΙΟΙ ", "ΤΕΤΡΑΚΟΣΙΟΙ ", "ΠΕΝΤΑΚΟΣΙΟΙ ", "ΕΞΑΚΟΣΙΟΙ ", "ΕΠΤΑΚΟΣΙΟΙ ", "ΟΚΤΑΚΟΣΙΟΙ ", "ΕΝΝΙΑΚΟΣΙΟΙ ", "ΧΙΛΙΟΙ "]
		];

		$poso    = floor($number);
		$decimal = ($number - $poso) * 100;

		$olografws = '';
		if ($poso == 0) { 
			return 'ΜΗΔΕΝ';
		}
		
		$e = intval($poso / 100);
		if ($e > 0) {
			($e == 1) ? $olografws = $ekatontades[0][$e] : $olografws = $ekatontades[1][$e] ;
		}

		$d = ($poso > 99) ? (intval($poso / 10) % 10) : ($poso / 10) ;
		if ($d > 0) { 
			$olografws .= ' '.$dekades[$d];
		}

		$m = ($poso % 10);
		if ($m > 0) {
			$olografws .= ' '.$monades[$m];
		}

		$olografws .= ' ΕΥΡΩ';

		if ($decimal > 0) { 
			$olografws .= ' ΚΑΙ ';

			$dec_e = intval($decimal / 10);
			$dec_m = $decimal % 10;

			($dec_e > 0) ? $olografws .= $dekades[$dec_e] : '';
			($dec_m > 0) ? $olografws .= $monades[$dec_m] : '';
			$olografws .= ' ΛΕΠΤΑ';
		}

		return $olografws;
	}

}
?>