<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EventController extends AbstractApiController
{
    public function getEvents(Request $request): Response
    {

        $events = $this->getDoctrine()->getRepository(Event::class)->findAll();
        return $this->json($events);
    }

    public function createEvent(Request $request): Response
    {

        $form = $this->buildForm(EventType::class);
        $form->handleRequest($request);
        $name =  $request->get('name');
        $descrption = $request->get('description');

        $event = new Event();
        $event->setDate(\DateTime::createFromFormat('Y-m-d', $request->get('date')));
        $event->setName($name);
        $event->setDescription($descrption);


        $gm = $this->getDoctrine()->getManager();
        $gm->persist($event);
        $gm->flush();

        return $this->json($event);
    }
}
