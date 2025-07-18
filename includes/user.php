<?php
include 'db.php';

class User extends DB {
    private $nombre;
    private $username;

    public function userExists($user, $pass) {
        $md5pass = md5($pass);
        $query = $this->connect()->prepare('SELECT * FROM usuarios WHERE username = :user AND password = :pass');
        $query->execute(['user' => $user, 'pass' => $md5pass]);

        // DEBUG: revisar filas
        // var_dump($query->rowCount());

        return $query->rowCount() > 0;
    }

    public function setUser($user) {
        $query = $this->connect()->prepare('SELECT * FROM usuarios WHERE username = :user');
        $query->execute(['user' => $user]);

        // Fetch el usuario
        $currentUser = $query->fetch();

        if ($currentUser) {
            $this->nombre = $currentUser['nombre'];
            $this->username = $currentUser['username'];
        } else {
            $this->nombre = null;
            $this->username = null;
        }
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getTipoUsuario($user) {
        $query = $this->connect()->prepare('SELECT tipo_usuario FROM usuarios WHERE username = :user');
        $query->execute(['user' => $user]);
        $row = $query->fetch();

        if ($row && isset($row['tipo_usuario'])) {
            return $row['tipo_usuario'];
        } else {
            return null;
        }
    }
}
?>
