<?php

namespace App\Controller\api;

use App\Entity\Task;
use App\Repository\EagleRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TaskController extends AbstractController
{

    // works
    #[Route('/api/task/add', name: 'add_task', methods: ['POST'])]
    public function addTask(Request $request, TaskRepository $taskRepository, SerializerInterface $serializer, EagleRepository $eagleRepository): JsonResponse
    {
        $body = $request->toArray();
        //dd(DateTime::createFromFormat('H:i a', $body['startTime']));
        $eagle = $eagleRepository->find($body['eagleId']);
        $task = new Task();
        $task->setTitle($body['title']);
        $task->setNote($body['note']);
        $task->setDate(DateTime::createFromFormat('Y-m-d H:i:s', $body['date']));
        $task->setStartTime(DateTime::createFromFormat('H:i a', $body['startTime']));
        $task->setEndTime(DateTime::createFromFormat('H:i a', $body['endTime']));
        $task->setRemind($body['remind']);
        $task->setRepetition($body['repetition']);
        $task->setColor($body['color']);
        $task->setIsCompleted(false);
        $task->setIsPersonal(true);
        $task->setCreatedAt(new DateTime());
        $task->setEagle($eagle);
        $task->setDepartment($eagle?->getDepartment());
        $taskRepository->add($task, true);
        $json = $serializer->serialize($task, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 200, [], true);
    }



    // get all tasks by eagle id and department
    // works
    #[Route('/api/task/get/{id}', name: 'get_tasks', methods: ['GET'])]
    public function getTask($id, TaskRepository $taskRepository,EagleRepository $eagleRepository, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $eagle = $eagleRepository->find($id);
        $tasks = $taskRepository->findBy([
            'eagle' => $eagle,
            'department' => [$eagle?->getDepartment(), 'ALL'],
        ]);
        $json = $serializer->serialize($tasks, 'json', [
            'groups' => 'task:read',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 200, [], true);
    }


    // delete task
    // works
    #[Route('/api/task/delete/{id}', name: 'delete_task', methods: ['DELETE'])]
    public function deleteTask($id, TaskRepository $taskRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $task = $taskRepository->find($id);
        if ($task) {
            $entityManager->remove($task);
            $entityManager->flush();
            return new JsonResponse('Task deleted', 200, [], true);
        }
        return new JsonResponse('Task not found', 404, [], true);
    }

    // mark task as completed
    // works
    #[Route('/api/task/completed/{id}', name: 'completed_task', methods: ['PUT'])]
    public function completeTask($id, TaskRepository $taskRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $task = $taskRepository->find($id);
        if ($task) {
            $task->setIsCompleted(true);
            $entityManager->persist($task);
            $entityManager->flush();
            return new JsonResponse('Task completed', 200, [], true);
        }
        return new JsonResponse('Task not found', 404, [], true);
    }

}
