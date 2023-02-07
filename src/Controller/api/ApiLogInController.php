<?php

namespace App\Controller\api;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLogInController extends AbstractController
{
    /**
     * @throws JWTEncodeFailureException
     */
    #[Route('/api/login/fake', name: 'api_login_fake')]
    public function index(#[CurrentUser] ?User $user, JWTEncoderInterface $JWTEncoder): Response
    {
        if (null === $user)
        {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
       }


        $token = $JWTEncoder->encode([
            'email' => $user->getUserIdentifier(),
            'exp' => time() + 3600,
        ]);

        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }
}