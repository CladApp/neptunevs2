<?php

namespace NeptuneVs\Bundle\AgendaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NeptuneVs\Bundle\AgendaBundle\Entity\UserEvent
 *
 * @ORM\Table(name="userevent")
 * @ORM\Entity(repositoryClass="NeptuneVs\Bundle\AgendaBundle\Entity\UserEventRepository")
 */
class UserEvent {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $niveau
     *
     * @ORM\Column(name="niveau", type="string", length=255)
     */
    private $niveau;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="UserEvent")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * @var boolean $apero
     *
     * @ORM\Column(name="apero", type="boolean")
     */
    private $apero;

    /**
     * @var boolean $apnee
     *
     * @ORM\Column(name="apnee", type="boolean")
     */
    private $apnee;
    
    /**
     * @var boolean $scaphandre
     *
     * @ORM\Column(name="scaphandre", type="boolean")
     */
    private $scaphandre;
    
    /**
     * @ORM\ManyToOne(targetEntity="NeptuneVs\Bundle\UserBundle\Entity\User", inversedBy="userevent")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    
    function __construct() {
        $this->setApero(false);
        $this->setApnee(false);
        $this->setScaphandre(false);
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }
    public function getApnee() {
        return $this->apnee;
    }

    public function setApnee($apnee) {
        $this->apnee = $apnee;
        if($apnee){
            $this->scaphandre = false;
        }
    }

    public function getScaphandre() {
        return $this->scaphandre;
    }

    public function setScaphandre($scaphandre) {
        $this->scaphandre = $scaphandre;
        if($scaphandre){
            $this->apnee = false;
        }
    }

            /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set niveau
     *
     * @param string $niveau
     */
    public function setNiveau($niveau) {
        $this->niveau = $niveau;
    }

    /**
     * Get niveau
     *
     * @return string 
     */
    public function getNiveau() {
        return $this->niveau;
    }

    /**
     * Set event
     *
     * @param string $event
     */
    public function setEvent($event) {
        $this->event = $event;
    }

    /**
     * Get event
     *
     * @return string 
     */
    public function getEvent() {
        return $this->event;
    }

    /**
     * Set apero
     *
     * @param boolean $apero
     */
    public function setApero($apero) {
        $this->apero = $apero;
    }

    /**
     * Get apero
     *
     * @return boolean 
     */
    public function getApero() {
        return $this->apero;
    }

}