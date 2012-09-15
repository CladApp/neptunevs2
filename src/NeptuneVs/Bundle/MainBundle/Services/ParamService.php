<?php

namespace NeptuneVs\Bundle\MainBundle\Services;

use Doctrine\ORM\EntityManager;
use NeptuneVs\Bundle\MainBundle\Entity\Parametre;

class ParamService {

    protected $params;
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->params = $this->em->getRepository('NeptuneVsMainBundle:Parametre')->findAll();
    }

    public function setParam($cle, $parametre) {

        foreach ($this->params as $param) {
            if ($param->getCle() == $cle) {
                $param->setValeur($parametre);
                $this->em->persist($param);
                $this->em->flush();
                break;
            }
        }
    }

    public function getParams(array $cles) {
        $listParam = array();
        foreach ($cles as $value) {
            foreach ($this->params as $param) {
                if ($param->getCle() == $value) {
                    $listParam[$value] = $param->getValeur();
                }
            }
        }
        return $listParam;
    }

    public function getParam($cle) {
        foreach ($this->params as $param) {
            if ($param->getCle() == $cle) {
                return $param->getValeur();
            }
        }

        return 'null';
    }

    public function getAllParams() {
        $listParam = array();

        foreach ($this->params as $param) {
            $listParam[$param->getCle()] = $param->getValeur();
        }
        return $listParam;
    }

}
