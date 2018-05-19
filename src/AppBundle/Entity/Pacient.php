<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pacient
 *
 * @ORM\Table(name="paciente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PacientRepository")
 */
class Pacient
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_paciente", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nac", type="date")
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="genero", type="text")
     */
    private $gender;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer", unique=true)
     */
    private $dniNumber;

    /**
     * @var bool
     *
     * @ORM\Column(name="borrado", type="boolean")
     */
    private $deleted;

    /**
     * @var int
     *
     * @ORM\Column(name="obra_social_id", type="integer", nullable=true)
     */
    private $idObraSocial;

    /**
     * @var int
     *
     * @ORM\Column(name="tipo_doc_id", type="integer")
     */
    private $idTipoDoc;

    /**
     * @var int
     *
     * @ORM\Column(name="datos_demograficos_id", type="integer", nullable=true)
     */
    private $demographicData;



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
     * Set nombre
     *
     * @param string $name
     *
     * @return Pacient
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set apellido
     *
     * @param string $surname
     *
     * @return Pacient
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set direccion
     *
     * @param string $address
     *
     * @return Pacient
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set tel
     *
     * @param string $phone
     *
     * @return Pacient
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fecha_nac
     *
     * @param \DateTime $birthDate
     *
     * @return Pacient
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get fecha_nac
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set genero
     *
     * @param string $gender
     *
     * @return Pacient
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get genero
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set numero
     *
     * @param integer $dniNumber
     *
     * @return Pacient
     */
    public function setDniNumber($dniNumber)
    {
        $this->dniNumber = $dniNumber;

        return $this;
    }

    /**
     * Get numero
     *
     * @return int
     */
    public function getDniNumber()
    {
        return $this->dniNumber;
    }

    /**
     * Set borrado
     *
     * @param boolean $deleted
     *
     * @return Pacient
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get borrado
     *
     * @return bool
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set obra_social_id
     *
     * @param integer $idObraSocial
     *
     * @return Pacient
     */
    public function setIdObraSocial($idObraSocial)
    {
        $this->idObraSocial = $idObraSocial;

        return $this;
    }

    /**
     * Get obra_social_id
     *
     * @return int
     */
    public function getIdObraSocial()
    {
        return $this->idObraSocial;
    }

    /**
     * Set tipo_doc_id
     *
     * @param integer $idTipoDoc
     *
     * @return Pacient
     */
    public function setIdTipoDoc($idTipoDoc)
    {
        $this->idTipoDoc = $idTipoDoc;

        return $this;
    }

    /**
     * Get tipo_doc_id
     *
     * @return int
     */
    public function getIdTipoDoc()
    {
        return $this->idTipoDoc;
    }

    public function getDemographic(){
        return $this->demographicData;
    }


    /**
     * Set datos_demograficos_id
     *
     * @param integer $demographicDataId
     *
     * @return Pacient
     */
    public function setDemographicData($id){
        $this->demographicData = $id;

        return $this;
    }

}

