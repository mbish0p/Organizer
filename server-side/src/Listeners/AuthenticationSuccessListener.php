<?php

namespace App\Listeners;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Gesdinet\JWTRefreshTokenBundle\Event\RefreshEvent;
use Symfony\Component\HttpFoundation\Cookie;

class AuthenticationSuccessListener
{
        private $token_ttl;

        public function __construct($token_ttl)
        {
                $this->token_ttl = $token_ttl;
        }

        /**
         * @param AuthenticationSuccessEvent $event
         */
        public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event, RefreshEvent $refresh_event)
        {
                $token = $event->getData()['token'];
                $response = $event->getResponse();
                $refreshToken =  $refresh_event->getRefreshToken()->getRefreshToken();
                var_dump($refreshToken);

                $response->headers->setCookie(
                        new Cookie(
                                'BEARER',
                                $token,
                                (new \DateTime())
                                        ->add(new \DateInterval('PT' . $this->token_ttl . 'S'))
                        ),
                );
        }
}
