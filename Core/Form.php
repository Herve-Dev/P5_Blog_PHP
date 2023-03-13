<?php
namespace App\Core;

class Form
{
    private $formCode = '';

    /**
     * Génère le formulaire HTML
     *
     * @return string
     */
    public function create()
    {
        return $this->formCode;
    }


    /**
     * Valide si tous les champs proposé sont remplis
     *
     * @param array $form Tableau issu du formulaire ($_POST, $_GET)
     * @param array $fields Tableau listant les champs obligatoires
     * @return bool
     */
    public static function validate(array $form, array $fields)
    {
       
        // On parcourt les champs 
        foreach ($fields as $field) {
            // Si le champ est absent ou vide dans le formulaire 
            if (!isset($form[$field]) || empty($form[$field])) {
                // On sort en retournant false 
                return false;
            }
        }
        return true;
    }

    /**
     * Ajoute les attributs envoyés à la balise
     *
     * @param array $attributs Tableau associatif
     * @return string Chaine de caractère généré
     */
    private function addAttributs(array $attributs): string
    {
        // On va initialise une chaîne de caractères
        $str = '';

        // On liste les attributs "courts"
        $shortAttributs = ['checked', 'disabled', 'readonly', 'multiple',
        'required', 'autofocus', 'novalidate', 'formnovalidate'];

        //On boucle sur le tableau d'attributs
        foreach($attributs as $attribut => $value){
            //Si l'attribut est dans la liste des attributs courts
            if (in_array($attribut, $shortAttributs) && $value == true) {
                $str .=" $attribut";
            }else {
                // On ajoute attribut='valeur'
                $str .=" $attribut='$value'";
            }
        }

        return $str;
    }

    /**
     * Balise d'ouverture du formulaire
     *
     * @param string $method Méthode du formulaire (post ou get)
     * @param string $action Action du formulaire 
     * @param array $attributs Attributs
     * @return Form
     */
    public function startForm(string $method = 'post', string $action = '#', array $attributs = []): self
    {
        //On crée la balise form
        $this->formCode .= "<form action='$action' method='$method'";

        //On ajoute les attributs éventuels
        $this->formCode .= $attributs  ? $this->addAttributs($attributs).'>': '>';
        
        return $this;
    }

    /**
     *Balise de fermeture du formulaire
     * @return Form
     */
    public function endForm(): self
    {
        $this->formCode .= '</form>';
        return $this;
    }

    /**
     * Ajout d'un label
     *
     * @param string $for
     * @param string $text
     * @param array $attributs
     * @return Form
     */
    public function addLabelForm(string $for, string $text, array $attributs = []): self
    {
        //On ouvre la balise
        $this->formCode .= "<label for='$for'";

        // On ajoute les attributs
        $this->formCode .= $attributs ? $this->addAttributs($attributs) : '';

        // On ajoute le texte
        $this->formCode .= ">$text</label>";

        return $this;
    }

    /**
     * Ajout d'un input
     *
     * @param string $type
     * @param string $name
     * @param array $attributs
     * @return Form
     */
    public function addInput(string $type, string $name, array $attributs = []): self
    {
        // On ouvre la balise
        $this->formCode .="<input type='$type' name='$name'";

        // On ajoute les attributs
        $this->formCode .= $attributs ? $this->addAttributs($attributs). '>' : '>';

        return $this;
    }

    /**
     * Ajout d'un textarea
     *
     * @param string $name
     * @param string $value
     * @param array $attributs
     * @return Form
     */
    public function addTextarea(string $name, string $value = '', array $attributs = []): self
    {
        //On ouvre la balise
        $this->formCode .= "<textarea name='$name'";

        // On ajoute les attributs
        $this->formCode .= $attributs ? $this->addAttributs($attributs) : '';

        // On ajoute le texte
        $this->formCode .= ">$value</label>";

        return $this;
    }

    /**
     * Ajout d'un select
     *
     * @param string $name
     * @param array $options
     * @param array $attributs
     * @return Form
     */
    public function addSelect(string $name, array $options, array $attributs = []): self
    {
        // On crée le select
        $this->formCode .= "<select name='$name'";

        // On ajoute les attributs
        $this->formCode .= $attributs ? $this->addAttributs($attributs).'>' : '>';

        // On ajoute les options
        foreach ($options as $value => $text) {
            $this->formCode .= "<option value='$value'>$text</optio>";
        }

        // On ferme le select
        $this->formCode .= '</select>';

        return $this;
    }

    /**
     * Ajout d'un Boutton
     *
     * @param string $text
     * @param array $attributs
     * @return self
     */
    public function addButton(string $text, array $attributs = []): self
    {
        // On ouvre le boutton
        $this->formCode .= '<button ';

        // On ajoute les attributs
        $this->formCode .= $attributs ? $this->addAttributs($attributs) : '';

        // On ajoute le texte et on ferme
        $this->formCode .= ">$text</button>";

        return $this;
    }

    /**
     * Ajout input file (css)
     *
     * @return self
     */
    public function addInputFiles()
    {
        $this->formCode .=
        '<div class="file-field input-field">
            <div class="btn">
                <span>Image</span>
                <input type="file" id="image" name="image">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" name="image">
            </div>
        </div>';

      return $this;
    }
}