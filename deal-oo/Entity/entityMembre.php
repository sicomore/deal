<?php

namespace entity;

/**
*
*/
class EntityMembre {

	private $id;
	private $civilite;
	private $pseudo;
	private $mdp;
	private $nom;
	private $prenom;
	private $telephone;
	private $email;
	private $role;
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
	public function getCivilite() {
		return $this->civilite;
	}

	/**
	* return String
	*/
	public function getPseudo() {
		return $this->pseudo;
	}

	/**
	* return String
	*/
	public function getMdp() {
		return $this->mdp;
	}

	/**
	* return String
	*/
	public function getNom() {
		return $this->nom;
	}

	/**
	* return String
	*/
	public function getPrenom()	{
		return $this->prenom;
	}

	/**
	* return Int
	*/
	public function getTelephone()	{
		return $this->telephone;
	}

	/**
	* return String
	*/
	public function getEmail()	{
		return $this->email;
	}

	/**
	* return String
	*/
	public function getRole()	{
		return $this->role;
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
	* return String
	*/
	public function setCivilite($civilite) {
		$this->civilite = $civilite
		return $this;
	}

	/**
	* @var String
	*
	* return String
	*/
	public function setPseudo($pseudo) {
		$this->pseudo = $pseudo
		return $this;
	}

	/**
	* @var String
	*
	* return String
	*/
	public function setMdp($mdp) {
		$this->mdp = $mdp
		return $this;
	}

	/**
	* @var String
	*
	* return String
	*/
	public function setNom($nom) {
		$this->nom = $nom
		return $this;
	}

	/**
	* @var String
	*
	* return String
	*/
	public function setPrenom($prenom) {
		$this->prenom = $prenom
		return $this;
	}

	/**
	* @var Int
	*
	* return Object this
	*/
	public function setTelephone($telephone) {
		$this->telephone = $telephone
		return $this;
	}

	/**
	* @var String
	*
	* return Object this
	*/
	public function setEmail($email) {
		$this->email = $email
		return $this;
	}

	/**
	* @var String
	*
	* return Object this
	*/
	public function setRole($role) {
		$this->role = $role
		return $this;
	}

	/**
	* @var String
	*
	* return Object this
	*/
	public function setUserId($userId) {
		$this->userId = $userId
		return $this;
	}

}
