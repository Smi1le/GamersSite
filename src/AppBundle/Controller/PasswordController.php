<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class PasswordController extends Controller
{
    /**
     * @Route("/password_strength", name="password_strength")
     * @Method({"GET"})
     */
    public function passwordStrength()
    {
    	$password = $_GET["password"];
    	$strength = $this->calculateStrengthPassword($password);
		return new Response(json_encode(array("strength" => $strength)));
    }

 	private function calculateStrengthPassword($password)
 	{
 		$strength = 0;
		$passwordLength = strlen($password);
		$strength += 4 * $passwordLength;
		$strength += 4 * $this->countDigits($password);
		$strength += (($passwordLength - $this->numberUpperCaseCharacters($password)) * 2);
		$strength += (($passwordLength - $this->numberLowerCaseCharacters($password)) * 2);

		if (ctype_alpha($password)) {	
			$strength = $strength - $passwordLength;
		}

		if (ctype_digit($password) == 1) {
			$strength -= $passwordLength;
		}

		$countAllRepetitions = $this->countNumberAllSymbolRepetitionsInString($password);
		$strength -= $countAllRepetitions;
		return $strength;
 	}

	 private function countDigits($string)
 	{
 		return strlen(preg_replace("/[^\d]/",'',$string));
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
	
	
}
