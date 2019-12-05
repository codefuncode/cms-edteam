<?php
require_once 'ModeloAccessBD.php';

class Blog extends ModeloAccessBD {

	public function __construct() {
		parent::__construct();
	}

	public function obtenerCategorias() {
		$db = new ModeloAccessBD();
		$query = "SELECT * FROM categorias ORDER BY categoria";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	public function guardarPublicacion($datos) {
		$db = new ModeloAccessBD();
		try {
			$insertar = $db->insertar('articulos', $datos);
			if ($insertar == true) {
				$_SESSION['mensaje'] = 'Artículo publicado';
			}
		} catch (PDOException $e) {
			$_SESSION['mensaje'] = $e->getMessage();
		}
	}

	public function mostrarArticulos($tipo, $limite) {
		$db = new ModeloAccessBD();
		$query = "SELECT articulos.*, usuarios.apodo, categorias.categoria FROM articulos
							LEFT JOIN usuarios ON usuarios.id = articulos.publicado_por
							LEFT JOIN categorias ON categorias.id = articulos.id_categoria";
		if ($tipo == 'r') {
			$query.=" WHERE tipo = 'r' ";
		} else if ($tipo == 'p'){
			$query.=" WHERE tipo = 'p' ";
		}

		$query .= " ORDER BY fecha_creacion LIMIT ".$limite;

		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	public function buscarArticulos($cadena, $limite) {
		$db = new ModeloAccessBD();
		$query = "SELECT articulos.*, usuarios.apodo, categorias.categoria FROM articulos
							LEFT JOIN usuarios ON usuarios.id = articulos.publicado_por
							LEFT JOIN categorias ON categorias.id = articulos.id_categoria
							WHERE titulo LIKE '%".$cadena."%'";

		$resultado = $this->obtenerTodos($query);
		return $resultado;
	}

	public function obtenerArticulo($slug) {
		$db = new ModeloAccessBD();
		$query = "SELECT articulos.*, usuarios.apodo, categorias.categoria FROM articulos
							LEFT JOIN usuarios ON usuarios.id = articulos.publicado_por
							LEFT JOIN categorias ON categorias.id = articulos.id_categoria
							WHERE slug = '".$slug."'";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	public function obtenerIdArticulo($slug) {
		$db = new ModeloAccessBD();
		$query = "SELECT id FROM articulos WHERE slug = '".$slug."'";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

	public function guardarComentario($datos) {
		$db = new ModeloAccessBD();
		try {
			$insertar = $db->insertar('comentarios', $datos);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function obtenerComentarios($id_articulo) {
		$db = new ModeloAccessBD();
		$query = "SELECT * FROM comentarios
				  LEFT JOIN usuarios ON usuarios.id = comentarios.id_usuario
				  WHERE id_articulo = '".$id_articulo."'";
		$resultado = $db->obtenerTodos($query);
		return $resultado;
	}

}
