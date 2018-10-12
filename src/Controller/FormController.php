<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FormController extends AbstractController
{
    /**
     * @Route("/product/new", name="product_new")
     */
    public function new(Request $request)
    {
		$form = $this->createForm(ProductType::class);

		$form->handleRequest($request);

	    if ($form->isSubmitted() && $form->isValid()) {
	        // $form->getData() holds the submitted values
	        // but, the original `$task` variable has also been updated
	        $task = $form->getData();

	        // ... perform some action, such as saving the task to the database
	        // for example, if Task is a Doctrine entity, save it!
         	$entityManager = $this->getDoctrine()->getManager();
         	$entityManager->persist($task);
         	$entityManager->flush();

			$this->addFlash('success', 'Produs created!');

	        return $this->redirectToRoute('product_show');
	    }

		return $this->render('form/form.html.twig', [
			'controller_name' => 'FormController',
			'productForm' => $form->createView()
		]);
    }
    
    /**
	 * @Route("/product/edit/{id}", name="product_edit")
	 */
	public function update($id, Request $request)
	{
	    $entityManager = $this->getDoctrine()->getManager();
	    $product = $entityManager->getRepository(Product::class)->find($id);

	    if (!$product) {
	        throw $this->createNotFoundException(
	            'No product found for id '.$id
	        );
	    }

		$form = $this->createForm(ProductType::class, $product);

		$form->handleRequest($request);			
		
	    if ($form->isSubmitted() && $form->isValid()) {
	        
	        $name = $form->get('name')->getData();
	        $price = $form->get('price')->getData();
	        $description = $form->get('description')->getData();

		    $product->setName($name);
		    $product->setPrice($price);
		    $product->setDescription($description);
		    
		    $entityManager->flush();

			$this->addFlash('success', 'Produs edited!');

	        return $this->redirectToRoute('product_show');
	    }		

		return $this->render('form/form.html.twig', [
			'controller_name' => 'FormController',
			'productForm' => $form->createView()
		]);
	}
}