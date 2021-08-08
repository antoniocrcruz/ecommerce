<?php

namespace antoniocrcruz;

class Model {

    private $values = [];

    public function __call($name, $args)//__call - método mágico serve para indicar o método chamado $nome dos métodos chamados e $args argumentos passados
    {
        $method = substr($name, 0, 3); //traga o nome da posição 0 até a terceira posição no caso, [2], 0, 1, 2. substr - fatia a variável e devolve o início da busca e a quantidade de indices

        $fieldname = substr($name, 3, strlen($name));

        switch ($method)
        {
            case "get":
                return (isset($this->values[$fieldname])) ? $this->values[$fieldname] : NULL;
            break;

            case "set":
                $this->values[$fieldname] = $args[0];
            break;
        }
    }

    public function setData($data = array())
    {
        foreach ($data as $key => $value){
            $this->{"set".$key}($value);//para colocar dados dinamicamente devemos fazer uso de chaves e colocar as informações por string dentro das chaves
        }
        
    }
    public function getValues()
    {
        return $this->values;//acessa dessa forma pois os dados são privados
    }
}
?>