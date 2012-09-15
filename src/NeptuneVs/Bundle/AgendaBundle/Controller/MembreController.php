<?php

namespace NeptuneVs\Bundle\AgendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NeptuneVs\Bundle\AgendaBundle\EventsList\GenerateEventsList;
use Symfony\Component\HttpFoundation\Response;
use NeptuneVs\Bundle\AgendaBundle\Entity\UserEvent;
use NeptuneVs\Bundle\AgendaBundle\Form\Type\UserEventType;
use NeptuneVs\Bundle\AgendaBundle\Form\Type\UserEventCarriereType;
use NeptuneVs\Bundle\AgendaBundle\Form\Type\UserEventPiscineType;
use NeptuneVs\Bundle\AgendaBundle\Form\Type\UserEventCoursType;

class MembreController extends Controller {

    public function indexAction() {
        return $this->render('NeptuneVsAgendaBundle:Membre:index.html.twig');
    }

    public function generateEventsAction() {

        $request = $this->getRequest();
        $start = $request->get("start");
        $end = $request->get("end");

        $mysqlstart = new \DateTime();
        $mysqlstart->setTimestamp($start);

        $mysqlend = new \DateTime();
        $mysqlend->setTimestamp($end);

        $eventRepository = $this->getDoctrine()->getRepository('NeptuneVsAgendaBundle:Event');
        $events = $eventRepository->findByDate($mysqlstart, $mysqlend);

        $placeRepository = $this->getDoctrine()->getRepository('NeptuneVsAgendaBundle:Place');
        $places = $placeRepository->findAll();

        $user = $this->get('security.context')->getToken()->getUser();

        $params = $this->get('param')->getAllParams();

        $eventsList = new GenerateEventsList($this->getDoctrine()->getEntityManager(), $events, $user, $places, $params);

        $response = new Response(json_encode($eventsList->GenerateAllEvents($mysqlstart, $mysqlend)), 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function showEventAction() {
        $request = $this->getRequest();

        if ($request->get('id') != "") {
            $eventRepository = $this->getDoctrine()->getRepository('NeptuneVsAgendaBundle:Event');
            $eventSelected = $eventRepository->find($request->get('id'));

            if (!$eventSelected) {
                throw new \Exception('Event non trouvé !');
            }

            $placeRepository = $this->getDoctrine()->getRepository('NeptuneVsAgendaBundle:Place');
            $placeEventSelected = $placeRepository->find($request->get('lieuId'));

            if (!$placeEventSelected) {
                throw new \Exception('Place non trouvé !');
            }

            $user = $this->get('security.context')->getToken()->getUser();
            $startEventSelected = new \DateTime($request->get('start'));

            $userEventRepository = $this->getDoctrine()->getRepository('NeptuneVsAgendaBundle:UserEvent');
            $userEventSelected = $userEventRepository->findByEventAndUserId($eventSelected, $user);

            $otherEvents = $eventRepository->findbyDayMonthYear($startEventSelected);

            $otherUserEvents = array();

            if ($otherEvents) {
                foreach ($otherEvents as $otherEvent) {
                    foreach ($otherEvent->getUsersevent() as $otherUserEvent) {
                        if ($otherUserEvent->getUser() == $user) {
                            $otherUserEvents[] = $otherUserEvent;
                        }
                    }
                }

                if ($otherUserEvents) {
                    return $this->render('NeptuneVsAgendaBundle:Membre:erreurUserEvent.html.twig');
                }
            }

            if ($userEventSelected) {
                //ajouter pour les dp !!!!
                return $this->render('NeptuneVsAgendaBundle:Membre:showEventUsers.html.twig', array(
                            'event' => $eventSelected,
                            'userEvent' => $userEventSelected,
                            'place' => $placeEventSelected,
                            'user' => $user,
                        ));
            }

            $formCours = null;
            $formScaphandre = null;
            $formApnee = null;

            $eventUser = new UserEvent();
            $eventUser->setUser($user->getId());
            $eventUser->setEvent($eventSelected->getId());
            
            if ($placeEventSelected->getCours()) {
                $formCours = $this->createForm(new UserEventCoursType(), $eventUser)->createView();
                return $this->render('NeptuneVsAgendaBundle:Membre:addEventUserCours.html.twig', array(
                        'formCours' => $formCours,
                        'event' => $eventSelected,
                        'place' => $placeEventSelected,
                        'user' => $user,
                    ));
            }
            
            if ($placeEventSelected->getPiscine()) {
                if ($eventSelected->getScaphandre()) {
                    $eventUser->setScaphandre(true);
                    $formScaphandre = $this->createForm(new UserEventPiscineType($this->container->getParameter('niveau_scaphndre_piscine')), $eventUser)->createView();
                }
                if ($eventSelected->getApnee()) {
                    $eventUser->setApnee(true);
                    $formApnee = $this->createForm(new UserEventPiscineType($this->container->getParameter('niveau_apnee_piscine')), $eventUser)->createView();
                }
                
                return $this->render('NeptuneVsAgendaBundle:Membre:addEventUserPiscine.html.twig', array(
                        'formScaphandre' => $formScaphandre,
                        'formApnee' => $formApnee,
                        'event' => $eventSelected,
                        'place' => $placeEventSelected,
                        'user' => $user,
                    ));
            }

            if ($placeEventSelected->getCarriere()) {
                if ($eventSelected->getScaphandre()) {
                    $eventUser->setScaphandre(true);
                    $formScaphandre = $this->createForm(new UserEventCarriereType($this->container->getParameter('niveau_scaphndre_carierre')), $eventUser)->createView();
                }
                if ($eventSelected->getApnee()) {
                    $eventUser->setApnee(true);
                    $formApnee = $this->createForm(new UserEventCarriereType($this->container->getParameter('niveau_apnee_carierre')), $eventUser)->createView();
                }
                
                return $this->render('NeptuneVsAgendaBundle:Membre:addEventUserCarriere.html.twig', array(
                        'formScaphandre' => $formScaphandre,
                        'formApnee' => $formApnee,
                        'event' => $eventSelected,
                        'place' => $placeEventSelected,
                        'user' => $user,
                    ));
            }

            
        }

        throw new \Exception('Something went wrong!');
    }

}