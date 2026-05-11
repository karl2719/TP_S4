<?php

namespace App\Models;

use CodeIgniter\Model;

class ParametreModel extends Model
{
    protected $table         = 'parametres';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['cle', 'valeur', 'description'];

    public function get(string $cle, $default = null)
    {
        $row = $this->where('cle', $cle)->first();
        return $row ? $row['valeur'] : $default;
    }

    public function setParametre(string $cle, string $valeur): bool
    {
        $existing = $this->where('cle', $cle)->first();
        if ($existing) {
            return $this->update($existing['id'], ['valeur' => $valeur]);
        }

        return (bool) $this->insert(['cle' => $cle, 'valeur' => $valeur]);
    }
}
