<?php

namespace NeptuneVs\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('NeptuneVsMainBundle:Default:index.html.twig');
    }

    public function getTokenAction() {
        return new Response($this->container->get('form.csrf_provider')->generateCsrfToken('authenticate'));
    }

    public function historyAction() {
        $params = $this->get('param')->getParams(array("saison", "nbmembres"));
        return $this->render('NeptuneVsMainBundle:Default:history.html.twig'
                        , array('params' => $params));
    }

    public function tarifAction() {
        $params = $this->get('param')->getParams(array("d_saison", "cotisation", "c_mineur", "t_fresnais", "t_becon"));
        return $this->render('NeptuneVsMainBundle:Default:tarif.html.twig', array(
                    'params' => $params
                ));
    }

    public function formationAction() {
        return $this->render('NeptuneVsMainBundle:Default:formation.html.twig');
    }

    public function siteplongeeAction() {
        return $this->render('NeptuneVsMainBundle:Default:siteplongee.html.twig');
    }

}
