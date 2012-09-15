<?php

namespace NeptuneVs\Bundle\AgendaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NeptuneVs\Bundle\AgendaBundle\Entity\Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="NeptuneVs\Bundle\AgendaBundle\Entity\EventRepository")
 */
class Event {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=50)
     */
    private $title;

    /**
     * @var boolean $allday
     *
     * @ORM\Column(name="allday", type="boolean")
     */
    private $allday;

    /**
     * @var datetime $start
     *
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var datetime $end
     *
     * @ORM\Column(name="end", type="datetime")
     */
    private $end;

    /**
     * @var boolean $editable
     *
     * @ORM\Column(name="editable", type="boolean")
     */
    private $editable;

    /**
     * @var boolean $sortie
     *
     * @ORM\Column(name="sortie", type="boolean")
     */
    private $sortie;
    
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
     * @var boolean $autoGenerate
     *
     * @ORM\Column(name="auto_generate", type="boolean")
     */
    private $autoGenerate;
    
    /**
     * @var boolean $canceled
     *
     * @ORM\Column(name="canceled", type="boolean")
     */
    private $canceled;
    
    /**
     * @ORM\OneToMany(targetEntity="UserEvent", mappedBy="event")
     */
    private $usersevent;

    /**
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="events")
     * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
     */ 
    private $place;
    
    function __construct() {
        $this->setSortie(false);
        $this->setAutoGenerate(false);
        $this->setScaphandre(true);
        $this->setApnee(true); 
        $this->setCanceled(false);
        $this->setEditable(true);
        $this->setAllday(true);
    }

    public function getCanceled() {
        return $this->canceled;
    }

    public function setCanceled($canceled) {
        $this->canceled = $canceled;
    }

    public function getPlace() {
        return $this->place;
    }

    public function setPlace($place) {
        $this->place = $place;
    }

        public function getSortie() {
        return $this->sortie;
    }

    public function setSortie($sortie) {
        $this->sortie = $sortie;
    }

    public function getUsersevent() {
        return $this->usersevent;
    }
    
    public function getApnee() {
        return $this->apnee;
    }

    public function setApnee($apnee) {
        $this->apnee = $apnee;
    }

    public function getScaphandre() {
        return $this->scaphandre;
    }

    public function setScaphandre($scaphandre) {
        $this->scaphandre = $scaphandre;
    }

    public function getAutoGenerate() {
        return $this->autoGenerate;
    }

    public function setAutoGenerate($autoGenerate) {
        $this->autoGenerate = $autoGenerate;
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set allday
     *
     * @param boolean $allday
     */
    public function setAllday($allday) {
        $this->allday = $allday;
    }

    /**
     * Get allday
     *
     * @return boolean 
     */
    public function getAllday() {
        return $this->allday;
    }

    /**
     * Set start
     *
     * @param datetime $start
     */
    public function setStart($start) {
        $this->start = $start;
    }

    /**
     * Get start
     *
     * @return datetime 
     */
    public function getStart() {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param datetime $end
     */
    public function setEnd($end) {
        $this->end = $end;
    }

    /**
     * Get end
     *
     * @return datetime 
     */
    public function getEnd() {
        return $this->end;
    }

    /**
     * Set editable
     *
     * @param boolean $editable
     */
    public function setEditable($editable) {
        $this->editable = $editable;
    }

    /**
     * Get editable
     *
     * @return boolean 
     */
    public function getEditable() {
        return $this->editable;
    }

}