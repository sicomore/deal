<?php

namespace entity;

/**
*
*/
class EntityAnnonce {

	private $id;
	private $dispo;
	private $titre;
	private $descriptionCourte;
	private $descriptionLongue;
	private $prix;
	private $photo;
	private $ville;
	private $adresse;
	private $codePostal;
	private $membreId;
	private $categorieId;
	private $regionId;
	private $dateEnregistrement;


// GETTERS ---------------------------------------
	/**
	* return Int
	*/
	public function getId()	{
		return $this->id;
	}

	/**
	* return String
	*/
	public function getDispo() {
		return $this->dispo;
	}

	/**
	* return String
	*/
	public function getTitre()	{
		return $this->titre;
	}

	/**
	* return String
	*/
	public function getDescriptionCourte()	{
		return $this->descriptionCourte;
	}

	/**
	* return String
	*/
	public function getDescriptionLongue()	{
		return $this->descriptionLongue;
	}

	/**
	* return Int
	*/
	public function getPrix()	{
		return $this->prix;
	}

	/**
	* return String
	*/
	public function getPhoto() {
		return $this->photo;
	}

	/**
	* return String
	*/
	public function getVille()	{
		return $this->ville;
	}

	/**
	* return String
	*/
	public function getAdresse() {
		return $this->adresse;
	}

	/**
	* return Int
	*/
	public function getCodePostal()	{
		return $this->codePostal;
	}

	/**
	* return Int
	*/
	public function getMembreId()	{
		return $this->membreId;
	}

	/**
	* return Int
	*/
	public function getCategorieId()	{
		return $this->categorieId;
	}

	/**
	* return Int
	*/
	public function getRegionId()	{
		return $this->regionId;
	}

	/**
	* return Date
	*/
	public function getDateEnregistrement()	{
		return $this->dateEnregistrement;
	}


// SETTERS -----------------------------------------------
	/**
	* @var String
	*
	* return Object
	*/
	public function setDispo($dispo) {
		$this->dispo = $dispo;
		return $this;
	}

	/**
	* @var String
	*
	* return Object
	*/
	public function setTitre($titre)	{
		$this->titre = $titre;
		return $this;
	}

	/**
	* @var String
	*
	* return Object
	*/
	public function setDescriptionCourte($descriptionCourte)	{
		$this->descriptionCourte = $descriptionCourte;
		return $this;
	}

	/**
	* @var String
	*
	* return Object
	*/
	public function setDescriptionLongue($descriptionLongue)	{
		$this->descriptionLongue = $descriptionLongue;
		return $this;
	}

	/**
	* @var Int
	*
	* return Object
	*/
	public function setPrix($prix)	{
		$this->prix = $prix;
		return $this;
	}

	/**
	* @var String
	*
	* return Object
	*/
	public function setPhoto($photo) {
		$this->photo = $photo;
		return $this;
	}

	/**
	* @var String
	*
	* return Object
	*/
	public function setVille($ville)	{
		$this->ville = $ville;
		return $this;
	}

	/**
	* @var String
	*
	* return Object
	*/
	public function setAdresse($adresse) {
		$this->adresse = $adresse;
		return $this;
	}

	/**
	* @var Int
	*
	* return Object
	*/
	public function setCodePostal($codePostal)	{
		$this->codePostal = $codePostal;
		return $this;
	}

	/**
	* @var Int
	*
	* return Object
	*/
	public function setMembreId($membreId)	{
		$this->membreId = $membreId;
		return $this;
	}

	/**
	* @var Int
	*
	* return Object
	*/
	public function setCategorieId($categorieId)	{
		$this->categorieId = $categorieId;
		return $this;
	}

	/**
	* @var Int
	*
	* return Object
	*/
	public function setRegionId($regionId)	{
		$this->regionId = $regionId;
		return $this;
	}

	/**
	* @var Date
	*
	* return Object
	*/
	public function setDateEnregistrement($dateEnregistrement)	{
		$this->dateEnregistrement = $dateEnregistrement;
		return $this;
	}

}
