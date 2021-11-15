<?php

namespace App\Controller;

use App\Repository\RoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
{
	//TODO: Route d'affichages de tous les rôles
	#[Route('/roles', name: 'roles', methods: 'GET', schemes: 'https')]
	public function getRoles(RoleRepository $repository) : Response {
		return $this->json([
			'roles' => array_map(static function ($elem) {
				return $elem->toArray();
			}, array: $repository->findAll())
		]);
	}
	
	//TODO: Route d'affichage d'un rôle
	#[Route('/role/{id<\d+>?}', name: 'role', methods: 'GET', schemes: 'https')]
	public function getRole(?int $id, RoleRepository $repository) : Response {
		if (is_null($id) || is_null($role = $repository->find($id))) {
			die('Role doesn\'t exist');
		}
		
		return $this->json([
			'role' => $role->toArray()
		]);
	}
	
	//TODO: Route création d'un rôle
	
	//TODO: Route de modification d'un rôle
	//TODO: Route de suppression d'un rôle
}
