<?php

namespace App\Controllers;

abstract class Controller
{
    public function render(string $file, array $data = [], string $template = 'default')
    {
        // On extrait le contenu de $data 
        extract($data);

        //On démarre le buffer de sortie
        ob_start();
        // A partir de ce point toute sortie est conservée en mémoire

        // On crée le chemin vers la vue
        require(ROOT . '/Views/' . $file . '.php');

        // Transfère le buffer dans $content
        $content = ob_get_clean();

        //Template de page
        require(ROOT . '/Views/' . $template . '.php');
    }
}
