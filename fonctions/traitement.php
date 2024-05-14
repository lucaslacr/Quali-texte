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
$secondes = ($decimales * 60) + 2;
$tempsLecture = $partie_entiere . "min et " . floor($secondes) . "s";


// Compter le nombre mots par paragraphes
$nombreDeParagraphes = preg_match_all('/^\s*$/m', $texteAnalyser, $matches) + 1;
$nombreMoyenDeMotsParParagraphe = $nombreDeMots / $nombreDeParagraphes;
$nombreMoyenDeMotsParParagraphe  = round($nombreMoyenDeMotsParParagraphe, 2);
if($nombreMoyenDeMotsParParagraphe > 100) {
    $nombreMoyenDeMotsParParagraphe = "<span class='rouge'>" . $nombreMoyenDeMotsParParagraphe . "</span>";
} else {
    $nombreMoyenDeMotsParParagraphe = "<span class='vert'>" . $nombreMoyenDeMotsParParagraphe . "</span>";
}
$sectionGeneral = "<h3>Stats générales</h3>" . "<p>" . $nombreDeCaracteres . " Caractères<br>" . $nombreDeMots . " Mots <br>" . $nombreDeParagraphes . " Paragraphes<br>" . $tempsLecture . " de temps lecture estimé <br><br>Nombre moyen de mots par phrase : " . $nombreMoyenDeMotsParPhrase . "<br> Nombre de mots moyens par paragraphe : " . $nombreMoyenDeMotsParParagraphe . "</p>";


// Teste de Fle

function calculateFleschKincaid($text) {
    $wordCount = str_word_count($text);

    $sentenceCount = preg_match_all('/[.!?]/', $text, $matches);
     
    if ($sentenceCount == 0) {
        $sentenceCount = 1;
    }

    $syllableCount = 0;
    $words = explode(' ', $text);
    foreach ($words as $word) {
        $syllableCount += countSyllables($word);
    }

    $score = 206.835 - (1.015 * ($wordCount / $sentenceCount)) - (84.6 * ($syllableCount / $wordCount));

    return $score;
}

function countSyllables($word) {
    $word = strtolower($word);
    $vowels = ['a', 'e', 'i', 'o', 'u', 'y'];
    $syllableCount = 0;
    $lastCharWasVowel = false;

    for ($i = 0; $i < strlen($word); $i++) {
        $char = $word[$i];
        if (in_array($char, $vowels)) {
            if (!$lastCharWasVowel) {
                $syllableCount++;
                $lastCharWasVowel = true;
            }
        } else {
            $lastCharWasVowel = false;
        }
    }

    return $syllableCount;
}

// Test avec une chaîne de texte

$score = calculateFleschKincaid($texteAnalyser);
if($score <= 50){
    $afficherfk = "<p class='rouge'>" . round($score, 2) . " au test de Flesch-Kincaid<p>" ;

} else {
   $afficherfk = "<p><span class='vert'>" .  round($score, 2) . "</span> au test de Flesch-Kincaid</p>" ;
}


// Fonction verbes ternes
function compterEtReleverMots($texte, $mots_a_relever) {
    $texte_minuscules = strtolower($texte);
    $occurrences = array();

    // Prétraitement du texte en remplaçant les caractères spéciaux par des espaces
    $texte_traité = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $texte_minuscules);

    foreach ($mots_a_relever as $mot) {
        $occurrences[$mot] = 0;
    }
    
    foreach ($mots_a_relever as $mot) {
        $occurrences[$mot] = substr_count($texte_traité, ' ' . strtolower($mot) . ' ');
    }

    return $occurrences;
}

$mots_a_relever = array("faire", "fait", "fais", "vouloir", "voulu", "est", "aller", "dire", "dis", "dit", "mettre", "mis", "met", "fini");

$occurrences_des_mots = compterEtReleverMots($texteAnalyser, $mots_a_relever);

$sectionverbeterne = "";

foreach ($mots_a_relever as $mot) {
    if ($occurrences_des_mots[$mot] < 1) {
        continue;
    } else {
        $sectionverbeterne = $mot . " : (" . $occurrences_des_mots[$mot] . ")<br>" . $sectionverbeterne;
    }
}

if ($sectionverbeterne !== "") {
    $sectionverbeterne = "<h3>Verbes ternes</h3><p class='rouge'>" . $sectionverbeterne . "</p>";
}

// Fonction adverbe ou adjectif
function compterEtReleverAdverbe($texte, $adverbe) {
    $texte_minuscules = strtolower($texte);
    $occurrences = array();

    // Prétraitement du texte en remplaçant les caractères spéciaux par des espaces
    $texte_traité = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $texte_minuscules);

    foreach ($adverbe as $mot) {
        $occurrences[$mot] = 0;
    }
    
    foreach ($adverbe as $mot) {
        $occurrences[$mot] = substr_count($texte_traité, ' ' . strtolower($mot) . ' ');
    }

    return $occurrences;
}

$adverbe = array("certainement", "simplement", "vraiment", "couramment", "également", "autrement", "assurément", "tellement", "idéalement", "seulement", "uniquement", "apparemment", "évidement", "probablement", "clairement", "complètement", "naturellement", "réellement", "tranquillement", "rapidement");

$occurrences_des_adverbes = compterEtReleverAdverbe($texteAnalyser, $adverbe);

$sectionadverbe = "";

foreach ($adverbe as $mot) {
    if ($occurrences_des_adverbes[$mot] < 1) {
        continue;
    } else {
        $sectionadverbe = $mot . " : (" . $occurrences_des_adverbes[$mot] . ")<br>" . $sectionadverbe;
    }
}

if ($sectionadverbe !== "") {
    $sectionadverbe = "<h3>Adverbes</h3><p class='rouge'>" . $sectionadverbe . "</p>";
}


function detecterEnumerations($texteAnalyser) {
    // Initialisation des variables
    $ennumerationrequise = "";

    // Séparation du texte en phrases
    $phrases = preg_split('/[.!?]+/', $texteAnalyser, -1, PREG_SPLIT_NO_EMPTY);

    // Parcourir chaque phrase
    foreach ($phrases as $phrase) {
        // Rechercher des énumérations dans la phrase
        preg_match_all('/([\w\s]+(?:\s*,\s*[\w\s]+){2,})/', $phrase, $enumerations);

        // Si une énumération est trouvée avec plus de 3 éléments
        if (isset($enumerations[0]) && count($enumerations[0]) > 0) {
            // Ajouter la phrase entière à la variable $ennumerationrequise
            $ennumerationrequise .= $phrase . ". <br>";
        }
    }

    // Retourner la variable contenant les phrases avec des énumérations de plus de 3 éléments
    return $ennumerationrequise;
}

// Appel de la fonction pour détecter les énumérations de plus de 3 éléments
$ennumerationrequise = detecterEnumerations($texteAnalyser);

if ($ennumerationrequise != "") {
    $sectionsenumeration = "<h3>Énumération longue sans liste à puces</h3><p class='rouge'>" . $ennumerationrequise  ."</p>";
} else {
    $sectionsenumeration = "";
}
 
//double négation
function detecterDoubleNegations($texteAnalyser) {
    $doublenegation = "";
    $phrases = preg_split('/[.!?]+/', $texteAnalyser, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($phrases as $phrase) {
        preg_match('/\b(?:pas|point|aucun)\s+\b(?:ne|n[\'eaiou])\s+(?:pas|point|aucun)\b/i', $phrase, $negations);
        if (isset($negations[0]) && !empty($negations[0])) {
            $doublenegation .= $phrase . ". <br>";
        }
    }
    return $doublenegation;
}

$doublenegation = detecterDoubleNegations($texteAnalyser);


if ($doublenegation != "") {
    $sectionsnegation = "<h3>Double négation</h3><p class='rouge'>" . $doublenegation  ."</p>";
} else {
    $sectionsnegation = "";
}

// Fonction formulation maladroite
function compterEtReleverFormulation($texte, $mots_maladroits) {
    $texte_minuscules = strtolower($texte);
    $occurrences = array();

    $texte_traité = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $texte_minuscules);

    foreach ($mots_maladroits as $mot) {
        $occurrences[$mot] = 0;
    }
    
    foreach ($mots_maladroits as $mot) {
        $occurrences[$mot] = substr_count($texte_traité, ' ' . strtolower($mot) . ' ');
    }

    return $occurrences;
}

$mots_maladroits = array("mais", "toutefois", "normalement", "toutefois", "malheureusement", "en effet", "honnêtement", "sur paris", "en soi", "de base", "hélas", "du coup", "à la base", "je me permet", "Je pense que", "en gros", "on", "que");

$occurrences_des_formulations = compterEtReleverFormulation($texteAnalyser, $mots_maladroits);

$sectionformulation = "";

foreach ($mots_maladroits as $mot) {
    if ($occurrences_des_formulations[$mot] < 1) {
        continue;
    } else {
        $sectionformulation = $mot . " : (" . $occurrences_des_formulations[$mot] . ")<br>" . $sectionformulation;
    }
}

if ($sectionformulation !== "") {
    $sectionformulation = "<h3>Formulation à éviter</h3><p class='rouge'>" . $sectionformulation . "</p>";
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

$sectionMotParPhrases = "<p>" . $sectionMotParPhrases . "</p>";

    // Mots fréquents

function motsFrequents($texte, $nombre_mots_a_recuperer = 5) {
    $mots_a_exclure = array("ont", "d'un", "d'une", "votre", "vos", "sur", "leur", "nos", "y", "mais", "pourquoi", "devant", "encore", "vers", "leurs", "qu'il", "le", "n'a", "la", "de", "dans", "se", "qu", "en", "re", "sur", "au", "on", "cette", "aux", "ce", "ces", "ses", "sa", "si", "ne", "mon", "ma", "c'est", "à", "son", "que", "l", "où", "c", "m", "t", "s", "là", "sans", "e", "par", "que", "je", "tu", "il", "ils", "elles", "elle", "vous", "es", "tes", "tout", "toutes","toute", "tous", "nous", "qui", "un", "est", "une", "a", "pour", "les", "des", "ou", "aussi", "plus", "comme", "avec", "d", "et", "du", "me", "lui", "entre", "pas", "mes", "sont"); // Ajoutez d'autres mots à exclure ici si nécessaire
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
    $sectionvoix = "";
} else {
    $sectionvoix = "Nombre de phrases passives : " . $sectionpasive['nombre_phrases_passives'] . "<br>" . "Phrases passives : <br>";
    foreach ($sectionpasive['phrases_passives'] as $phrase) {
        $sectionvoix = $sectionvoix . $phrase . "<br>";
    }
    $sectionvoix = "<p class='rouge' >" . $sectionvoix . "</p>";
};

if ($sectionvoix !== "") {
    $sectionvoix = "<h3>Détection voix passive</h3>" . $sectionvoix ;
} else {
    $sectionvoix = "";
}


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

// Détection des abréviation 

preg_match_all('/[A-Z]{2,}/', $texteAnalyser, $matches);

// Récupérer les abréviations trouvées
$listedesabréviation = implode(', ', $matches[0]);

$afficherabreviation ="";
if ($listedesabréviation != "") {
    $afficherabreviation = "<h3>Abréviation </h3><p class='rouge' >" . $listedesabréviation . "</p>";
}

$relance = "<button type='submit'>Analyser de nouveau le texte</button>";

// Ajouter les résultats à afficher
$affichage = $sectionGeneral . $afficherfk . $sectionsemantique . $sectionsnegation . $sectionverbeterne .  $sectionadverbe . $sectionformulation . $sectionsenumeration . $dateabrege . $afficherabreviation . $sectionvoix . $sectionMotParPhrases . $relance . "<br>";   
?>