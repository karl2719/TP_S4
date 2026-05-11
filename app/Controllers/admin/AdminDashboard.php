<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;

class AdminDashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $stats = [
            'nb_users'     => $db->table('users')->countAll(),
            'nb_gold'      => $db->table('users')->where('option_gold', 1)->countAllResults(),
            'nb_regimes'   => $db->table('regimes')->where('actif', 1)->countAllResults(),
            'total_ventes' => (float) ($db->table('user_regimes')->selectSum('prix_paye')->get()->getRow()->prix_paye ?? 0),
        ];

        $inscrits_mois = $db->table('users')
            ->select('MONTH(created_at) as mois, COUNT(*) as total', false)
            ->groupBy('MONTH(created_at)')
            ->orderBy('mois', 'ASC')
            ->get()
            ->getResultArray();

        $objectifs_chart = $db->table('users u')
            ->select('o.libelle, COUNT(u.id) as total', false)
            ->join('objectifs o', 'u.objectif_id = o.id')
            ->groupBy('o.id')
            ->get()
            ->getResultArray();

        $top_regimes = $db->table('user_regimes ur')
            ->select('r.nom, COUNT(ur.id) as ventes, SUM(ur.prix_paye) as revenu', false)
            ->join('regimes r', 'ur.regime_id = r.id')
            ->groupBy('r.id')
            ->orderBy('ventes', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $tableau_croise = $db->table('users u')
            ->select(
                "o.libelle as objectif,
                CASE
                    WHEN (u.poids / ((u.taille/100)*(u.taille/100))) < 18.5 THEN 'Insuffisance ponderale'
                    WHEN (u.poids / ((u.taille/100)*(u.taille/100))) < 25 THEN 'Poids normal'
                    WHEN (u.poids / ((u.taille/100)*(u.taille/100))) < 30 THEN 'Surpoids'
                    ELSE 'Obesite'
                END as categorie_imc,
                COUNT(*) as total",
                false
            )
            ->join('objectifs o', 'u.objectif_id = o.id')
            ->groupBy('o.libelle, categorie_imc')
            ->get()
            ->getResultArray();

        return view('admin/dashboard', [
            'stats' => $stats,
            'inscrits_mois' => $inscrits_mois,
            'objectifs_chart' => $objectifs_chart,
            'top_regimes' => $top_regimes,
            'tableau_croise' => $tableau_croise,
        ]);
    }
}
