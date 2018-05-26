<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemographicData
 *
 * @ORM\Table(name="datos_demograficos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemographicDataRepository")
 */
class DemographicData
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_datos_demograficos", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="heladera", type="boolean", nullable=true)
     * @Assert\NotBlank(message = "El campo heladera no puede estar en blanco.")
     */
    private $heladera;

    /**
     * @var bool
     *
     * @ORM\Column(name="electricidad", type="boolean", nullable=true)
     * @Assert\NotBlank(message = "El campo electricidad no puede estar en blanco.")
     */
    private $electricidad;

    /**
     * @var bool
     *
     * @ORM\Column(name="mascota", type="boolean", nullable=true)
     * @Assert\NotBlank(message = "El campo mascota no puede estar en blanco.")
     */
    private $mascota;

    /**
     * @var int
     *
     * @ORM\Column(name="id_tipo_vivienda", type="integer")
     * @Assert\NotBlank(message = "El campo tipo de vivienda no puede estar en blanco.")
     */
    private $tipoVivienda;

    /**
     * @var int
     *
     * @ORM\Column(name="id_tipo_calefaccion", type="integer")
     * @Assert\NotBlank(message = "El campo tipo de calefaccion no puede estar en blanco.")
     */
    private $tipoCalefaccion;

    /**
     * @var int
     *
     * @ORM\Column(name="id_tipo_agua", type="integer")
     * @Assert\NotBlank(message = "El campo tipo de agua no puede estar en blanco.")
     */
    private $tipoAgua;


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
     * Set heladera
     *
     * @param boolean $heladera
     *
     * @return DemographicData
     */
    public function setHeladera($heladera)
    {
        $this->heladera = $heladera;

        return $this;
    }

    /**
     * Get heladera
     *
     * @return bool
     */
    public function getHeladera()
    {
        return $this->heladera;
    }

    /**
     * Set electricidad
     *
     * @param boolean $electricidad
     *
     * @return DemographicData
     */
    public function setElectricidad($electricidad)
    {
        $this->electricidad = $electricidad;

        return $this;
    }

    /**
     * Get electricidad
     *
     * @return bool
     */
    public function getElectricidad()
    {
        return $this->electricidad;
    }

    /**
     * Set mascota
     *
     * @param boolean $mascota
     *
     * @return DemographicData
     */
    public function setMascota($mascota)
    {
        $this->mascota = $mascota;

        return $this;
    }

    /**
     * Get mascota
     *
     * @return bool
     */
    public function getMascota()
    {
        return $this->mascota;
    }

    /**
     * Set tipoVivienda
     *
     * @param integer $tipoVivienda
     *
     * @return DemographicData
     */
    public function setTipoVivienda($tipoVivienda)
    {
        $this->tipoVivienda = $tipoVivienda;

        return $this;
    }

    /**
     * Get tipoVivienda
     *
     * @return int
     */
    public function getTipoVivienda()
    {
        return $this->tipoVivienda;
    }

    /**
     * Set tipoCalefaccion
     *
     * @param integer $tipoCalefaccion
     *
     * @return DemographicData
     */
    public function setTipoCalefaccion($tipoCalefaccion)
    {
        $this->tipoCalefaccion = $tipoCalefaccion;

        return $this;
    }

    /**
     * Get tipoCalefaccion
     *
     * @return int
     */
    public function getTipoCalefaccion()
    {
        return $this->tipoCalefaccion;
    }

    /**
     * Set tipoAgua
     *
     * @param integer $tipoAgua
     *
     * @return DemographicData
     */
    public function setTipoAgua($tipoAgua)
    {
        $this->tipoAgua = $tipoAgua;

        return $this;
    }

    /**
     * Get tipoAgua
     *
     * @return int
     */
    public function getTipoAgua()
    {
        return $this->tipoAgua;
    }

    /**
     * Set idDemographic
     *
     * @param integer $idDemographic
     *
     * @return DemographicData
     */
    public function setIdDemographic($idDemographic)
    {
        $this->idDemographic = $idDemographic;

        return $this;
    }

    /**
     * Get idDemographic
     *
     * @return int
     */
    public function getIdDemographic()
    {
        return $this->idDemographic;
    }
}

