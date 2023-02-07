<?php

namespace App\Controller\api;

use App\Entity\User;
use App\Form\EagleType;
use App\Repository\EagleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{

    /**
     * @throws JsonException
     */
    #[Route('/api/eagle', name: 'eagle', methods: ['POST'])]
    public function newEagle(Request $request, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $body = $request->getContent();
        $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        $eagle = new User($data);
        $form = $this->createForm(EagleType::class, $eagle);
        $form->submit($data);

        //if ($form->isSubmitted() && $form->isEmpty()) {
        //   throw new HttpException(422, 'Form should not be empty');
        //return $this->createValidationErrorResponse($form);
        //}

        // if ($form->isSubmitted() && !$form->isValid()) {
        //   throw new HttpException(400, 'Form should be valid');
        //$this->createValidationErrorResponse($form);
        // }

        $em->persist($eagle);
        $em->flush();

        $location = $this->generateUrl('show_eagle', [
            'id' => $eagle->getId()
        ]);
        //$data = $this->serializeEagles($eagle);
        $json = $serializer->serialize($eagle, 'json');
        $response = new JsonResponse($json, 201, [], true);
        $response->headers->set('Location', $location);
        return $response;
    }


    #[Route('/api/eagle/{id}', name: 'show_eagle', methods: ['GET'])]
    public function showEagle($id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, SerializerInterface $serializer): JsonResponse
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $eagle = $doctrine->getRepository(User::class)->find($id);

        if (!$eagle) {
            throw $this->createNotFoundException('No eagle found for this id=' . $id);
        }
        //$eagle = $entityManager->getRepository('User')->findOneBy($id);
        //$data = $this->serializeEagles($eagle);
        $json = $serializer->serialize($eagle, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/eagle/', name: 'list_eagle', methods: ['GET'])]
    public function listEagle(ManagerRegistry $doctrine, SerializerInterface $serializer, NormalizerInterface $normalizer): JsonResponse
    {
        $eagles = $doctrine->getRepository(User::class)->findAll();
        $json = $normalizer->normalize($eagles, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 200);
    }


    /**
     * @throws JsonException
     */
    #[Route('/api/eagle/{id}', name: 'update_eagle', methods: ['PUT', 'PATCH'])]
    public function updateEagle($id, Request $request, ManagerRegistry $doctrine, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $eagle = $doctrine->getRepository(User::class)->find($id);

        if (!$eagle) {
            throw $this->createNotFoundException('No eagle found for this id=' . $id);
        }

        $body = $request->getContent();
        $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        $form = $this->createForm(EagleType::class, $eagle);
        $clearMissing = $request->getMethod() !== 'PATCH';
        $form->submit($data, $clearMissing);
        if (!$form->isValid()) {
            $this->createValidationErrorResponse($form);
        }
        $em->persist($eagle);
        $em->flush();
        $json = $serializer->serialize($eagle, 'json');

        //$data = $this->serializeEagles($eagle);
        return new JsonResponse($json, 200, [], true);

    }

    #[Route('/api/eagle/{id}', methods: ['DELETE'])]
    public function deleteEagle($id, ManagerRegistry $doctrine, EntityManagerInterface $em): Response
    {
        $eagle = $doctrine->getRepository(User::class)->find($id);

        if ($eagle) {
            $em->remove($eagle);
            $em->flush();
        } else {
            throw $this->createNotFoundException('No eagle found for this id=' . $id);
        }
        return new Response(null, 204);
    }


    // get eagle image and phone number by id
    // works
    #[Route('/api/eagleimagephone', name: 'eagle_image_phone', methods: ['GET'])]
    public function getEaglePhone(EagleRepository $eagleRepository, SerializerInterface $serializer): JsonResponse
    {
        $eagle = $eagleRepository->findAll();
        $json = $serializer->serialize($eagle, 'json', [
            'groups' => 'list:read',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 200, [], true);
    }


}
