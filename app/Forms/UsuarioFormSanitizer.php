<?php
    namespace App\Forms;

    class UsuarioFormSanitizer {
        public function sanitize($data) {
            $sanitized = [];

            if (isset($data['username'])) {
                $sanitized['username'] = trim($data['username']);
            }
            if (isset($data['email'])) {
                $sanitized['email'] = trim($data['email']);
            }
            if (isset($data['password'])) {
                $sanitized['password'] = $data['password'];
            }

            return $sanitized;
        }
    }
