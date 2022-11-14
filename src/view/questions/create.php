<link rel="stylesheet" href="css/Questions/questions-formulaire.css">
<form class="questions-formulaire--container" action="frontController.php?controller=questions&action=created" method="post">
    <h2>Proposition de question</h2>
    <div>
        <label for="autheur">Auteur</label>
        <input type="text" name="autheur" id="autheur" placeholder="JohnDoe10"/>
    </div>
    <div>
        <label for="titreQuestion">Titre</label>
        <input type="text" name="titreQuestion" id="titreQuestion" placeholder="TitreDeLaQuestion"/>
    </div>
    <div>
        <label for="nbSection">Nombre de section</label>
        <input type="number" name="nbSection" id="nbSection" placeholder="2" min="3" max="8"/>
    </div>
    <div>
        <label for="categorieQuestion">Catégorie</label>
        <select name="categorieQuestion" id="categorieQuestion">
            <?php
            foreach ($categories as $categorie){
                ?><option value="<?php echo($categorie->getNomCategorie()) ?>"><?php echo($categorie->getNomCategorie()) ?></option><?php
            }
            ?>
        </select>
    </div>
    <div class="date--container">
        <div>
            <label id="title-date" for="ecritureDateDebut">Date d'écriture des réponses</label>
            <span id="no-margin-top" class="flex-row"><p>Du </p><input id="date-input" type="date" name="ecritureDateDebut" id="ecritureDateDebut" placeholder="01-01-2001"/></span>
            <span class="flex-row"><p>Au </p> <input id="date-input" type="date" name="ecritureDateFin" id="ecritureDateFin" placeholder="01-01-2001"/></span>
        </div>
        <div>
            <label id="title-date" for="voteDateDebut">Date des votes</label>
            <span id="no-margin-top" class="flex-row"><p>Du </p><input id="date-input" type="date" name="voteDateDebut" id="voteDateDebut" placeholder="01-01-2001"/></span>
            <span class="flex-row"><p>Au </p> <input id="date-input" type="date" name="voteDateFin" id="voteDateFin " placeholder="01-01-2001"/></span>
        </div>
    </div>
    <input type="hidden" name="controller" value="questions">
    <input type="hidden" name="action" value="created">
    <input type="submit" value="Poser la question">
</form>