<?php
    namespace App\Models;

    class UsuariosModel extends DBAbstractModel {
        public function __construct() {
            parent::__construct();
        }

        public function get($id = '') {
            $this->query = "SELECT id, username, email, telefono, nombre, apellido, created_at 
                           FROM usuarios WHERE id = :id";
            $this->parametros = [':id' => $id];
            return $this->get_single_result();
        }

        public function set() {}

        public function edit() {}

        public function delete($id = '') {
            $this->query = "DELETE FROM usuarios WHERE id = :id";
            $this->parametros = [':id' => $id];
            return $this->execute_single_query();
        }

        public function create($data) {
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            $this->query = "INSERT INTO usuarios (username, email, telefono, password, nombre, apellido) 
                           VALUES (:username, :email, :telefono, :password, :nombre, :apellido)";
            $this->parametros = [
                ':username' => $data['username'],
                ':email' => $data['email'],
                ':telefono' => $data['telefono'] ?? null,
                ':password' => $hashedPassword,
                ':nombre' => $data['nombre'] ?? null,
                ':apellido' => $data['apellido'] ?? null
            ];

            if ($this->execute_single_query()) {
                return $this->getLastInsertId();
            }
            return false;
        }

        public function read($id) {
            return $this->get($id);
        }

        public function readAll($page = 1, $limit = null) {
            $limit = $limit ?? SHPORPAGINA;
            $offset = ($page - 1) * $limit;

            $this->query = "SELECT id, username, email, telefono, nombre, apellido, created_at 
                           FROM usuarios LIMIT :limit OFFSET :offset";
            $this->parametros = [':limit' => (int)$limit, ':offset' => (int)$offset];
            return $this->get_results_from_query();
        }

        public function update($id, $data) {
            $fields = [];
            $params = [':id' => $id];

            if (isset($data['username'])) {
                $fields[] = "username = :username";
                $params[':username'] = $data['username'];
            }
            if (isset($data['email'])) {
                $fields[] = "email = :email";
                $params[':email'] = $data['email'];
            }
            if (isset($data['telefono'])) {
                $fields[] = "telefono = :telefono";
                $params[':telefono'] = $data['telefono'];
            }
            if (isset($data['nombre'])) {
                $fields[] = "nombre = :nombre";
                $params[':nombre'] = $data['nombre'];
            }
            if (isset($data['apellido'])) {
                $fields[] = "apellido = :apellido";
                $params[':apellido'] = $data['apellido'];
            }

            if (empty($fields)) {
                return false;
            }

            $this->query = "UPDATE usuarios SET " . implode(', ', $fields) . " WHERE id = :id";
            $this->parametros = $params;
            return $this->execute_single_query();
        }

        public function findByEmail($email) {
            $this->query = "SELECT * FROM usuarios WHERE email = :email";
            $this->parametros = [':email' => $email];
            return $this->get_single_result();
        }

        public function findByUsername($username) {
            $this->query = "SELECT id FROM usuarios WHERE username = :username";
            $this->parametros = [':username' => $username];
            return $this->get_single_result();
        }

        public function findByEmailForCheck($email) {
            $this->query = "SELECT id FROM usuarios WHERE email = :email";
            $this->parametros = [':email' => $email];
            return $this->get_single_result();
        }

        public function getCount() {
            $this->query = "SELECT COUNT(*) as total FROM usuarios";
            $this->parametros = [];
            $result = $this->get_single_result();
            return $result['total'] ?? 0;
        }
    }
