<?php
    namespace App\Models;

    class MascotasModel extends DBAbstractModel {
        public function __construct() {
            parent::__construct();
        }

        public function get($id = '') {
            $this->query = "SELECT m.*, u.username, u.email as usuario_email 
                           FROM mascotas m 
                           LEFT JOIN usuarios u ON m.usuario_id = u.id 
                           WHERE m.id = :id";
            $this->parametros = [':id' => $id];
            return $this->get_single_result();
        }

        public function set() {}

        public function edit() {}

        public function delete($id = '') {
            $this->query = "DELETE FROM mascotas WHERE id = :id";
            $this->parametros = [':id' => $id];
            return $this->execute_single_query();
        }

        public function create($data) {
            $this->query = "INSERT INTO mascotas (nombre, especie, raza, fecha_nac, imagen, usuario_id) 
                           VALUES (:nombre, :especie, :raza, :fecha_nac, :imagen, :usuario_id)";
            $this->parametros = [
                ':nombre' => $data['nombre'],
                ':especie' => $data['especie'],
                ':raza' => $data['raza'] ?? null,
                ':fecha_nac' => $data['fecha_nac'] ?? null,
                ':imagen' => $data['imagen'] ?? null,
                ':usuario_id' => $data['usuario_id'] ?? null
            ];

            if ($this->execute_single_query()) {
                return $this->getLastInsertId();
            }
            return false;
        }

        public function read($id) {
            return $this->get($id);
        }

        public function readAll($page = 1, $limit = null, $filters = []) {
            $limit = $limit ?? SHPORPAGINA;
            $offset = ($page - 1) * $limit;

            $where = "";
            $params = [':limit' => (int)$limit, ':offset' => (int)$offset];

            if (!empty($filters['especie'])) {
                $where .= " WHERE m.especie = :especie";
                $params[':especie'] = $filters['especie'];
            }
            if (!empty($filters['raza'])) {
                $where .= ($where ? " AND" : " WHERE") . " m.raza = :raza";
                $params[':raza'] = $filters['raza'];
            }

            $this->query = "SELECT m.*, u.username, u.email as usuario_email 
                           FROM mascotas m 
                           LEFT JOIN usuarios u ON m.usuario_id = u.id 
                           $where 
                           LIMIT :limit OFFSET :offset";
            $this->parametros = $params;
            return $this->get_results_from_query();
        }

        public function update($id, $data, $usuario_id = null) {
            $fields = [];
            $params = [':id' => $id];

            if (isset($data['nombre'])) {
                $fields[] = "nombre = :nombre";
                $params[':nombre'] = $data['nombre'];
            }
            if (isset($data['especie'])) {
                $fields[] = "especie = :especie";
                $params[':especie'] = $data['especie'];
            }
            if (isset($data['raza'])) {
                $fields[] = "raza = :raza";
                $params[':raza'] = $data['raza'];
            }
            if (isset($data['fecha_nac'])) {
                $fields[] = "fecha_nac = :fecha_nac";
                $params[':fecha_nac'] = $data['fecha_nac'];
            }
            if (isset($data['imagen'])) {
                $fields[] = "imagen = :imagen";
                $params[':imagen'] = $data['imagen'];
            }

            if (empty($fields)) {
                return false;
            }

            $sql = "UPDATE mascotas SET " . implode(', ', $fields) . " WHERE id = :id";
            if ($usuario_id !== null) {
                $sql .= " AND usuario_id = :usuario_id";
                $params[':usuario_id'] = $usuario_id;
            }

            $this->query = $sql;
            $this->parametros = $params;
            return $this->execute_single_query();
        }

        public function deleteWithOwner($id, $usuario_id) {
            $this->query = "DELETE FROM mascotas WHERE id = :id AND usuario_id = :usuario_id";
            $this->parametros = [':id' => $id, ':usuario_id' => $usuario_id];
            return $this->execute_single_query();
        }

        public function findByUsuarioId($usuario_id) {
            $this->query = "SELECT * FROM mascotas WHERE usuario_id = :usuario_id ORDER BY id DESC";
            $this->parametros = [':usuario_id' => $usuario_id];
            return $this->get_results_from_query();
        }

        public static function adoptPet($id, $userId) {
            $model = new self();
            $model->query = "UPDATE mascotas SET usuario_id = :usuario_id WHERE id = :id AND usuario_id IS NULL";
            $model->parametros = [':id' => $id, ':usuario_id' => $userId];
            return $model->execute_single_query();
        }

        public function getCount($filters = []) {
            $where = "";
            $params = [];

            if (!empty($filters['especie'])) {
                $where .= " WHERE especie = :especie";
                $params[':especie'] = $filters['especie'];
            }
            if (!empty($filters['raza'])) {
                $where .= ($where ? " AND" : " WHERE") . " raza = :raza";
                $params[':raza'] = $filters['raza'];
            }

            $this->query = "SELECT COUNT(*) as total FROM mascotas $where";
            $this->parametros = $params;
            $result = $this->get_single_result();
            return $result['total'] ?? 0;
        }
    }
