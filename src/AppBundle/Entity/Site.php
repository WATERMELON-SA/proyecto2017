<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Site
 *
 * @ORM\Table(name="config_hospital")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SiteRepository")
 */
class Site
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var text
     *
     * @ORM\Column(name="email", type="text")
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="elementos_pagina", type="integer")
     */
    private $elementosPagina;

    /**
     * @var bool
     *
     * @ORM\Column(name="sitio_habilitado", type="boolean")
     */
    private $sitioHabilitado;


    /**
     * Get id
     *
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Site
     */
    public function setTitulo($titulo){
        if ($this->isUpdateable($titulo, $this->titulo)) {
            $this->titulo = $titulo;
        }

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo(){
        return $this->titulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Site
     */
    public function setDescripcion($descripcion){
        if ($this->isUpdateable($descripcion, $this->descripcion)) {
           $this->descripcion = $descripcion;
        }
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion(){
        return $this->descripcion;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Site
     */
    public function setEmail($email){
        if ($this->isUpdateable($email, $this->email)) {
            $this->email = $email;
        }
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set elementosPagina
     *
     * @param integer $elementosPagina
     *
     * @return Site
     */
    public function setElementosPagina($elementosPagina)
    {
        if ($this->isUpdateable($elementosPagina, $this->elementosPagina)) {
            $this->elementosPagina = $elementosPagina;
        }
        return $this;
    }

    /**
     * Get elementosPagina
     *
     * @return int
     */
    public function getElementosPagina()
    {
        return $this->elementosPagina;
    }

    /**
     * Set sitioHabilitado
     *
     * @param boolean $sitioHabilitado
     *
     * @return Site
     */
    public function setSitioHabilitado($sitioHabilitado)
    {
        if ($this->isUpdateable($sitioHabilitado, $this->sitioHabilitado)) {
            $this->sitioHabilitado = $sitioHabilitado;
        }
        return $this;
    }

    /**
     * Get sitioHabilitado
     *
     * @return bool
     */
    public function getSitioHabilitado()
    {
        return $this->sitioHabilitado;
    }

    private function isUpdateable($new_value,$old_value){
        return ((isset($new_value)) && ($new_value!=$old_value) && ($new_value!=''));
    }
}

