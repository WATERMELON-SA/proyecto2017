<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ControlSalud
 *
 * @ORM\Table(name="control_salud")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ControlSaludRepository")
 */
class ControlSalud
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_control_salud", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="edad", type="integer")
     */
    private $edad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     * @Assert\NotBlank(message = "La fecha no puede estar en blanco")
     * @Assert\DateTime(message = "Fecha no valida")
     */
    private $fecha;

    /**
     * @var float
     *
     * @ORM\Column(name="peso", type="float")
     * @Assert\NotBlank(message = "El peso no puede estar en blanco")
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "El peso no puede ser menor que 0")
     */
    private $peso;

    /**
     * @var bool
     *
     * @ORM\Column(name="vacunas_completas", type="boolean")
     * @Assert\NotBlank(message = "El campo vacunas completas no puede estar en blanco")
     */
    private $vacunasCompletas;

    /**
     * @var bool
     *
     * @ORM\Column(name="maduracion_acorde", type="boolean")
     * @Assert\NotBlank(message = "El campo maduracion acorde no puede estar en blanco")
     */
    private $maduracionAcorde;

    /**
     * @var bool
     *
     * @ORM\Column(name="ex_fisico_normal", type="boolean")
     * @Assert\NotBlank(message = "El campo examen fisico normal no puede estar en blanco")
     */
    private $exFisicoNormal;

    /**
     * @var string
     *
     * @ORM\Column(name="ex_fisico_observaciones", type="text")
     * @Assert\NotBlank(message = "El campo examen fisico observaciones no puede estar en blanco")
     */
    private $exFisicoObservaciones;

    /**
     * @var float
     *
     * @ORM\Column(name="pc", type="float")
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "El pc no puede ser menor que 0")
     */
    private $pc;

    /**
     * @var float
     *
     * @ORM\Column(name="ppc", type="float")
     * @Assert\Range(
     * min = 0,
     * minMessage = "El ppc no puede ser menor que 0")
     */
    private $ppc;

    /**
     * @var float
     *
     * @ORM\Column(name="talla", type="float")
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "La talla no puede ser menor que 0")
     */
    private $talla;

    /**
     * @var string
     *
     * @ORM\Column(name="alimentacion", type="text")
     */
    private $alimentacion;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones_generales", type="text")
     */
    private $observacionesGenerales;

    /**  
     * @ORM\ManyToOne(targetEntity="Pacient")
     * @ORM\JoinColumn(name="id_paciente", referencedColumnName="id_paciente")
     */
    private $paciente;

    /**  
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_usuario", referencedColumnName="id_usuario")
     */
    private $usuario;

    /**
     * @var bool
     *
     * @ORM\Column(name="eliminado", type="boolean")
     */
    private $eliminado;


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
     * Set edad
     *
     * @param integer $edad
     *
     * @return ControlSalud
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return int
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return ControlSalud
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set peso
     *
     * @param float $peso
     *
     * @return ControlSalud
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return float
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set vacunasCompletas
     *
     * @param boolean $vacunasCompletas
     *
     * @return ControlSalud
     */
    public function setVacunasCompletas($vacunasCompletas)
    {
        $this->vacunasCompletas = $vacunasCompletas;

        return $this;
    }

    /**
     * Get vacunasCompletas
     *
     * @return bool
     */
    public function getVacunasCompletas()
    {
        return $this->vacunasCompletas;
    }

    /**
     * Set maduracionAcorde
     *
     * @param boolean $maduracionAcorde
     *
     * @return ControlSalud
     */
    public function setMaduracionAcorde($maduracionAcorde)
    {
        $this->maduracionAcorde = $maduracionAcorde;

        return $this;
    }

    /**
     * Get maduracionAcorde
     *
     * @return bool
     */
    public function getMaduracionAcorde()
    {
        return $this->maduracionAcorde;
    }

    /**
     * Set exFisicoNormal
     *
     * @param boolean $exFisicoNormal
     *
     * @return ControlSalud
     */
    public function setExFisicoNormal($exFisicoNormal)
    {
        $this->exFisicoNormal = $exFisicoNormal;

        return $this;
    }

    /**
     * Get exFisicoNormal
     *
     * @return bool
     */
    public function getExFisicoNormal()
    {
        return $this->exFisicoNormal;
    }

    /**
     * Set exFisicoObservaciones
     *
     * @param string $exFisicoObservaciones
     *
     * @return ControlSalud
     */
    public function setExFisicoObservaciones($exFisicoObservaciones)
    {
        $this->exFisicoObservaciones = $exFisicoObservaciones;

        return $this;
    }

    /**
     * Get exFisicoObservaciones
     *
     * @return string
     */
    public function getExFisicoObservaciones()
    {
        return $this->exFisicoObservaciones;
    }

    /**
     * Set pc
     *
     * @param float $pc
     *
     * @return ControlSalud
     */
    public function setPc($pc)
    {
        $this->pc = $pc;

        return $this;
    }

    /**
     * Get pc
     *
     * @return float
     */
    public function getPc()
    {
        return $this->pc;
    }

    /**
     * Set ppc
     *
     * @param float $ppc
     *
     * @return ControlSalud
     */
    public function setPpc($ppc)
    {
        $this->ppc = $ppc;

        return $this;
    }

    /**
     * Get ppc
     *
     * @return float
     */
    public function getPpc()
    {
        return $this->ppc;
    }

    /**
     * Set talla
     *
     * @param float $talla
     *
     * @return ControlSalud
     */
    public function setTalla($talla)
    {
        $this->talla = $talla;

        return $this;
    }

    /**
     * Get talla
     *
     * @return float
     */
    public function getTalla()
    {
        return $this->talla;
    }

    /**
     * Set alimentacion
     *
     * @param string $alimentacion
     *
     * @return ControlSalud
     */
    public function setAlimentacion($alimentacion)
    {
        $this->alimentacion = $alimentacion;

        return $this;
    }

    /**
     * Get alimentacion
     *
     * @return string
     */
    public function getAlimentacion()
    {
        return $this->alimentacion;
    }

    /**
     * Set observacionesGenerales
     *
     * @param string $observacionesGenerales
     *
     * @return ControlSalud
     */
    public function setObservacionesGenerales($observacionesGenerales)
    {
        $this->observacionesGenerales = $observacionesGenerales;

        return $this;
    }

    /**
     * Get observacionesGenerales
     *
     * @return string
     */
    public function getObservacionesGenerales()
    {
        return $this->observacionesGenerales;
    }

    /**
     * Set paciente
     *
     * @return ControlSalud
     */
    public function setPaciente($paciente)
    {
        $this->paciente = $paciente;

        return $this;
    }

    /**
     * Get paciente
     *
     */
    public function getPaciente()
    {
        return $this->paciente;
    }

    /**
     * Set usuario
     *
     * @return ControlSalud
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set eliminado
     *
     * @param boolean $eliminado
     *
     * @return ControlSalud
     */
    public function setEliminado($eliminado)
    {
        $this->eliminado = $eliminado;

        return $this;
    }

    /**
     * Get eliminado
     *
     * @return bool
     */
    public function getEliminado()
    {
        return $this->eliminado;
    }
}

