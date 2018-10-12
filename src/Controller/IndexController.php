<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{    
    /**
	* @Route("/index/unu", name="unu")
	*/
	public function unu()
	{
		return new Response(
			'<html><body>Ruta unu</body></html>'	
		);	
	}
}
