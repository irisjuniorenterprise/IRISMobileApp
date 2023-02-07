<?php

namespace App\Controller\api;

use App\Entity\BiblioIRIS;
use App\Repository\BiblioIRISRepository;
use App\Repository\EagleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class LibraryController extends AbstractController
{
    #[Route('/api/library/add', name: 'add_library', methods: ['POST'])]
    public function setLibrary(Request $request, EagleRepository $eagleRepository, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $body = $request->toArray();
        $eagle = $eagleRepository->find($body['eagleId']);
        $library = new BiblioIRIS();
        $library->setContent($body['content']);
        $library->setFiles($body['files']);
        $library->setPostedBy($eagle);
        $em->persist($library);
        $em->flush();
        $json = $serializer->serialize($library, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 201, [], true);
    }

    // get all iris biblio
    // works
    #[Route('/api/irisbiblio', name: 'irisbiblio', methods: ['GET'])]
    public function getIrisBiblio(BiblioIRISRepository $irisBiblioRepository, SerializerInterface $serializer): JsonResponse
    {
        $irisBiblios = $irisBiblioRepository->findAll();
        $json = $serializer->serialize($irisBiblios, 'json', [
            'groups' => 'library:read',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 200, [], true);
    }


}
