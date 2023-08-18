<?php
if (isset($_POST['texte-a-analyser'])) {
    $affichage = "Les résultats";
    $texteAnalyser = $_POST['texte-a-analyser'];
    include 'fonctions/traitement.php';
} else {
    $affichage = " Les résultats, s'afficherons ici";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Quali Texte, analyse de texte pour orienté UX Writing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="elements/aspect.css" rel="stylesheet">
</head>

<body>
    <section class="banniere">
        <div class="conteneur">
            <header>
                <h1>Quali-Texte</h1>
            </header>
            <p>Tester votre texte, vérifier les rythmes de phrase, les verbes ternes, la longueur de vos phrases,
             la longueur de vos paragraphes et l'analyse sémantique de votre texte. Objectif optimise votre texte, 
             le rendre plus facile à lire et harmonieux.
            </p>
        </div>
    </section>
    <main>
        <div class="conteneur">
            <div class="conteneur-analyse">
                <form action="#" method="post">
                    <button type="submit">Analyser le texte</button>
                    <textarea maxlength="5000" minlength="5" rows="24" aria-label="Entrez le texte à analyser" id="texte-a-analyser" name="texte-a-analyser"><?php
                                                                                                                                                                if (isset($_POST['texte-a-analyser'])) {
                                                                                                                                                                    echo $texteAnalyser;
                                                                                                                                                                } else {
                                                                                                                                                                    echo "Entrez ici le texte à analyser";
                                                                                                                                            }
                                                                                                                                                                ?></textarea>
                </form>
                <section class="resultat">
                    <?php echo $affichage ?>
                </section>
            </div>
        </div>
    </main>
</body>

</html>