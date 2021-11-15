<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Security\ApiKeyAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;

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

    public function authenticate(Request $request): PassportInterface
    {
        $password = $request->request->get('password');
        $username = $request->request->get('username');
        $csrfToken = $request->request->get('csrf_token');

        return new Passport(
            new UserBadge($username),
            new PasswordCredentials($password),
            [new CsrfTokenBadge('login', $csrfToken)]
        );
    }

    public function generateToken()
    {
        // fonction de creation de token de secours
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

//    public function createAuthenticatedToken(PassportInterface $passport, string $firewallName): TokenInterface
//    {
//        // read the attribute value
//        // Necessite symfony 5.1
//        //return new CustomOauthToken($passport->getUser(), $passport->getAttribute('scope'));
//    }
}
