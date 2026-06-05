<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/signup', name: 'app_signup', methods: ['GET', 'POST'])]
    public function signup(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            return $this->redirectToRoute('app_signup_success');
        }

        return $this->render('signup.html.twig');
    }

    #[Route('/signup/success', name: 'app_signup_success', methods: ['GET'])]
    public function signupSuccess(): Response
    {
        return $this->render('signup_success.html.twig');
    }

    // Test this API endpoint with
    //   curl -X POST 'http://localhost/api/v1/users' -H "X-AUTH-TOKEN: token" -H "Content-Type: application/json" -d '{"name": "dom", "email": "dom@lesmills.net.au"}'

    #[Route('/api/v1/users', name: 'app_create_user', methods: ['POST'])]
    public function createUser(Request $request): Response
    {
        $payload = $request->toArray();
        
        $data = [
            'name'  => $payload['name'] ?? null,
            'email' => $payload['email'] ?? null,
        ];
        return $this->json($data);
    }
}