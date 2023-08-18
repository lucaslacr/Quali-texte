<?php 
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
    $nombreMoyenDeMotsParPhrase = "<span class='vert'>" . $nombreMoyenDeMotsParPhrase . "</span>";
}

// vitesse de lecture 
$tempsLecture = $nombreDeMots / 300;
$minutes_decimal = $tempsLecture;
$partie_entiere = floor($minutes_decimal);
$decimales = $minutes_decimal - $partie_entiere;
$secondes = $decimales * 60;
$tempsLecture = $partie_entiere . "min et " . floor($secondes) . "s";


// Compter le nombre mots par paragraphes
$nombreDeParagraphes = preg_match_all('/^\s*$/m', $texteAnalyser, $matches) + 1;
$nombreMoyenDeMotsParParagraphe = $nombreDeMots / $nombreDeParagraphes;
$nombreMoyenDeMotsParParagraphe  = round($nombreMoyenDeMotsParParagraphe, 2);
if($nombreMoyenDeMotsParParagraphe > 110) {
    $nombreMoyenDeMotsParParagraphe = "<span class='rouge'>" . $nombreMoyenDeMotsParParagraphe . "</span>";
} else {
    $nombreMoyenDeMotsParParagraphe = "<span class='vert'>" . $nombreMoyenDeMotsParParagraphe . "</span>";
}
$sectionGeneral = "<h3>Stats générales</h3>" . "<p> Nombre de caractères : " . $nombreDeCaracteres . "<br> Nombre de mots : " . $nombreDeMots . "<br>Temps de lecture estimé : " . $tempsLecture . "<br> Nombre moyen de mots par phrase : " . $nombreMoyenDeMotsParPhrase . "<br> Nombre de paragraphes : " . $nombreDeParagraphes . "<br> Nombre de mots moyens par paragraphe : " . $nombreMoyenDeMotsParParagraphe . "</p>";


// Fonction verbes ternes
$sectionverbeterne = "";
function compterEtReleverMots($texte, $mots_a_relever) {
    $texte_minuscules = strtolower($texte);
    $occurrences = array();
    foreach ($mots_a_relever as $mot) {
        $occurrences[$mot] = 0;
    }
    foreach ($mots_a_relever as $mot) {
        $occurrences[$mot] = substr_count($texte_minuscules, strtolower($mot));
    }
    return $occurrences;
}

$mots_a_relever = array("faire", "fait", "fais", "vouloir",  "voulu", "est", "aller", "dire", "dis ", "dit ", "mettre", "mis", "met", "fini");

$occurrences_des_mots = compterEtReleverMots($texteAnalyser, $mots_a_relever);

foreach ($mots_a_relever as $mot) {
    if ($occurrences_des_mots[$mot] < 1){

    } else {
        $sectionverbeterne = $sectionverbeterne . "Occurrences du mot '" . $mot . "' : " . $occurrences_des_mots[$mot] . "<br>";
    }
}

if($sectionverbeterne != "") {
    $sectionverbeterne = "<h3>Verbes ternes</h3><p>" . $sectionverbeterne . "</p>";
}

// Fonction mots par phrases
$sectionMotParPhrases = "<h3>Nombre de mots par phrase </h3>";
function compterMotsParPhrase($texte) {
    $phrases = preg_split('/(?<=[.?!])\s+/', $texte, -1, PREG_SPLIT_NO_EMPTY);
 
    $resultat = array();
    foreach ($phrases as $phrase) {
        $mots = str_word_count($phrase);
        $resultat[] = $mots;
    }
    return $resultat;
}

$nombreDeMotsParPhrase = compterMotsParPhrase($texteAnalyser);

foreach ($nombreDeMotsParPhrase as $index => $nombreDeMots) {
    if($nombreDeMots > 20) {
        $sectionMotParPhrases = $sectionMotParPhrases . "<span class='rouge'>Phrase " . ($index + 1) . ": " . $nombreDeMots . " mots </span><br>" ;
    } else {
     $sectionMotParPhrases = $sectionMotParPhrases . "Phrase " . ($index + 1) . ": " . $nombreDeMots . " mots <br>" ;
    }
   
}
    // Mots fréquents

function motsFrequents($texte, $nombre_mots_a_recuperer = 5) {
    $mots_a_exclure = array("ont", "votre", "vos", "sur", "leur", "nos", "y", "mais", "pourquoi", "devant", "encore", "vers", "leurs", "qu'il", "le", "n'a", "la", "de", "dans", "se", "qu", "en", "re", "sur", "au", "on", "cette", "aux", "ce", "ces", "ses", "sa", "si", "ne", "mon", "ma", "c'est", "à", "son", "que", "l", "où", "c", "m", "t", "s", "là", "sans", "e", "par", "que", "je", "tu", "il", "ils", "elles", "elle", "vous", "es", "tes", "tout", "toutes","toute", "tous", "nous", "qui", "un", "est", "une", "a", "pour", "les", "des", "ou", "aussi", "plus", "comme", "avec", "d", "et", "du", "me", "lui", "entre", "pas", "mes", "sont"); // Ajoutez d'autres mots à exclure ici si nécessaire
    $texte_minuscules = strtolower($texte);
    $pattern = '/[^\p{L}\p{N}\']+|\'(?!\w)|(?<!\w)\'/u';
    $mots = preg_split($pattern, $texte_minuscules, -1, PREG_SPLIT_NO_EMPTY);
    $mots_sans_exclusion = array_diff($mots, $mots_a_exclure);
    $frequences = array_count_values($mots_sans_exclusion);
    arsort($frequences);
    $mots_frequents = array_slice($frequences, 0, $nombre_mots_a_recuperer, true);
    return $mots_frequents;
}

$nombre_mots_a_recuperer = 8;
$mots_frequents = motsFrequents($texteAnalyser, $nombre_mots_a_recuperer);

$sectionsemantique = "";
foreach ($mots_frequents as $mot => $frequence) {
    if ($frequence > 1){
        $sectionsemantique = $sectionsemantique . $mot . " : (" . $frequence . ") <br>";
    }
}
 if($sectionsemantique != "") {
    $sectionsemantique = "<h3>Analyse sémantique</h3><p>" . $sectionsemantique ."</p>";
 }

// Fonction pour compter et nommer les phrases passives
function compterEtNommerPhrasesPassives($texte) {
    $patterns = array(
        '/(\b\w+\s+\b(?:a été|a éte|avait été|a été|sont été|sera|seront)\b.*?\b\w+\b)/i', // Formes du verbe être + participe passé
    );

    $phrases_passives = array();

    $phrases = preg_split('/(?<=[.?!])\s+/', $texte, -1, PREG_SPLIT_NO_EMPTY);

    foreach ($phrases as $phrase) {
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $phrase)) {
                $phrases_passives[] = $phrase;
                break;
            }
        }
    }

    $nombre_phrases_passives = count($phrases_passives);

    return array(
        'nombre_phrases_passives' => $nombre_phrases_passives,
        'phrases_passives' => $phrases_passives
    );
}

$sectionpasive = compterEtNommerPhrasesPassives($texteAnalyser);
$sectionvoix = "";


if ($sectionpasive['nombre_phrases_passives'] < 1) {
    $sectionvoix = "<p class='vert' >Il ne semble pas y avoir de phrases à la voix passive</p>";
} else {
    $sectionvoix = "Nombre de phrases passives : " . $sectionpasive['nombre_phrases_passives'] . "<br>" . "Phrases passives : <br>";
    foreach ($sectionpasive['phrases_passives'] as $phrase) {
        $sectionvoix = $sectionvoix . $phrase . "<br>";
    }
    $sectionvoix = "<p class='rouge' >" . $sectionvoix . "</p>";
};
$sectionvoix = "<h3>Détection voix passive</h3>" . $sectionvoix ;


// Détection des dates abrégées
$schema = "/\b(?:\d{1,2}\/\d{1,2}(?:\/\d{2,4})?)\b/";
$tableaudate = [];
$affichedate = "";
$dateabrege = "";

if (preg_match_all($schema, $texteAnalyser, $matches)) {
    $tableaudate = $matches[0];
}

foreach ($tableaudate as $date) {
    $affichedate =  $date . "<br>" . $affichedate;
};

if ($affichedate != "") {
    $dateabrege = "<h3>Dates abrégés </h3><p class='rouge' >" . $affichedate . "</p>";
}

// Ajouter les résultats à afficher
$affichage = $sectionGeneral . $sectionsemantique . $sectionverbeterne . $dateabrege . $sectionvoix . $sectionMotParPhrases;   
?>