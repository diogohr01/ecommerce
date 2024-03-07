<?php

namespace Hcode;

class Model {



		private $values = [];
		private $fields = []; // Adicionando a propriedade $fields
	
		public function __construct(array $fields) {
			$this->fields = $fields; // Inicializando a propriedade $fields
		}

    public function setData($data)
    {
        foreach ($data as $key => $value)
        {
            $this->{"set".$key}($value);
        }
    }

    public function __call($name, $args)
    {
        $method = substr($name, 0, 3);
        $fieldName = lcfirst(substr($name, 3));

        if (in_array($fieldName, $this->fields))
        {
            switch ($method)
            {
                case "get":
                    return $this->values[$fieldName];
                break;

                case "set":
                    $this->values[$fieldName] = $args[0];
                break;
            }
        }
    }

    public function getValues()
    {
        return $this->values;
    }
}

?>
