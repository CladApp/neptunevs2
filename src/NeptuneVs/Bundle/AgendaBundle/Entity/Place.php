<?php

namespace NeptuneVs\Bundle\AgendaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NeptuneVs\Bundle\AgendaBundle\Entity\ Place
 *
 * @ORM\Table(name="place")
 * @ORM\Entity(repositoryClass="NeptuneVs\Bundle\AgendaBundle\Entity\PlaceRepository")
 */
class Place {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nom
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var text $tarif
     *
     * @ORM\Column(name="tarif", type="text")
     */
    private $tarif;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="place")
     */
    private $events;

    /**
     * @var boolean $piscine
     *
     * @ORM\Column(name="piscine", type="boolean")
     */
    private $piscine;

    /**
     * @var boolean $carriere
     *
     * @ORM\Column(name="carriere", type="boolean")
     */
    private $carriere;

    /**
     * @var boolean $cours
     *
     * @ORM\Column(name="cours", type="boolean")
     */
    private $cours;

    /**
     * @var boolean $readOnly
     *
     * @ORM\Column(name="read_only", type="boolean")
     */
    private $readOnly;

    function __construct() {
        $this->setCarriere(true);    
    }
    
    public function getReadOnly() {
        return $this->readOnly;
    }

    public function setReadOnly($readOnly) {
        $this->readOnly = $readOnly;
    }

    public function getEvents() {
        return $this->events;
    }

    public function getPiscine() {
        return $this->piscine;
    }

    public function setPiscine($piscine) {
        $this->piscine = $piscine;  
        if($piscine){
            $this->carriere = false;
            $this->cours = false;
        }
    }

    public function getCarriere() {
        return $this->carriere;
    }

    public function setCarriere($carriere) {
        $this->carriere = $carriere;
        if($carriere){
            $this->piscine = false;
            $this->cours = false;
        }
    }

    public function getCours() {
        return $this->cours;
    }

    public function setCours($cours) {
        $this->cours = $cours;
        if($cours){
            $this->piscine = false;
            $this->carriere = false;
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
     * Set nom
     *
     * @param string $nom
     */
    public function setNom($nom) {
        $this->nom = $nom;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set tarif
     *
     * @param text $tarif
     */
    public function setTarif($tarif) {
        $this->tarif = $tarif;
    }

    /**
     * Get tarif
     *
     * @return text 
     */
    public function getTarif() {
        return $this->tarif;
    }

}