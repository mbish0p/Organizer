<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractApiController extends AbstractController
{
        protected function buildForm(string $type, $data = null, array $options = [])
        {
                $options = array_merge($options, [
                        'csrf-protection' => false
                ]);

                return $this->container->get('form.factory')->createNamed('', $type, $data, $options);
        }
}
