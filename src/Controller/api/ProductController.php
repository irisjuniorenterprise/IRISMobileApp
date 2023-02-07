<?php

namespace App\Controller\api;

use App\Entity\Order;
use App\Repository\CategoryRepository;
use App\Repository\EagleRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{

    // get products by category name
    // works
    #[Route('/api/products/{categoryName}', name: 'get_products_by_category', methods: ['GET'])]
    public function getProductsByCategory($categoryName, CategoryRepository $categoryRepository, ProductRepository $productRepository, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $categories = $categoryRepository->findAll();
        if ($categoryName === 'All' || $categoryName === '') {
            $products = $productRepository->findAll();
        } else {
            $category=$categoryRepository->findOneBy(['name' => $categoryName]);
            $products = $category?->getProducts();
        }
        $json = $serializer->serialize($products, 'json', [
            'groups' => ['product:read'],
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 200, [], true);
    }

    // get all categories
    // works
    #[Route('/api/categories', name: 'get_categories', methods: ['GET'])]
    public function getCategories(CategoryRepository $categoryRepository, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $categories = $categoryRepository->findAll();
        $json = $serializer->serialize($categories, 'json', [
            'groups' => ['product:read'],
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 200, [], true);
    }

    // order product by id and quantity and user id
    // works
    #[Route('/api/order/{productId}/{quantity}/{userId}/{option}', name: 'order_product', methods: ['GET', 'POST'])]
    public function orderProduct($productId, $quantity, $userId,$option, ProductRepository $productRepository, EagleRepository $eagleRepository, OrderRepository $orderRepository, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $product = $productRepository->find($productId);
        $user = $eagleRepository->find($userId);
        $order = new Order();
        $order->setProduct($product);
        $order->setQty($quantity);
        $order->setEagle($user);
        $order->setDate(new \DateTime());
        $order->setOption($option);
        $order->setStatus('pending');
        $orderRepository->add($order,true);
        $json = $serializer->serialize($order, 'json', [
            'groups' => ['product:read'],
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 200, [], true);
    }


    // get all orders by user id
    // works
    #[Route('/api/orders/{userId}', name: 'get_orders', methods: ['GET'])]
    public function getOrders($userId, OrderRepository $orderRepository, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $orders = $orderRepository->findBy(['eagle' => $userId]);
        $json = $serializer->serialize($orders, 'json', [
            'groups' => ['order:read'],
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 200, [], true);
    }

    // cancel order by id
    // works
    #[Route('/api/cancel/{orderId}', name: 'cancel_order', methods: ['GET'])]
    public function cancelOrder($orderId, OrderRepository $orderRepository, SerializerInterface $serializer, Request $request): JsonResponse
    {
        $order = $orderRepository->find($orderId);
        $order?->setStatus('cancellation-requested');
        $orderRepository->add($order,true);
        $json = $serializer->serialize($order, 'json', [
            'groups' => ['order:read'],
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($json, 200, [], true);
    }

}
