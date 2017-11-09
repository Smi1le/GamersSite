<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class RemoveExtraBlanksController extends Controller
{
    /**
     * @Route("/remove_extra_blanks", name="remove_extra_blanks")
     * @Method({"GET"})
     */
    public function removeExtraBlanks()
    {
    	$text = $_GET["text"];
		return new Response($this->removeAllExtraSpaces($text));
    }

 	private function removeAllExtraSpaces($text)
	{
		$text = preg_replace("/  +/", " ", $text);
		if (strcasecmp(" ", substr($text, 0, 1)) == 0) {
			$text = substr($text, 1);
		}
		return $text;
	}
}
