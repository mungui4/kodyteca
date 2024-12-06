<?php
class Author { //Define las instancias de tipo autor para en un futuro agregar mas caracteristicas
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }


    public function __toString() {
        return $this->name;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }
}

