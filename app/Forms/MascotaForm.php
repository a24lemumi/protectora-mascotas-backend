<?php
    namespace App\Forms;

    use App\Forms\MascotaFormValidator;
    use App\Forms\MascotaFormSanitizer;

    class MascotaForm {
        private $data = [];
        private $errors = [];
        private $sanitizer;
        private $validator;

        public function __construct() {
            $this->sanitizer = new MascotaFormSanitizer();
            $this->validator = new MascotaFormValidator();
        }

        public function submit() {
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data)) {
                $data = $_POST;
            }

            $this->data = $this->sanitizer->sanitize($data);
            $this->errors = $this->validator->validate($this->data);

            return empty($this->errors);
        }

        public function getData() {
            return $this->data;
        }

        public function getErrors() {
            return $this->errors;
        }
    }
