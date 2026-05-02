<?php
    namespace App\Forms;

    use App\Forms\UsuarioFormValidator;
    use App\Forms\UsuarioFormSanitizer;

    class UsuarioForm {
        private $data = [];
        private $errors = [];
        private $sanitizer;
        private $validator;

        public function __construct() {
            $this->sanitizer = new UsuarioFormSanitizer();
            $this->validator = new UsuarioFormValidator();
        }

        public function submit($type = 'register') {
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data)) {
                $data = $_POST;
            }

            $this->data = $this->sanitizer->sanitize($data);
            $this->errors = $this->validator->validate($this->data, $type);

            return empty($this->errors);
        }

        public function getData() {
            return $this->data;
        }

        public function getErrors() {
            return $this->errors;
        }
    }
