<?php

namespace App\Controller\api;

use App\Entity\User;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class TokenController extends AbstractController
{
    /**
     * @throws JWTEncodeFailureException
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    // works
    #[Route('/api/tokens', methods: ['POST'])]
    public function newTokenAction(Request $request,EntityManagerInterface $em, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher, JWTEncoderInterface $JWTEncoder, NormalizerInterface $normalizer): JsonResponse
    {
        // convert request content to array
        $data = $request->toArray();
        $tokenFcm = $data['fcmtoken'];
        // fetch an eagle from the database with the requested email
        $user = $doctrine->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        //$eagle = $serializer->serialize($user, 'json');
        $eagle = $normalizer->normalize($user, 'json', [
            'circular_reference_handler' => function ($object){
                return $object->getId();
            }
        ]);

        // if it's not the user: throw NotFoundException
        if(!$user)
        {
            return new JsonResponse(['message' => 'User not found'], 404);
        }

        // Checks if the plaintext password given in the request  matches the user's password in the database.
        $result = $passwordHasher->isPasswordValid($user, $data['password']);

        // return a BadCredentialsException if the given password in the request does not match the user's password in the database.
        if ($result === false)
            {
                return new JsonResponse(['message' => 'Wrong password'], 404);
            }
        // hash the password given in the request.
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        //$user = new User();
        $user->setTokenFcm($tokenFcm);
        $em->flush();

        // encode the token with user's email and an hour for expiration time
        $token = $JWTEncoder->encode([
            'email' => $data['email'],
            'exp' => time() + 3600,
        ]);

        // return the token generated
        return new JsonResponse(
            [
            'token' => $token,
                'user' => $eagle
        ]
        );
    }

}