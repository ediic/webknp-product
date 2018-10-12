<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;

class ProductController extends AbstractController
{
	/**
	* @Route("/admin") 
	*/
	public function admin()
	{
		return new Response('<html><body>Admin page!</body></html>');	
	}
    
    /**
     * @Route("/product", name="product")
     */
    public function index(Request $request)
    {
//       $entityManager = $this->getDoctrine()->getManager();
//       
//       $product = new Product();
//       $product->setName('Keyboard');
//	     $product->setPrice(1999);
//	     $product->setDescription('Ergonomic and stylish!');
//
//       // tell Doctrine you want to (eventually) save the Product (no queries yet)
//       $entityManager->persist($product);
//
//       // actually executes the queries (i.e. the INSERT query)
//       $entityManager->flush();
		$answer = $request->query->get('t');
			
	    return new Response('Saved new product with id '.$answer);
    }
    
    /**
 	* @Route("/product/show", name="product_show")
 	*/
	public function show()
	{
	    $repository = $this->getDoctrine()->getRepository(Product::class);
	    
	    // look for a single Product by its primary key (usually "id")
		//$product = $repository->find($id);

		// look for a single Product by name
		//$product = $repository->findOneBy(['name' => 'Keyboard']);

		$products = $repository->findAll();

	    if (!$products) {
	        throw $this->createNotFoundException('No product found!');
	    	}

       return $this->render('index/index.html.twig', [
            'controller_name' => 'product_show',
            'products' => $products,
            
       ]);
	 }
	 
    /**
 	* @Route("/product/show/price", name="product_price")
 	*/
	public function showPrice(Request $request)
	{
		if($request->getMethod() == Request::METHOD_POST){
			$price = $request->request->get('price');
		}
		
		$products = $this->getDoctrine()
	    ->getRepository(Product::class)
	    ->findAllGreaterThanPrice($price);
		
	    if (!$products) {
	    throw $this->createNotFoundException('No product found for '.$price);
	    }
       
       return $this->render('product/price.html.twig', [
            'controller_name' => 'product_price',
            'products' => $products,
            
       ]);		
	 }	 
	
	/**
	 * @Route("/product/remove/{id}", name="product_remove")
	 */
	public function remove($id)
	{
	    $entityManager = $this->getDoctrine()->getManager();
	    $product = $entityManager->getRepository(Product::class)->find($id);
		
		//$answer = $request->query->get('t');

	    if ($product) {
	        $entityManager->remove($product);
	    	$entityManager->flush();
	    }

        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll(); 
        
        return $this->render('index/index.html.twig', [
            'controller_name' => 'product_removed',
            'products' => $products,
            
       ]);				
	}	
}
