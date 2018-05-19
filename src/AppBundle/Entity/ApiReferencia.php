<?php  
namespace AppBundle\Entity;

class ApiReferencia {
	
	private $id;

    private $name;

    public function __construct() {}

    public static function fromArray($attributes) {
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
    		return DocumentTypeJsonParser::single(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-documento/".$value));
    	}
    	return DocumentTypeJsonParser::fromCollection(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-documento"));
    }

    public static function obraSocial($value=''){
    	if ($value!='') {
    		return DocumentTypeJsonParser::single(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/obra-social/".$value));
    	}
    	return DocumentTypeJsonParser::fromCollection(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/obra-social"));
    }

	public static function tipoAgua($value=''){
    	if ($value!='') {
    		return DocumentTypeJsonParser::single(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-agua/".$value));
    	}
    	return DocumentTypeJsonParser::fromCollection(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-agua"));
    }

	public static function tipoCalefaccion($value=''){
    	if ($value!='') {
    		return DocumentTypeJsonParser::single(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-calefaccion/".$value));
    	}
    	return DocumentTypeJsonParser::fromCollection(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-calefaccion"));
    }

	public static function tipoVivienda($value=''){
    	if ($value!='') {
    		return DocumentTypeJsonParser::single(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-vivienda/".$value));
    	}
    	return DocumentTypeJsonParser::fromCollection(file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-vivienda"));
    }
}

class DocumentTypeJsonParser {

    private function __construct() {}

    public static function single($json) {
        return Referencia::fromArray(json_decode($json, true));
    }

    public static function fromCollection($json_collection) {
        $data = json_decode($json_collection, true);

        foreach($data as $single_json) {
          $array[]= Referencia::fromArray($single_json);
        }
        return $array;
    }
}

?>