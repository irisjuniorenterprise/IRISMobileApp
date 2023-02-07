<?php

namespace App\Controller\api;

use App\Repository\BlameRepository;
use App\Repository\EagleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BlameController extends AbstractController
{
    // find blame by eagle id
    // works
    #[Route('/api/blame/{id}', name: 'blame', methods: ['GET'])]
    public function findBlame($id, EagleRepository $eagleRepository, BlameRepository $blameRepository, SerializerInterface $serializer): JsonResponse
    {
        $eagle = $eagleRepository->find($id);
        $blames = $blameRepository->findBy(['eagle' => $eagle], [
            'date' => 'DESC'
        ]);
        $json = $serializer->serialize($blames, 'json', [
            'groups' => 'blame:read',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 200, [], true);
    }

}
