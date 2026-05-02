<?php
    namespace App\Forms;

    class MascotaFormValidator {
        public function validate($data) {
            $errors = [];

            if (empty($data['nombre'])) {
                $errors[] = 'El nombre es requerido';
            }
            if (empty($data['especie'])) {
                $errors[] = 'La especie es requerida';
            }

            return $errors;
        }
    }
