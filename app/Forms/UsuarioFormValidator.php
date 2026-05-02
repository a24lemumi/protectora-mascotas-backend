<?php
    namespace App\Forms;

    class UsuarioFormValidator {
        public function validate($data, $type = 'register') {
            $errors = [];

            if ($type === 'login') {
                if (empty($data['email'])) {
                    $errors[] = 'El email es requerido';
                }
                if (empty($data['password'])) {
                    $errors[] = 'La contraseña es requerida';
                }
            } else {
                if (empty($data['username'])) {
                    $errors[] = 'El nombre de usuario es requerido';
                }
                if (empty($data['email'])) {
                    $errors[] = 'El email es requerido';
                }
                if (empty($data['password'])) {
                    $errors[] = 'La contraseña es requerida';
                }
            }

            return $errors;
        }
    }
