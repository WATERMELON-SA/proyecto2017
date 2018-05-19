<?php

namespace AppBundle\Entity\Api;

use Doctrine\ORM\Mapping as ORM;

/**
 * Turn
 *
 * @ORM\Table(name="turno")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Api\TurnRepository")
 */
class Turn
{
    /**
     * @var int
     *
     * @ORM\Column(name="idTurno", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaTurno", type="date")
     */
    private $turnDate;

    /**
     * @var int
     *
     * @ORM\Column(name="hora", type="integer")
     */
    private $hour;

    /**
     * @var int
     *
     * @ORM\Column(name="minutos", type="integer")
     */
    private $minutes;

    /**
     * @var int
     *
     * @ORM\Column(name="dniPaciente", type="integer")
     */
    private $dniPacient;

    public function __construct($date, $hour, $minutes, $dni){
        $this->setDniPacient($dni);
        $this->setHour($hour);
        $this->setMinutes($minutes);
        $this->setTurnDate($date);

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fechaTurno
     *
     * @param \DateTime $turnDate
     *
     * @return Turn
     */
    public function setTurnDate($turnDate)
    {
        $this->turnDate = $turnDate;

        return $this;
    }

    /**
     * Get fechaTurno
     *
     * @return \DateTime
     */
    public function getTurnDate()
    {
        return $this->turnDate;
    }

    /**
     * Set hora
     *
     * @param integer $hour
     *
     * @return Turn
     */
    public function setHour($hour)
    {
        $this->hour = $hour;

        return $this;
    }

    /**
     * Get hora
     *
     * @return int
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * Set minutos
     *
     * @param integer $minutes
     *
     * @return Turn
     */
    public function setMinutes($minutes)
    {
        $this->minutes = $minutes;

        return $this;
    }

    /**
     * Get minutos
     *
     * @return int
     */
    public function getMinutes()
    {
        return $this->minutes;
    }

    /**
     * Set dniPaciente
     *
     * @param integer $dniPacient
     *
     * @return Turn
     */
    public function setDniPacient($dniPacient)
    {
        $this->dniPacient = $dniPacient;

        return $this;
    }

    /**
     * Get dniPaciente
     *
     * @return int
     */
    public function getDniPacient()
    {
        return $this->dniPacient;
    }
}

