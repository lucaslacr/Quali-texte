<?php
if (isset($_POST['texte-a-analyser'])) {
    $affichage = "Les résultats";
    $texteAnalyser = $_POST['texte-a-analyser'];
    include 'fonctions/traitement.php';
} else {
    $affichage = "<img src='./elements/document.svg' alt='' class='loupe'/><button type='submit'>Analyser le texte</button>";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Quali Texte, analyse de texte pour orienté UX Writing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="elements/aspect.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="./elements/favicon.png" />
    <!-- Matomo -->
    <script>
        var _paq = window._paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u = "//audience.lucaslacroix.com/";
            _paq.push(['setTrackerUrl', u + 'matomo.php']);
            _paq.push(['setSiteId', '8']);
            var d = document,
                g = d.createElement('script'),
                s = d.getElementsByTagName('script')[0];
            g.async = true;
            g.src = u + 'matomo.js';
            s.parentNode.insertBefore(g, s);
        })();
    </script>
    <!-- End Matomo Code -->
</head>

<body>
    <section class="banniere">
        <div class="conteneur">
            <header>
                <h1>Quali-Texte</h1>
            </header>
            <p>Analyser votre texte, vérifier les rythmes de phrase, les verbes ternes, la longueur de vos phrases,
                la taille de vos paragraphes et l'analyse sémantique de vos paragraphes. Objectif : optimiser votre contenu,
                le rendre plus facile à lire et harmonieux.
            </p>
        </div>
    </section>
    <main>
        <section class="conteneur">
            <section class="bloc-analyse">
                <form action="#" method="post">
                    <section class="bloc-texte">
                        <textarea maxlength="5000" minlength="5" rows="18" aria-label="Entrez le texte à analyser" id="texte-a-analyser" name="texte-a-analyser"><?php
                                                                                                                                                                    if (isset($texteAnalyser)) {
                                                                                                                                                                        echo $texteAnalyser;
                                                                                                                                                                    } else {
                                                                                                                                                                        echo "Saisissez le texte à analyser";
                                                                                                                                                                    }
                                                                                                                                                                    ?></textarea>
                    </section>
                    <section class="resultat">
                        <?php echo $affichage ?>
                    </section>
                </form>
            </section>
            <p class="codesource">Outil ouvert aux contributions <a href="https://github.com/lucaslacr/Quali-texte" rel="nofollow" target="_blank">Voir le code du projet</a></p>
        </section>
    </main>
</body>

</html>