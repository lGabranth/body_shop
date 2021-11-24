<?php

namespace App\Controller;

use App\Entity\Role;
use App\Repository\RoleRepository;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
{
	//Route d'affichages de tous les rôles
	#[Route('/roles', name: 'roles', methods: 'GET', schemes: 'https')]
	public function getRoles(RoleRepository $repository) : Response {
		return $this->json([
			'roles' => array_map(static function ($elem) {
				return $elem->toArray();
			}, array: $repository->findAll())
		]);
	}
	
	//Route création d'un rôle
	#[Route('/role', name: 'add_role', methods: ['POST', 'PATCH'], schemes: 'https')]
	public function createRole(Request $request, RoleRepository $repository) : Response {
		// Check si méthode PATCH ET id ET role exist
		if ($request->isMethod('PATCH') && (is_null($id = (int)$request->get('id'))
			|| is_null($role = $repository->find($id)))
		) {
			die('That won\'t do');
		}
		
		// Dans tous les cas si name !null
		$name = $request->get('name');
		if (is_null($name)) {
			die('That won\'t do');
		}
		
		$canRead = $request->get('can_read', false);
		$canWrite = $request->get('can_write', false);
		$canUpdate = $request->get('can_update', false);
		$canDelete = $request->get('can_delete', false);
		$role = new Role();
		$role->setName($name)
			->setCanRead($canRead)
			->setCanWrite($canWrite)
			->setCanUpdate($canUpdate)
			->setCanDelete($canDelete)
		;
		
		try {
			$repository->add($role);
			$code = 200;
			$message = $request->isMethod('UPDATE') ? $role->toArray() : 'Role added';
		} catch (\Doctrine\ORM\ORMException $e) {
			$code = 500;
			$message = 'Role not addded';
		}
		
		return $this->json([
			'code' => $code,
			'message' => $message
		]);
	}
	
	//Route d'affichage d'un rôle
	#[Route('/get_role/{id<\d+>?}', name: 'role', methods: 'GET', schemes: 'https')]
	public function getRole(?int $id, RoleRepository $repository) : Response {
		if (is_null($id) || is_null($role = $repository->find($id))) {
			die('Role doesn\'t exist');
		}
		
		return $this->json([
			'role' => $role->toArray()
		]);
	}
}
