<?php

namespace App\Service;

use Symfony\Component\Routing\Annotation\Route;

class NotificationService
{
    #[Route('/', name: 'add_notif', methods: ['GET'])]
    public function sendNotificationToEagles()
    {

        $SERVER_API_KEY = 'AAAAtOlIIio:APA91bH_LYhZHXuY6V_ZI65MTfzXJDDHBIjB1IuUllJ5ISkTgG2bPFMbem5sQMuF2QAS04TQbuHY38ghSZP-VbAOzWaIZH72TimKlL4AjQwbg0xB5M8wpn5YpKKL3tRIWH_IvjtuutTV';

        $token = 'faI9wSuCQH6CiTp0Q-7-aU:APA91bE7eBiN6Bdd-nmBem7sqDjjeafpEzZ6nx00SQhSJNGXDHyx2O-WIrMaK42-_TeeZoB8If_QrNixfhVxMZ387F0_au0x9B5XkCg2YeJEWxbVZ22xFqQV8oyOOLdPeK__947kC0lv';

        $data = [

            "registration_ids" => [
                $token
            ],

            "notification" => [

                "title" => 'Welcome',

                "body" => 'Description',

                "sound"=> "default" // required for sound on ios

            ],


        ];

        $dataString = json_encode($data);

        $headers = [

            'Authorization: key=' . $SERVER_API_KEY,

            'Content-Type: application/json',

        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        dd($response);
    }
}