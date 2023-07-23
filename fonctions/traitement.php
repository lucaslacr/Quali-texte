<?php 
// Fonction pour compter le nombre de mots par phrase
$sectionMotParPhrases = "Nombre de mots par phrase : <br>";
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
    $sectionMotParPhrases = $sectionMotParPhrases . "Phrase " . ($index + 1) . ": " . $nombreDeMots . " mots <br>" ;
}
$affichage = $sectionMotParPhrases;   
?>