<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = [
            [
                'question' => 'Qu\'est-ce que HitMaster Arcade ?',
                'answer' => 'HitMaster Arcade est un fabricant de contrôleurs d\'arcade personnalisés et de périphériques pour jeux de combat. Nous proposons des boîtiers d\'arcade de haute qualité, des boutons, des joysticks et des accessoires pour améliorer votre expérience de jeu.'
            ],
            [
                'question' => 'Vos produits sont-ils compatibles avec toutes les consoles ?',
                'answer' => 'La plupart de nos contrôleurs sont compatibles avec PC, PlayStation 4, PlayStation 5, et Nintendo Switch. Certains modèles sont également compatibles avec Xbox One et Xbox Series X/S. Veuillez vérifier la description de chaque produit pour les détails de compatibilité.'
            ],
            [
                'question' => 'Puis-je personnaliser mon contrôleur ?',
                'answer' => 'Oui ! Nous offrons de nombreuses options de personnalisation, y compris le choix des couleurs, des boutons, des joysticks, et même des designs personnalisés pour le panneau supérieur. Consultez notre page de personnalisation pour plus de détails.'
            ],
            [
                'question' => 'Quel est le délai de livraison pour un contrôleur personnalisé ?',
                'answer' => 'Le délai de fabrication pour un contrôleur personnalisé est généralement de 2 à 3 semaines. Le temps d\'expédition varie ensuite selon votre localisation. Nous vous fournirons une estimation plus précise lors de votre commande.'
            ],
            [
                'question' => 'Proposez-vous des pièces détachées ?',
                'answer' => 'Oui, nous vendons des pièces détachées telles que des boutons, des joysticks, des PCB, et des câbles. Vous pouvez les trouver dans la section "Pièces et Accessoires" de notre boutique.'
            ],
            [
                'question' => 'Offrez-vous une garantie sur vos produits ?',
                'answer' => 'Tous nos produits sont couverts par une garantie d\'un an contre les défauts de fabrication. Certains composants électroniques peuvent avoir des garanties différentes. Consultez notre politique de garantie pour plus de détails.'
            ],
            [
                'question' => 'Proposez-vous des guides d\'installation ou du support technique ?',
                'answer' => 'Oui, nous fournissons des guides d\'installation détaillés pour tous nos produits. De plus, notre équipe de support technique est disponible par email pour répondre à vos questions et vous aider en cas de problème.'
            ],
        ];

        return view('faq', compact('faqs'));
    }
}