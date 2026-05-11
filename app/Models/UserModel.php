<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nom', 'prenom', 'email', 'password', 'genre',
        'taille', 'poids', 'objectif_id', 'option_gold', 'solde_wallet',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    public static function calculerIMC(float $poids, float $taille_cm): float
    {
        $taille_m = $taille_cm / 100;
        return round($poids / ($taille_m * $taille_m), 1);
    }

    public static function interpreterIMC(float $imc): string
    {
        if ($imc < 18.5) {
            return 'Insuffisance ponderale';
        }
        if ($imc < 25.0) {
            return 'Poids normal';
        }
        if ($imc < 30.0) {
            return 'Surpoids';
        }
        return 'Obesite';
    }

    public static function calculerPoidsIdeal(float $taille_cm, string $genre): float
    {
        if ($genre === 'M') {
            return $taille_cm - 100 - ($taille_cm - 150) / 4;
        }
        return $taille_cm - 100 - ($taille_cm - 150) / 2.5;
    }

    public function crediterWallet(int $user_id, float $montant): bool
    {
        return (bool) $this->db->query(
            'UPDATE users SET solde_wallet = solde_wallet + ? WHERE id = ?',
            [$montant, $user_id]
        );
    }

    public function debiterWallet(int $user_id, float $montant): bool
    {
        return (bool) $this->db->query(
            'UPDATE users SET solde_wallet = solde_wallet - ? WHERE id = ? AND solde_wallet >= ?',
            [$montant, $user_id, $montant]
        );
    }
}
