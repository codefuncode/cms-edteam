<?php
require_once 'ModeloAccessBD.php';

class Usuario extends ModeloAccessBD {
	public $nombre;
	public $apodo;
	public $email;
	public $password;

	public function __construct() {
		parent::__construct();
	}

	function getNombre() {
		return $this->nombre;
	}

	function getEmail() {
		return $this->email;
	}

	function getPassword() {
		return $this->password;
	}

	function setNombre($nombre) {
		$this->nombre = $nombre;
	}

	function setEmail($email) {
		$this->email = $email;
	}

	function setPassword($password) {
		$this->password = $password;
	}

	function guardarUsuario($datos) {
		$db = new ModeloAccessBD();
		$insertar = $db->insertar('usuarios', $datos);
		if ($insertar == true) {
			$_SESSION['mensaje'] = 'Registro exitoso';
		}
	}

	public function accesoUsuario($apodo, $password) {
		$db = new ModeloAccessBD();
		$query = "SELECT * FROM usuarios WHERE apodo = '".$apodo. "' AND password = '".$password . "'";
		$respuesta = $db->consultar($query);
		if ($respuesta == true) {
			session_start();
			$_SESSION['apodo'] = $apodo;
		}
	}

}
