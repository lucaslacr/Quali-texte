<?php 
// Fonction pour compter le nombre de mots par phrase

// Compter le nombre de caractères
$nombreDeCaracteres = strlen($texteAnalyser);

// Compter le nombre de mots
$nombreDeMots = str_word_count($texteAnalyser);

// Compter le nombre de phrases
$nombreDePhrases = preg_match_all('/[^\s](.*?[.!?])\s|[^\s](.*?$)/', $texteAnalyser, $matches);

// Calculer le nombre moyen de mots par phrase
$nombreMoyenDeMotsParPhrase = $nombreDeMots / $nombreDePhrases;
$nombreMoyenDeMotsParPhrase = round($nombreMoyenDeMotsParPhrase, 2);
if($nombreMoyenDeMotsParPhrase > 20) {
    $nombreMoyenDeMotsParPhrase = "<span class='rouge'>" . $nombreMoyenDeMotsParPhrase . "</span>";
} else {

}

// Compter le nombre de paragraphes
$nombreDeParagraphes = preg_match_all('/^\s*$/m', $texteAnalyser, $matches) + 1;
$nombreMoyenDeMotsParParagraphe = $nombreDeMots / $nombreDeParagraphes;
$nombreMoyenDeMotsParParagraphe  = round($nombreMoyenDeMotsParParagraphe, 2);
if($nombreMoyenDeMotsParParagraphe > 150) {
    $nombreMoyenDeMotsParParagraphe = "<span class='rouge'>" . $nombreMoyenDeMotsParParagraphe . "</span>";
} else {
   echo "non";
}

// Afficher les résultats
$sectionGeneral = "<h3>Stat général</h3>" . "<p> Nombre de caractères : " . $nombreDeCaracteres . "<br> Nombre de mots : " . $nombreDeMots . "<br> Nombre moyen de mots par phrase : " . $nombreMoyenDeMotsParPhrase . "<br> Nombre de paragraphes : " . $nombreDeParagraphes . "<br> Nombre de mots moyens par paragraphe : " . $nombreMoyenDeMotsParParagraphe . "</p>";




// Fonction pour compter et relever les occurrences des mots spécifiés 
$sectionverbeterne = "<h3>Verbe terne</h3>";
function compterEtReleverMots($texte, $mots_a_relever) {
    // Convertir le texte en minuscules pour une recherche insensible à la casse
    $texte_minuscules = strtolower($texte);

    // Initialiser un tableau pour compter les occurrences
    $occurrences = array();
    foreach ($mots_a_relever as $mot) {
        $occurrences[$mot] = 0;
    }

    // Parcourir le texte et compter les occurrences des mots spécifiés
    foreach ($mots_a_relever as $mot) {
        $occurrences[$mot] = substr_count($texte_minuscules, strtolower($mot));
    }

    // Retourner le tableau d'occurrences
    return $occurrences;
}

// Mots à relever
$mots_a_relever = array("faire", "fait", "fais", "vouloir",  "voulu", "est", "aller", "dire", "dis", "dit", "mettre", "mis", "met", "fini");

// Appeler la fonction pour compter et relever les mots spécifiés
$occurrences_des_mots = compterEtReleverMots($texteAnalyser, $mots_a_relever);

foreach ($mots_a_relever as $mot) {
    if ($occurrences_des_mots[$mot] < 1){

    } else {
        $sectionverbeterne = $sectionverbeterne . "Occurrences du mot '" . $mot . "' : " . $occurrences_des_mots[$mot] . "<br>";
    }
}
$sectionverbeterne = "<p>" . $sectionverbeterne . "</p>";



$sectionMotParPhrases = "<h3>Nombre de mots par phrase </h3>";
function compterMotsParPhrase($texte) {
    // Supprimer les caractères spéciaux et découper le texte en phrases
    $phrases = preg_split('/(?<=[.?!])\s+/', $texte, -1, PREG_SPLIT_NO_EMPTY);
 
    $resultat = array();
    foreach ($phrases as $phrase) {
        // Compter les mots dans chaque phrase
        $mots = str_word_count($phrase);

        // Ajouter le nombre de mots à l'array résultat
        $resultat[] = $mots;
    }

    return $resultat;
}

// Appeler la fonction et afficher les résultats
$nombreDeMotsParPhrase = compterMotsParPhrase($texteAnalyser);

// Affichage des résultats
foreach ($nombreDeMotsParPhrase as $index => $nombreDeMots) {
    if($nombreDeMots > 20) {
        $sectionMotParPhrases = $sectionMotParPhrases . "<span class='rouge'>Phrase " . ($index + 1) . ": " . $nombreDeMots . " mots </span><br>" ;
    } else {
     $sectionMotParPhrases = $sectionMotParPhrases . "Phrase " . ($index + 1) . ": " . $nombreDeMots . " mots <br>" ;
    }
   
}
$affichage = $sectionGeneral . $sectionverbeterne . $sectionMotParPhrases;   
?>