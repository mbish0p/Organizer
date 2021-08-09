<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EventController extends AbstractApiController
{
    public function getEvents(Request $request): Response
    {

        $events = $this->getDoctrine()->getRepository(Event::class)->findAll();
        return $this->respond($events);
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


        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();

        return $this->respond($event);
    }

    public function deleteEvent(int $id, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->findById($id);

        if (!$event) {
            return $this->respond(null, Response::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        return $this->respond($event);
    }

    public function editEvent(int $id, EventRepository $eventRepository, Request $request): Response
    {
        $event = $eventRepository->findById($id);

        if (!$event) {
            return $this->respond(null, Response::HTTP_NOT_FOUND);
        }

        $newEvent = new Event();
        $newEvent->setData($request->toArray());

        $event->updateEvent($newEvent);

        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();

        return $this->respond($event);
    }
}
