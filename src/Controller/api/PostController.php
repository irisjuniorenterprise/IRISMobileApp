<?php

namespace App\Controller\api;

use App\Entity\Announcement;
use App\Entity\AttendanceApproval;
use App\Entity\AttendanceDisapproval;
use App\Entity\Comment;
use App\Entity\Polling;
use App\Repository\AnnouncementRepository;
use App\Repository\AttendanceApprovalRepository;
use App\Repository\AttendanceDisapprovalRepository;
use App\Repository\CommentRepository;
use App\Repository\EagleRepository;
use App\Repository\EngagementPostRepository;
use App\Repository\MeetingRepository;
use App\Repository\PollingRepository;
use App\Repository\PollOptionRepository;
use App\Repository\PollRepository;
use App\Repository\PostRepository;
use App\Repository\TrainingRepository;
use App\Repository\WorkshopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class PostController extends AbstractController
{
    /**
     */
    // works
    #[Route('/api/post/{target}', name: 'list_post', methods: ['GET'])]
    public function listPost($target, AnnouncementRepository $announcementRepository, TrainingRepository $trainingRepository, WorkshopRepository $workshopRepository, MeetingRepository $meetingRepository, SerializerInterface $serializer, NormalizerInterface $normalizer, PostRepository $postRepository, PollRepository $pollRepository, Request $request): JsonResponse
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        $type = $request->headers->get('type');
        if ($type === '' || $type === 'all') {
            $posts = $postRepository->findBy([
                'targets' => [$target, 'ALL'],
            ], [
                'publishDate' => 'DESC',
            ]);
        }
        if ($type === 'poll') {
            $polls = $pollRepository->findAll();
            foreach ($polls as $poll) {
                $posts[] = $poll->getPost();
                // filter by target
                $targets = $poll->getPost()?->getTargets();
            }
            if (!in_array($target, (array)$targets, true) && !in_array('ALL', (array)$targets, true)) {
                unset($posts[array_search($poll->getPost(), $posts, true)]);
            }
            // reverse order
            $posts = array_reverse($posts);
        }
        if ($type === 'announcement') {
            $announcements = $announcementRepository->findAll();
            foreach ($announcements as $announcement) {
                $posts[] = $announcement->getPost();
                $targets = $announcement->getPost()?->getTargets();
            }
            // filter by target
            if (!in_array($target, (array)$targets, true) && !in_array('ALL', (array)$targets, true)) {
                unset($posts[array_search($announcement->getPost(), $posts, true)]);
            }
            // reverse order
            $posts = array_reverse($posts);
        }
        if ($type === 'workshop') {
            $workshops = $workshopRepository->findAll();
            foreach ($workshops as $workshop) {
                $posts[] = $workshop->getWorkPost()?->getEngagementPost()?->getPost();
                $targets = $workshop->getWorkPost()?->getEngagementPost()?->getPost()?->getTargets();
            }
            // filter by target
            if (!in_array($target, (array)$targets, true) && !in_array('ALL', (array)$targets, true)) {
                unset($posts[array_search($workshop->getWorkPost()?->getEngagementPost()?->getPost(), $posts, true)]);
            }
            // reverse order
            $posts = array_reverse($posts);
        }
        if ($type === 'meeting') {
            $meetings = $meetingRepository->findAll();
            foreach ($meetings as $meeting) {
                $posts[] = $meeting->getWorkPost()?->getEngagementPost()?->getPost();
                $targets = $meeting->getWorkPost()?->getEngagementPost()?->getPost()?->getTargets();
            }
            // filter by target
            if (!in_array($target, (array)$targets, true) && !in_array('ALL', (array)$targets, true)) {
                unset($posts[array_search($meeting->getWorkPost()?->getEngagementPost()?->getPost(), $posts, true)]);
            }
            // reverse order
            $posts = array_reverse($posts);
        }
        if ($type === 'training') {
            $trainings = $trainingRepository->findAll();
            foreach ($trainings as $training) {
                $posts[] = $training->getEngagementPost()?->getPost();
                $targets = $training->getEngagementPost()?->getPost()?->getTargets();
            }
            // filter by target
            if (!in_array($target, (array)$targets, true) && !in_array('ALL', (array)$targets, true)) {
                unset($posts[array_search($training->getEngagementPost()?->getPost(), $posts, true)]);
            }
            // reverse order
            $posts = array_reverse($posts);
        }
        $json = $serializer->serialize($posts, 'json', [
            'groups' => 'post:read',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
        ]);
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json'], true);
    }

    // works
    #[Route('/api/approve', name: 'approve_attendance', methods: ['POST'])]
    public function attendanceApproval(Request $request, AttendanceApprovalRepository $attendanceApprovalRepository, EntityManagerInterface $em, SerializerInterface $serializer, EngagementPostRepository $engagementPostRepository, EagleRepository $eagleRepository): JsonResponse
    {
        //$this->denyAccessUnlessGranted('ROLE_USER');
        $body = $request->toArray();
        $engagementPost = $engagementPostRepository->find($body['engagementPost']);
        $eagle = $eagleRepository->find($body['eagleId']);
        // check if the eagle is already approved for this engagement post
        $approvedEagles = $attendanceApprovalRepository->findAll();
        foreach ($approvedEagles as $approvedEagle) {
            if ($approvedEagle->getEagle()->getId() === $eagle->getId() && $approvedEagle->getEngagementPost()->getId() === $engagementPost->getId()) {
                return new JsonResponse('already Approved', 400, [], true);
            }
        }
        $attendanceApproval = new AttendanceApproval($body);
        $attendanceApproval->setEagle($eagle);
        $attendanceApproval->setEngagementPost($engagementPost);
        $attendanceApproval->setDate(new DateTime());
        $em->persist($attendanceApproval);
        $em->flush();
        $json = $serializer->serialize($attendanceApproval, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 201, [], true);
    }

    // works
    #[Route('/api/disapprove', name: 'disapprove_text', methods: ['POST'])]
    public function onlyJustification(Request $request, AttendanceDisapprovalRepository $attendanceDisapprovalRepository, EntityManagerInterface $em, SerializerInterface $serializer, EngagementPostRepository $engagementPostRepository, EagleRepository $eagleRepository)
    {
        $body = $request->toArray();
        $attendanceDisapproval = new AttendanceDisapproval();
        // check if the eagle is already disapproved for this engagement post
        $disapprovedEagles = $attendanceDisapprovalRepository->findAll();
        foreach ($disapprovedEagles as $disapprovedEagle) {
            if ($disapprovedEagle->getEagle()->getId() === $body['eagle'] && $disapprovedEagle->getEngagementPost()->getId() === $body['engagementPost']) {
                return new JsonResponse('already Disapproved', 400, [], true);
            }
        }
        $engagementPost = $engagementPostRepository->find($body['engagementPost']);
        $eagle = $eagleRepository->find($body['eagle']);
        $attendanceDisapproval->setDate(new DateTime());
        $attendanceDisapproval->setEngagementPost($engagementPost);
        $attendanceDisapproval->setEagle($eagle);
        $attendanceDisapproval->setJustification($body['justification']);
        $em->persist($attendanceDisapproval);
        $em->flush();
        $json = $serializer->serialize($attendanceDisapproval, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 201, [], true);
    }

    // works
    #[Route('/api/img', name: 'img_post_disapproval', methods: ['POST'])]
    public function convertImage(Request $request, EngagementPostRepository $engagementPostRepository, EagleRepository $eagleRepository, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse|Response
    {
        $justification = $request->headers->get('justification');
        $eagleId = $request->headers->get('eagleId');
        $engagementPostId = $request->headers->get('engagementPostId');
        $file = $_FILES['file']['name'];
        $tmpFile = $_FILES['file']['tmp_name'];
        $target_dir = 'C:\Users\MSI\Desktop\IRIS\2\\';
        $target_file = $target_dir . basename(($_FILES['file']['name']));
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            $attendanceDisapproval = new AttendanceDisapproval();
            $engagementPost = $engagementPostRepository->find($engagementPostId);
            $eagle = $eagleRepository->find($eagleId);
            $attendanceDisapproval->setFiles([$file]);
            $attendanceDisapproval->setDate(new DateTime());
            $attendanceDisapproval->setEngagementPost($engagementPost);
            $attendanceDisapproval->setEagle($eagle);
            $attendanceDisapproval->setJustification($justification);
            $em->persist($attendanceDisapproval);
            $em->flush();
            $json = $serializer->serialize($attendanceDisapproval, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
            return new JsonResponse($json, 201, [], true);
        }
        return new Response('not done');
    }

    // works
    #[Route('/api/addcomment', name: 'add_comment', methods: ['POST'])]
    public function setComment(Request $request, EagleRepository $eagleRepository, PostRepository $postRepository, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $body = $request->toArray();
        $eagle = $eagleRepository->find($body['eagleId']);
        $post = $postRepository->find($body['postId']);
        $comment = new Comment();
        $comment->setEagle($eagle);
        $comment->setDate(new DateTime());
        $comment->setPost($post);
        $comment->setContent($body['content']);
        $em->persist($comment);
        $em->flush();
        $json = $serializer->serialize($comment, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 201, [], true);
    }



    // get comments by post id
    // works
    #[Route('/api/post/comments/{id}', name: 'get_comments', methods: ['GET'])]
    public function getComments($id, CommentRepository $commentRepository, SerializerInterface $serializer): JsonResponse
    {
        $comments = $commentRepository->findBy(['post' => $id]);
        $json = $serializer->serialize($comments, 'json', [
            'groups' => 'comments:read',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 200, [], true);
    }


    // post polling
    // works
    #[Route('/api/postpolling', name: 'post_polling', methods: ['POST'])]
    public function postPolling(Request $request, PollingRepository $pollingRepository, SerializerInterface $serializer, EagleRepository $eagleRepository, PollRepository $pollRepository, PollOptionRepository $pollOptionRepository, EntityManagerInterface $em): JsonResponse
    {
        $body = $request->toArray();
        // check if eagle in already polled for this poll
        $eagle = $eagleRepository->find($body['eagleId']);
        $poll = $pollRepository->find($body['pollId']);
        $pollings = $pollingRepository->findAll();
        $polled = false;
        foreach ($pollings as $polling) {
            if ($polling->getEagle() === $eagle && $polling->getPoll() === $poll) {
                $polled = true;
            }
        }
        if ($polled) {
            return new JsonResponse('already polled', 400, [], true);
        }
        $pollOption = $pollOptionRepository->find($body['pollOptionId']);
        $polling = new Polling();
        $polling->setEagle($eagle);
        $polling->setPoll($poll);
        $polling->setPollOption($pollOption);
        $polling->setDate(new DateTime());
        $em->persist($polling);
        $em->flush();
        $json = $serializer->serialize($polling, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 201, [], true);
    }

    // find comment by post id
    #[Route('/api/comment/{id}', name: 'comment', methods: ['GET'])]
    public function findComment($id, PostRepository $postRepository, CommentRepository $commentRepository, SerializerInterface $serializer): JsonResponse
    {
        $post = $postRepository->find($id);
        $comments = $commentRepository->findBy(['post' => $post], [
            'date' => 'DESC'
        ]);
        $json = $serializer->serialize($comments, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 200, [], true);
    }

}
