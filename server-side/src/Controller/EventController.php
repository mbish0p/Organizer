<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class EventController extends AbstractController
{
    public function getEvents(Request $request): Response
    {

        $events = $this->getDoctrine()->getRepository(Event::class)->findAll();
        return $this->json($events);
    }

    public function createEvent(Request $request): Response
    {
        // dump($request);
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        $data = $form->getData();

        return $this->json($data);
    }
}
