<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractApiController extends AbstractFOSRestController
{
        protected function buildForm(string $type, $data = null, array $options = []): FormInterface
        {
                return $this->container->get('form.factory')->createNamed('', $type, $data, $options);
        }

        protected function respond($data, $statusCode = Response::HTTP_OK): Response
        {
                return $this->handleView($this->view($data, $statusCode));
        }
}
