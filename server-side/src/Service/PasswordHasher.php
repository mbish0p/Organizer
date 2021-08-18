<?php

namespace App\Service;

use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class PasswordHasher
{
        private $encoder;

        public function __construct($encoder)
        {
                $this->encoder = $encoder;
        }


        public function hash(string $text): string
        {
                return $this->encoder->hash($text);
        }
}
