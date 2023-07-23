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

// vitesse de lecture 
$tempsLecture = $nombreDeMots / 300;
$minutes_decimal = $tempsLecture;

// Séparer la partie entière des décimales
$partie_entiere = floor($minutes_decimal);
$decimales = $minutes_decimal - $partie_entiere;

// Convertir les décimales en secondes
$secondes = $decimales * 60;

// Afficher le résultat
$tempsLecture = $partie_entiere . "min et " . floor($secondes) . "s";


// Compter le nombre de paragraphes
$nombreDeParagraphes = preg_match_all('/^\s*$/m', $texteAnalyser, $matches) + 1;
$nombreMoyenDeMotsParParagraphe = $nombreDeMots / $nombreDeParagraphes;
$nombreMoyenDeMotsParParagraphe  = round($nombreMoyenDeMotsParParagraphe, 2);
if($nombreMoyenDeMotsParParagraphe > 135) {
    $nombreMoyenDeMotsParParagraphe = "<span class='rouge'>" . $nombreMoyenDeMotsParParagraphe . "</span>";
} else {
}

// Afficher les résultats
$sectionGeneral = "<h3>Stat général</h3>" . "<p> Nombre de caractères : " . $nombreDeCaracteres . "<br> Nombre de mots : " . $nombreDeMots . "<br>Temps de lecture estimé : " . $tempsLecture . "<br> Nombre moyen de mots par phrase : " . $nombreMoyenDeMotsParPhrase . "<br> Nombre de paragraphes : " . $nombreDeParagraphes . "<br> Nombre de mots moyens par paragraphe : " . $nombreMoyenDeMotsParParagraphe . "</p>";


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
$mots_a_relever = array("faire", "fait", "fais", "vouloir",  "voulu", "est", "aller", "dire", "dis ", "dit ", "mettre", "mis", "met", "fini");

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

function motsFrequents($texte, $nombre_mots_a_recuperer = 5) {
    // Liste des mots à exclure
    $mots_a_exclure = array("ont", "leur", "nos", "mais", "devant", "encore", "vers", "leurs", "qu'il", "le", "n'a", "la", "de", "dans", "se", "qu", "en", "re", "sur", "au", "on", "cette", "aux", "ce", "ces", "ses", "sa", "si", "ne", "mon", "ma", "c'est", "à", "son", "que", "l", "où", "c", "m", "t", "s", "là", "sans", "e", "par", "que", "je", "tu", "il", "ils", "elles", "elle", "vous", "es", "tes", "tout", "toutes","toute", "tous", "nous", "qui", "un", "est", "une", "a", "pour", "les", "des", "ou", "aussi", "plus", "comme", "avec", "d", "et", "du", "me", "lui", "entre", "pas", "mes", "sont"); // Ajoutez d'autres mots à exclure ici si nécessaire

    // Convertir le texte en minuscules pour une recherche insensible à la casse
    $texte_minuscules = strtolower($texte);

    // Supprimer les caractères spéciaux et découper le texte en mots
    $pattern = '/[^\p{L}\p{N}\']+|\'(?!\w)|(?<!\w)\'/u';
    $mots = preg_split($pattern, $texte_minuscules, -1, PREG_SPLIT_NO_EMPTY);

    // Exclure les mots spécifiés de la liste des mots
    $mots_sans_exclusion = array_diff($mots, $mots_a_exclure);

    // Compter la fréquence d'apparition de chaque mot
    $frequences = array_count_values($mots_sans_exclusion);

    // Trier les mots par ordre décroissant de leur fréquence
    arsort($frequences);

    // Récupérer les mots les plus fréquents
    $mots_frequents = array_slice($frequences, 0, $nombre_mots_a_recuperer, true);

    return $mots_frequents;
}

// Appeler la fonction pour récupérer les mots fréquemment utilisés
$nombre_mots_a_recuperer = 6; // Vous pouvez ajuster ce nombre selon vos besoins
$mots_frequents = motsFrequents($texteAnalyser, $nombre_mots_a_recuperer);

// Afficher les résultats
$sectionsemantique = "";
foreach ($mots_frequents as $mot => $frequence) {
    $sectionsemantique = $sectionsemantique . $mot . " : (" . $frequence . ") <br>";
}

$sectionsemantique = "<h3>Analyse sémantique</h3><p>" . $sectionsemantique ."</p>";






$affichage = $sectionGeneral . $sectionsemantique . $sectionverbeterne . $sectionMotParPhrases;   
?>