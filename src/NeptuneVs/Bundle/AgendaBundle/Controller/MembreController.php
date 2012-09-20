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
use Symfony\Component\HttpFoundation\Request;

class MembreController extends Controller {

    public function indexAction() {
        return $this->render('NeptuneVsAgendaBundle:Membre:index.html.twig');
    }

    public function generateEventsAction() {

        $request = $this->getRequest();
        $start = $request->get("start");
        $end = $request->get("end");

        //DateTime de la date de début du calendrier
        $mysqlstart = new \DateTime();
        $mysqlstart->setTimestamp($start);
             
        //Supprime les events avant aujourd'huit
        $now = new \DateTime();
        if ($mysqlstart->format('Y-m-d') < $now->format('Y-m-d')){
            $mysqlstart = $now;
        }

        //DateTime de la date de fin du calendrier
        $mysqlend = new \DateTime();
        $mysqlend->setTimestamp($end);

        //Récupération des éventuels events
        $eventRepository = $this->getDoctrine()->getRepository('NeptuneVsAgendaBundle:Event');
        $events = $eventRepository->findByDate($mysqlstart, $mysqlend);
        
        //Récupération de tous les lieux
        $placeRepository = $this->getDoctrine()->getRepository('NeptuneVsAgendaBundle:Place');
        $places = $placeRepository->findAll();

        //récupération des infos user
        $user = $this->get('security.context')->getToken()->getUser();

        //récupération des paramétres pour les niveaux
        $params = $this->get('param')->getAllParams();

        //création de la liste des events
        $eventsList = new GenerateEventsList($this->getDoctrine()->getEntityManager(), $events, $user, $places, $params);

        $response = new Response(json_encode($eventsList->GenerateAllEvents($mysqlstart, $mysqlend)), 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function showEventAction() {
        $request = $this->getRequest();
        
        //Si la requette dispose du parametre Id
        if ($request->get('id') != "") {
            //récupération de l'event
            $eventRepository = $this->getDoctrine()->getRepository('NeptuneVsAgendaBundle:Event');
            $eventSelected = $eventRepository->find($request->get('id'));

            if (!$eventSelected) {
                throw new \Exception('Event non trouvé !');
            }

            //récupération du lieu
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

            if ($placeEventSelected->getCours()) {
                $response = $this->forward('NeptuneVsAgendaBundle:Membre:showAddEventCours', array('user' => $user, 'event' => $eventSelected, 'place' => $placeEventSelected));
            }

            if ($placeEventSelected->getPiscine()) {
                $response = $this->forward('NeptuneVsAgendaBundle:Membre:showAddEventPiscine', array('user' => $user, 'event' => $eventSelected, 'place' => $placeEventSelected));
            }

            if ($placeEventSelected->getCarriere()) {
                $response = $this->forward('NeptuneVsAgendaBundle:Membre:showAddEventCarriere', array('user' => $user, 'event' => $eventSelected, 'place' => $placeEventSelected));
            }

            return $response;
        }

        throw new \Exception('Something went wrong!');
    }
    
    
    
    

    public function showAddEventPiscineAction($user, $event, $place) {
        $eventUser = new UserEvent();
        $eventUser->setUser($user->getId());
        $eventUser->setEvent($event->getId());

        $formScaphandre = null;
        $formApnee = null;

        if ($event->getScaphandre()) {
            $eventUser->setScaphandre(true);
            $formScaphandre = $this->createForm(new UserEventPiscineType($this->container->getParameter('niveau_scaphandre_piscine')), $eventUser)->createView();
        }
        if ($event->getApnee()) {
            $eventUser->setApnee(true);
            $formApnee = $this->createForm(new UserEventPiscineType($this->container->getParameter('niveau_apnee')), $eventUser)->createView();
        }

        return $this->render('NeptuneVsAgendaBundle:Membre:addEventUserPiscine.html.twig', array(
                    'formScaphandre' => $formScaphandre,
                    'formApnee' => $formApnee,
                    'event' => $event,
                    'place' => $place,
                    'user' => $user,
                ));
    }

    public function showAddEventCarriereAction($user, $event, $place) {
        $eventUser = new UserEvent();
        $eventUser->setUser($user->getId());
        $eventUser->setEvent($event->getId());

        $formScaphandre = null;
        $formApnee = null;

        if ($event->getScaphandre()) {
            $eventUser->setScaphandre(true);
            $formScaphandre = $this->createForm(new UserEventCarriereType($this->container->getParameter('niveau_scaphandre_carierre')), $eventUser)->createView();
        }
        if ($event->getApnee()) {
            $eventUser->setApnee(true);
            $formApnee = $this->createForm(new UserEventCarriereType($this->container->getParameter('niveau_apnee')), $eventUser)->createView();
        }

        return $this->render('NeptuneVsAgendaBundle:Membre:addEventUserCarriere.html.twig', array(
                    'formScaphandre' => $formScaphandre,
                    'formApnee' => $formApnee,
                    'event' => $event,
                    'place' => $place,
                    'user' => $user,
                ));
    }

    public function showAddEventCoursAction($user, $event, $place) {
        $eventUser = new UserEvent();
        $eventUser->setUser($user->getId());
        $eventUser->setEvent($event->getId());

        $formCours = $this->createForm(new UserEventCoursType(), $eventUser)->createView();
        return $this->render('NeptuneVsAgendaBundle:Membre:addEventUserCours.html.twig', array(
                    'formCours' => $formCours,
                    'event' => $event,
                    'place' => $place,
                    'user' => $user,
                ));
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function saveEventUserPiscineAction(Request $request, $type) {
        //$request = $this->getRequest();
        $newUserEvent = new UserEvent();

        if ($type == "scaphandre") {
            $params = $this->container->getParameter('niveau_scaphandre_piscine');
        } else {
            $params = $this->container->getParameter('niveau_apnee');
        }
        
        $form = $this->createForm(new UserEventPiscineType($params), $newUserEvent);
        $form->bindRequest($request);
        var_dump($form->getData());exit;
        
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $eventUserRepository = $this->getDoctrine()->getRepository('NeptuneVsAgendaBundle:UserEvent');
        $userEvent = $eventUserRepository->findByEventAndUserId($request->get('neptunevs_bundle_agendabundle_usereventpiscine_event'), $request->get('neptunevs_bundle_agendabundle_usereventpiscine_user'));

        if ($userEvent) {
            return $this->render('NeptuneVsAgendaBundle:Membre:erreurUserEvent.html.twig');
        }
        
        $eventRepository = $this->getDoctrine()->getRepository('NeptuneVsAgendaBundle:Event');
        $event = $eventRepository->find($request->get('neptunevs_bundle_agendabundle_usereventpiscine[event]'));
        
        $otherEvents = $eventRepository->findbyDayMonthYear($event->getStart());
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

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($newUserEvent);
            $em->flush();
           return $this->redirect($this->generateUrl('NeptuneVsAgendaBundle_agenda_show'));
        }
        
        return $this->forward('NeptuneVsAgendaBundle:Membre:showAddEventPiscine', array('user' => $user, 'event' => $event, 'place' => $event->getPlace()));
    }

    public function saveEventUserCarriereAction() {
        $request = $this->getRequest();

        $eventRepository = $this->getDoctrine()->getRepository('NeptuneVsAgendaBundle:Event');
        $event = $eventRepository->find($request->get('event'));

        $userEvent = new UserEvent();
        $form = $this->createForm(new TaskType(), $userEvent);
        $form->bind($request);

        if ($form->isValid()) {
            
        }
    }

}