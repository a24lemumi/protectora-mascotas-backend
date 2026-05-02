<?php
    namespace App\Forms;

    class MascotaFormSanitizer {
        public function sanitize($data) {
            $sanitized = [];

            if (isset($data['nombre'])) {
                $sanitized['nombre'] = trim($data['nombre']);
            }
            if (isset($data['especie'])) {
                $sanitized['especie'] = trim($data['especie']);
            }
            if (isset($data['raza'])) {
                $sanitized['raza'] = trim($data['raza']) ?: null;
            }
            if (isset($data['fecha_nac'])) {
                $sanitized['fecha_nac'] = trim($data['fecha_nac']) ?: null;
            }
            if (isset($data['imagen'])) {
                $sanitized['imagen'] = trim($data['imagen']) ?: null;
            }

            return $sanitized;
        }
    }
