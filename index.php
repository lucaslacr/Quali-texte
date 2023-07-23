<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Quali Texte, analyse de texte pour orienté UX Writing</title>
    <link href="elements/aspect.css" rel="stylesheet">
</head>

<body>
    <section class="banniere">
        <div class="conteneur">
            <header>
                <h1>Quali-Texte</h1>
            </header>
            <p>Tester votre texte, vérifier les rythmes de phrase, les verbes terne, la longueur de vos phrases, la
                longueur de vos paragraphes et l'analyse sémantique de votre texte. Objectif optimise votre texte le
                rendre plus facile à lire et harmonieux.</p>
        </div>
    </section>
    <main>
        <div class="conteneur">


            <div class="conteneur-analyse">
                <form action="/fonctions/traitement.php" method="post">
                    <button type="submit">Analyser le texte</button>
                    <textarea maxlength="2500" minlength="5" id="" aria-label="Entrez le texte à analyser"
                        id="texte-a-analyser" name="texte-a-analyser"></textarea>
                </form>
                <section class="resultat">
                    Les résultats, s'afficherons ici
                </section>
            </div>
        </div>
    </main>
</body>

</html>