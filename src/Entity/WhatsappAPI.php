<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


class WhatsappAPI
{

    /**
     * @var string

     */
    private $idd = 871;

    /**
     * @var string
     *
     */
    private $key = "fd81a9a4883b0a2890130becac66d4f59f06f10b";


    public function getId(): ?string
    {
        return $this->idd;
    }

    public function setDesignation(string $idd): self
    {
        $this->designation = $idd;

        return $this;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setDescription(?string $key): self
    {
        $this->description = $key;

        return $this;
    }

    public function send($send_to, $message_body){


        $data = array('to' => $send_to, 'msg' => $message_body);


        // $myvars = 'myvar1=' . $myvar1 . '&myvar2=' . $myvar2;

        $url = "https://onyxberry.com/services/wapi/Client/sendMessage";
        $url = $url.'/'.$this->idd.'/'.$this->key;
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec( $ch );
        return $response;
    }




}
