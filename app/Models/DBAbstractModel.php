<?php
    /**
     * Descripcion: Clase abstracta base para el acceso a datos utilizando el patrón Singleton
     * para la conexión a base de datos.
     *
     * @author Miguel Ángel Leiva
     * @date 24-02-2026
    */

    namespace App\Models;

    use App\Exceptions\DatabaseException;
    
    abstract class DBAbstractModel
    {
        
        // Host de la base de datos
        private static $db_host;
        
        // Usuario de la base de datos
        private static $db_user;
        
        // Contraseña de la base de datos
        private static $db_pass;
        
        // Nombre de la base de datos
        private static $db_name;
        
        // Puerto de la base de datos
        private static $db_port;
        
        // Instancia única de connexión (patrón Singleton)
        private static $connection = null;
        
        // Mensaje de estado de la última operación
        protected $mensaje = '';
        
        // Query SQL a ejecutar
        protected $query;
        
        // Parámetros para el query preparado
        protected $parametros = [];
        
        // Filas resultado de la consulta
        protected $rows = [];
        
        // Número de filas afectadas por la última operación
        protected $affected_rows = 0;
        
        // Método abstracto para obtener un registro por ID
        abstract protected function get($id = '');
        
        // Método abstracto para insertar un nuevo registro
        abstract protected function set();
        
        // Método abstracto para actualizar un registro
        abstract protected function edit();
        
        // Método abstracto para eliminar un registro por ID
        abstract protected function delete($id = '');
        
        // Constructor que inicializa los parámetros de conexión desde variables de entorno
        public function __construct()
        {
       
            if (self::$db_host === null) {
                self::$db_host = $_ENV['DBHOST'] ?? 'localhost';
                self::$db_user = $_ENV['DBUSER'] ?? 'root';
                self::$db_pass = $_ENV['DBPASS'] ?? '';
                self::$db_name = $_ENV['DBNAME'] ?? '';
                self::$db_port = $_ENV['DBPORT'] ?? '3306';
            }
        }

        // Obtiene la conexión única de la base de datos (patrón Singleton)
        protected function getConnection()
        {
            if (self::$connection === null) {
                self::$connection = $this->open_connection();
            }
            return self::$connection;
        }

        // Establece la conexión inicial a la base de datos
        private function open_connection()
        {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;port=%s;charset=utf8mb4',
                self::$db_host,
                self::$db_name,
                self::$db_port
            );

            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
                
            ];

            try {
                $pdo = new \PDO($dsn, self::$db_user, self::$db_pass, $options);
                return $pdo;
            } catch (\PDOException $e) {
                throw new DatabaseException("Error de conexión: " . $e->getMessage());
            }
        }

        // Obtiene el ID del último registro insertado
        public function getLastInsertId()
        {
            return $this->getConnection()->lastInsertId();
        }

        // Ejecuta una consulta SQL que no devuelve resultados (INSERT, UPDATE, DELETE)
        protected function execute_single_query()
        {
           
            try {
                $conn = $this->getConnection();
                $stmt = $conn->prepare($this->query);
                
                $result = $stmt->execute($this->parametros);
                $this->affected_rows = $stmt->rowCount();
              
                return $result;
                
            } catch (\PDOException $e) {
                throw new DatabaseException("Error en consulta: " . $e->getMessage());
            }
        }

        // Ejecuta una consulta SQL que devuelve resultados (SELECT)
        protected function get_results_from_query()
        {
         
            try {
                $conn = $this->getConnection();
               
                $stmt = $conn->prepare($this->query);
                
                $stmt->execute($this->parametros);
                
                $this->rows = $stmt->fetchAll();
                
                
                $this->affected_rows = $stmt->rowCount();
                
                return $this->rows;
                
            } catch (\PDOException $e) {
                throw new DatabaseException("Error en consulta: " . $e->getMessage());
            }
        }

        // Obtiene un único resultado de la consulta
        protected function get_single_result()
        {
            $this->get_results_from_query();
            return $this->rows[0] ?? null;
        }

        // Inicia una transacción de base de datos
        public function beginTransaction()
        {
            return $this->getConnection()->beginTransaction();
        }

        // Confirma una transacción de base de datos
        public function commit()
        {
            return $this->getConnection()->commit();
        }

        // Revierte una transacción de base de datos
        public function rollBack()
        {
            return $this->getConnection()->rollBack();
        }

        // Obtiene las filas resultado de la última consulta
        public function getRows()
        { 
            return $this->rows; 
        }

        // Obtiene el número de filas afectadas por la última operación
        public function getAffectedRows()
        { 
            return $this->affected_rows; 
        }

        // Obtiene el mensaje de estado de la última operación
        public function getMensaje()
        { 
            return $this->mensaje; 
        }

        // Limpia los parámetros internos para la siguiente consulta
        protected function clearParameters()
        {
            $this->parametros = [];
            $this->query = '';
            $this->rows = [];
            $this->affected_rows = 0;
        }

        // Cierra la conexión única de base de datos
        public static function closeConnection()
        {
            self::$connection = null;
        }
    }