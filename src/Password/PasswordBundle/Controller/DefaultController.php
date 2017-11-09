<?php

namespace Password\PasswordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/remove_extra_blanks" name="remove_extra_blanks")
     * @Method({"GET"})
     */
    public function indexAction($password)
    {
    	// $password = $_GET["password"];

    	$strength = calculateStrengthPassword($password);
		return $this->render(json_encode(array("strength" => $strength)));
    }

    private function countDigits($string)
 	{
 		return strlen(preg_replace('/[^\d]/','',$string));
 	}

 	private function numberUpperCaseCharacters($string)
 	{
 		return strlen(preg_replace('/[^A-Z]/','',$string));
 	}

 	private function numberLowerCaseCharacters($string)
 	{
		return strlen(preg_replace('/[^a-z]/', '', $string));
 	}

 	private function countNumberAllSymbolRepetitionsInString($text)
 	{
 		$mapSymbols = [];
 		foreach (str_split($text) as $value) {
 			if (!isset($mapSymbols[$value])) {
 				$mapSymbols[$value] = 0;
 			}
 			$mapSymbols[$value] += 1;
 		}

 		$numberAllRepetitions = 0;
 		foreach ($mapSymbols as $value) {
 			$numberAllRepetitions += $value - 1;
 		}
 		return $numberAllRepetitions;
 	}

 	private function calculateStrengthPassword($password)
 	{
 		$strength = 0;
		$passwordLength = strlen($password);
		$strength += 4 * $passwordLength;
		$strength += 4 * countDigits($password);
		$strength += (($passwordLength - numberUpperCaseCharacters($password)) * 2);
		$strength += (($passwordLength - numberLowerCaseCharacters($password)) * 2);

		if (ctype_alpha($password)) {	
			$strength = $strength - $passwordLength;
		}

		if (ctype_digit($password) == 1) {
			$strength -= $passwordLength;
		}

		$countAllRepetitions = countNumberAllSymbolRepetitionsInString($password);
		$strength -= $countAllRepetitions;
		return $strength;
 	}
}
