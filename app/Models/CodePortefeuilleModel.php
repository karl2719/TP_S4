<?php

namespace App\Models;

use CodeIgniter\Model;

class CodePortefeuilleModel extends Model
{
    protected $table         = 'codes_portefeuille';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['code', 'montant', 'actif', 'utilisateur_id', 'utilise_le'];

    public function findCodeValide(string $code): ?array
    {
        return $this->where('code', $code)
            ->where('actif', 1)
            ->where('utilisateur_id', null)
            ->first();
    }

    public function utiliserCode(int $code_id, int $user_id): bool
    {
        return $this->update($code_id, [
            'utilisateur_id' => $user_id,
            'utilise_le'     => date('Y-m-d H:i:s'),
            'actif'          => 0,
        ]);
    }
}
