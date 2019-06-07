<?php

namespace entity;

/**
*
*/
class EntityRegion {

	private $id;
	private $nom;

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
	public function getNom() {
		return $this->nom;
	}


// SETTERS -----------------------------------------------
	/**
	* @var String
	*
	* return Object this
	*/
	public function setNom($nom) {
		$this->nom = $nom
		return $this;
	}

}
