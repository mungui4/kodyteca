<?php //Clase creada para separar el inicion de session y alamacenamiento de los libros
class Session {
    public function __construct() {
        session_start();
    }

    protected function saveSession($key, $value) {
        $_SESSION[$key] = $value;
    }

    protected function loadSession($key, $default = []) {
        return $_SESSION[$key] ?? $default;
    }
}
