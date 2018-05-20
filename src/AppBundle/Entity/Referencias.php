<?php  

namespace AppBundle\Entity;


class Referencias {
	
	private $id;

    private $name;

    public function __construct() {}

    private function fromArray($attributes) {
        $instance = new self();
        $instance->setId($attributes['id']);
        $instance->setName($attributes['nombre']);
        return $instance;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function name() {
        return $this->name;
    }

    public function id() {
        return $this->id;
    }

    public static function documentType($value=''){
    	if ($value!='') {
    		return Referencias::single(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-documento/".$value));
    	}
    	return Referencias::fromCollection(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-documento"));
    }

    public static function obraSocial($value=''){
    	if ($value!='') {
    		return Referencias::single(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/obra-social/".$value));
    	}
    	return Referencias::fromCollection(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/obra-social"));
    }

	public static function tipoAgua($value=''){
    	if ($value!='') {
    		return Referencias::single(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-agua/".$value));
    	}
    	return Referencias::fromCollection(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-agua"));
    }

	public static function tipoCalefaccion($value=''){
    	if ($value!='') {
    		return Referencias::single(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-calefaccion/".$value));
    	}
    	return Referencias::fromCollection(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-calefaccion"));
    }

	public static function tipoVivienda($value=''){
    	if ($value!='') {
    		return Referencias::single(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-vivienda/".$value));
    	}
    	return Referencias::fromCollection(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-vivienda"));
    }
    
    private function single($json) {
        return Referencias::fromArray(json_decode($json, true));
    }
    
    private function fromCollection($json_collection) {
        $data = json_decode($json_collection, true);

        foreach($data as $single_json) {
          $array[]= Referencias::fromArray($single_json);
        }
        return $array;
    }
}

?>