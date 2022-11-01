<?php
namespace App\Service;

use Mailjet\Client;
use App\Entity\User;
use Mailjet\Resources;
use App\Entity\EmailModel;

class EmailSenderService{


    public function sendEmailNotificationByMailJet(User $user, EmailModel $email){
        $mj = new Client($_ENV["MJ_APIKEY_PUBLIC"], $_ENV["MJ_APIKEY_PRIVATE"],true,['version' => 'v3.1']);

        $body = [
            'Messages' => [
            [
                'From' => [
                'Email' => "baakellolache@gmail.com",
                'Name' => "Azul Contact"
                ],
                'To' => [
                [
                    'Email' => $user->getEmail(),
                    'Name' => $user->fullName()
                ]
                ],
                'TemplateID' => 3407920,
                'TemplateLanguage' => true,
                'Subject' => $email->getSubject(),
                'Variables' => [
                    'title' => $email->getTitle(),
                    'content' => $email->getContent()
                ]
            ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
       // $response->success() && dd($response->getData());
    }


    public function sendEmailOrderByMailJet(User $user, EmailModel $email){
        $mj = new Client($_ENV["MJ_APIKEY_PUBLIC"], $_ENV["MJ_APIKEY_PRIVATE"],true,['version' => 'v3.1']);

        $body = [
            'Messages' => [
            [
                'From' => [
                'Email' => "baakellolache@gmail.com",
                'Name' => "Azul Contact"
                ],
                'To' => [
                [
                    'Email' => $user->getEmail(),
                    'Name' => $user->fullName()
                ]
                ],
                'TemplateID' => 3407920,
                'TemplateLanguage' => true,
                'Subject' => $email->getSubject(),
                'Variables' => [
                    'title' => $email->getTitle(),
                    'content' => $email->getContent()
                ]
            ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
       // $response->success() && dd($response->getData());
    }
    public function send($to_email, $to_name, $subject, $message){
        $mj = new Client($_ENV["MJ_APIKEY_PUBLIC"], $_ENV["MJ_APIKEY_PRIVATE"],true,['version' => 'v3.1']);
 
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "baakellolache@gmail.com",
                        'Name' => "Azul Contact"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 3407920,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'title' => $message['title'],
                        'content' => $message['content'],
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
      //  $response->success() && dd($response->getData());
                }

}