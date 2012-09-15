<?php

namespace NeptuneVs\Bundle\AgendaBundle\EventsList;

use NeptuneVs\Bundle\AgendaBundle\Entity\Event;

class GenerateEventsList {

    private $events;
    private $user;
    private $params;
    private $places;
    private $em;

    public function __construct($em, $events, $user, $place, $params) {
        $this->events = $events;
        $this->user = $user;
        $this->places = $place;
        $this->params = $params;
        $this->em = $em;
    }

    public function GenerateAllEvents(\DateTime $start, \DateTime $end) {
        $autoEvents = $this->GenerateStaticEvents($start, $end);
        $dbEvents = $this->GenerateDbEvents();
        return array_merge($dbEvents,$autoEvents );
    }

    private function GenerateStaticEvents(\DateTime $start, \DateTime $end) {
        $rows = array();
        $new_date = $start;
        $now = new \DateTime();

        while ($new_date <= $end) {

            $desable = false;

            for ($a = 0; count($this->events) > $a; $a++) {
                if ($this->events[$a]->getStart()->format('Y-m-d') == $new_date->format('Y-m-d')) {
                    if ($this->events[$a]->getAutoGenerate()) {
                        $desable = true;
                    }
                }
            }

            if ($new_date->format('Y-m-d') < $now->format('Y-m-d')) {
                $desable = true;
            }

            if (!$desable) {
                switch ($new_date->format('w')) {
                    case "0":
                        if ($this->params["show_dim"]) {
                            if (($new_date->format('j') >= 1) and ($new_date->format('j') <= 7)) {
                                $rows[] = $this->GenerateArrayEvent(array($this->getPlace($this->params["place_dim_1"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_dim_1_start"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_dim_1_end"])));
                            }
                            if (($new_date->format('j') >= 8) and ($new_date->format('j') <= 14)) {
                                $rows[] = $this->GenerateArrayEvent(array($this->getPlace($this->params["place_dim_2"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_dim_2_start"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_dim_2_end"])));
                            }
                            if (($new_date->format('j') >= 15) and ($new_date->format('j') <= 21)) {
                                $rows[] = $this->GenerateArrayEvent(array($this->getPlace($this->params["place_dim_3"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_dim_3_start"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_dim_3_end"])));
                            }
                            if (($new_date->format('j') >= 22) and ($new_date->format('j') <= 28)) {
                                $rows[] = $this->GenerateArrayEvent(array($this->getPlace($this->params["place_dim_4"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_dim_4_start"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_dim_4_end"])));
                            }
                            if (($new_date->format('j') >= 29) and ($new_date->format('j') <= 31)) {
                                $rows[] = $this->GenerateArrayEvent(array($this->getPlace($this->params["place_dim_5"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_dim_5_start"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_dim_5_end"])));
                            }
                        }
                        break;
                    case "3":
                        if ($this->params["show_mer"]) {
                            if (!$this->isDateIn($new_date, new \DateTime($this->params["date_vacance_toussaint_start"]), new \DateTime($this->params["date_vacance_toussaint_end"]))
                                    && !$this->isDateIn($new_date, new \DateTime($this->params["date_vacance_noel_start"]), new \DateTime($this->params["date_vacance_noel_end"]))
                                    && !$this->isDateIn($new_date, new \DateTime($this->params["date_vacance_hiver_start"]), new \DateTime($this->params["date_vacance_hiver_end"]))
                                    && !$this->isDateIn($new_date, new \DateTime($this->params["date_vacance_printemps_start"]), new \DateTime($this->params["date_vacance_printemps_end"]))) {
                                
                                if (!$this->isDateIn($new_date, new \DateTime($this->params["date_vacance_ete_mer_start"]), new \DateTime($this->params["date_vacance_ete_mer_end"]))) {
                                    $rows[] = $this->GenerateArrayEvent(array($this->getPlace($this->params["place_mer"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_mer_start"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_mer_end"])));
                                } else {
                                    $rows[] = $this->GenerateArrayEvent(array($this->getPlace($this->params["place_mer_vac"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_mer_vac_start"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_mer_vac_end"])));
                                }
                            }
                        }
                        break;
                    case "5":
                        if ($this->params["show_ven"]) {
                            if ($this->isDateIn($new_date, new \DateTime($this->params["date_vacance_ete_mer_start"]), new \DateTime($this->params["date_vacance_ete_mer_end"]))) {
                                $rows[] = $this->GenerateArrayEvent(array($this->getPlace($this->params["place_ven_vac"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_ven_vac_start"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_ven_vac_end"])));
                            }
                        }
                        break;
                    case "6":
                        if ($this->params["show_sam"]) {
                            if (($new_date->format('j') > 14) and ($new_date->format('j') < 22)) {
                                $rows[] = $this->GenerateArrayEvent(array($this->getPlace($this->params["place_sam_3"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_sam_3_start"]), new \DateTime($new_date->format('Y-m-d ') . $this->params["time_sam_3_end"])));
                            }
                        }
                        break;
                }
            }
            $new_date = $new_date->add(new \DateInterval('P1D'));
        }
        return $rows;
    }

    private function isDateOut($date, $start, $end) {
        if ($date->format('Y-m-d') < $start->format('Y-m-d') && $date->format('Y-m-d') > $end->format('Y-m-d')) {
            return true;
        }
        return false;
    }
    
    private function isDateIn($date, $start, $end) {
        if ($date->format('Y-m-d') >= $start->format('Y-m-d') && $date->format('Y-m-d') <= $end->format('Y-m-d')) {
            return true;
        }
        return false;
    }
    
    private function getPlace($id) {
        foreach ($this->places as $place) {
            if ($place->getId() == $id) {
                return $place;
            }
        };
        return null;
    }

    private function GenerateDbEvents() {
        $rows = array();
        for ($a = 0; count($this->events) > $a; $a++) {
            $rows[] = $this->GenerateArrayDbEvent($this->events[$a]);
        }
        return $rows;
    }

    private function GenerateArrayDbEvent($event) {
        //Is it an all day event?
        $all = ($event->getAllday() == 1);
        $type = $event->getSortie() ? 'sortie' : 'auto';
        $textColor = $event->getSortie() ? 'crimson' : 'lightslategrey';
        $register = false;
        $cours = false;

        foreach ($this->places as $place) {
            if ($place->getId() == $event->getPlace()->getId()) {
                if ($place->getCours()) {
                    $cours = true;
                    $textColor = 'darkseagreen';
                }
            }
        }
        foreach ($event->getUsersevent() as $userevent) {
            if ($userevent->getUser()->getId() == $this->user->getId()) {
                $register = true;
                break;
            }
        }

        if ($cours) {
            $class = 'cours';
        } else {
            $class = $type;
        }
        if ($register) {
            $class = $class . ' register';
        }

        //Create an event entry
        return array('id' => $event->getId(),
            'title' => $event->gettitle(),
            'start' => $event->getStart()->format('Y-m-d H:i'),
            'end' => $event->getEnd()->format('Y-m-d H:i'),
            'allDay' => $all,
            'className' => $class,
            'backgroundColor' => 'transparent',
            'textColor' => $textColor,
            'register' => $register,
            'lieuId' => $event->getPlace()->getId(),
            'apnee' => $event->getApnee(),
            'scaphandre' => $event->getScaphandre(),
        );
    }

    private function GenerateArrayEvent($event) {
        $newEvent = new Event();
        $newEvent->setTitle($event[0]->getNom());
        $newEvent->setStart($event[1]);
        $newEvent->setEnd($event[2]);
        $newEvent->setAutoGenerate(true);
        $newEvent->setPlace($event[0]);
        $this->em->persist($newEvent);
        $this->em->flush();
        
        //Create an event entry
        return array('id' => $newEvent->getId(),
            'title' => $event[0]->getNom(),
            'start' => $event[1]->format('Y-m-d H:i'),
            'end' => $event[2]->format('Y-m-d H:i'),
            'allDay' => true,
            'className' => 'auto',
            'backgroundColor' => 'transparent',
            'textColor' => 'lightslategrey',
            'register' => false,
            'lieuId' => $event[0]->getId(),
            'apnee' => $newEvent->getApnee(),
            'scaphandre' => $newEvent->getScaphandre(),
        );
    }
}