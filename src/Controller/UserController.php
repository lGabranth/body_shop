<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/{id<\d+>?0}', name: 'user', methods: 'GET', schemes: 'https')]
    public function index(int $id, UserRepository $repository): Response
    {
			if ($id === 0 || is_null($user = $repository->find($id))) {
			
				die('Invalid user');
		
			}
			
	      return $this->json([
	        'user' => $user->toArray(),
	      ]);
    }
}
