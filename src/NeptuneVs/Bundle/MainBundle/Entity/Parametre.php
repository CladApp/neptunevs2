<?php

namespace NeptuneVs\Bundle\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * nep\MainBundle\Entity\Parametre
 *
 * @ORM\Table(name="parametre")
 * @ORM\Entity(repositoryClass="nep\MainBundle\Entity\ParametreRepository")
 */
class Parametre
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $cle
     *
     * @ORM\Column(name="cle", type="string", length=255)
     */
    private $cle;

    /**
     * @var string $valeur
     *
     * @ORM\Column(name="valeur", type="text")
     */
    private $valeur;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cle
     *
     * @param string $cle
     */
    public function setCle($cle)
    {
        $this->cle = $cle;
    }

    /**
     * Get cle
     *
     * @return string 
     */
    public function getCle()
    {
        return $this->cle;
    }

    /**
     * Set valeur
     *
     * @param string $valeur
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;
    }

    /**
     * Get valeur
     *
     * @return string 
     */
    public function getValeur()
    {
        return $this->valeur;
    }
}