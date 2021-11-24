<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    #[Route('/get_item/{id<\d+>?}', name: 'get_item', methods: 'GET', schemes: 'https')]
    public function getItem(?int $id, ItemRepository $repository): Response
    {
			if (is_null($id)) {
				die('Invalid request');
			}
			
      return $this->json([
          'item' => $repository->find($id),
      ]);
    }
		
		#[Route('/create_item', name: 'item', methods: 'POST', schemes: 'https')]
    public function createItem(Request $request, ItemRepository $repository): Response
    {
			$name = $request->get('name');
			$price = $request->get('price');
			if (is_null($name) || is_null($price)) {
				die('Please, enter valid data');
			}
			
			$item = new Item();
			$item->setName($name)
				->setPrice($price)
			;
			
			$code = 200;
			$message = 'Item added !';
	
	    try {
		   $repository->add($item);
	    } catch (OptimisticLockException | ORMException $e) {
				$code = 500;
				$message = 'Item not added !';
	    }
	
	    return $this->json([
        'code' => $code,
		    'message' => $message
      ]);
    }
}
