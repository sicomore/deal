<?php

namespace entity;

/**
*
*/
class EntityCategorie {

	private $id;
	private $titre;
	private $motsCles;

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
	public function getTitre() {
		return $this->titre;
	}

	/**
	* return String
	*/
	public function getMotsCles()	{
		return $this->motsCles;
	}


// SETTERS -----------------------------------------------
	/**
	* @var String
	*
	* return Object this
	*/
	public function setTitre($titre) {
		$this->titre = $titre
		return $this;
	}

	/**
	* @var String
	*
	* return Object this
	*/
	public function setMotsCles($motsCles) {
		$this->motsCles = $motsCles
		return $this;
	}

}
