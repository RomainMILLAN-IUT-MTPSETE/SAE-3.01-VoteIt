<link rel="stylesheet" href="css/Questions/questions-formulaire.css">
<form class="questions-formulaire--container" action="frontController.php?controller=questions&action=created" method="post">
    <h2>Modification de question</h2>
    <div>
        <label for="autheur">Auteur</label>
        <input type="text" name="autheur" id="autheur" placeholder="JohnDoe10" value="<?php echo htmlspecialchars($q->getIdQuestion()) ?>"/>
    </div>
    <div>
        <label for="titreQuestion">Titre</label>
        <input type="text" name="titreQuestion" id="titreQuestion" placeholder="TitreDeLaQuestion" value="<?php echo htmlspecialchars($q->getTitreQuestion()) ?>"  />
    </div>
    <!--<div>
        <label for="prenom">Plan</label>
        <input type="text" name="planQuestion" id="planQuestion" placeholder="PlanDeLaQuestion" value="<?php //echo htmlspecialchars($q->getPlanQuestion()) ?>"/>
    </div>-->
    <div>
        <label for="categorieQuestion">Catégorie</label>
        <input type="text" name="categorieQuestion" id="categorieQuestion" placeholder="CategorieDeLaQuestion" value="<?php echo htmlspecialchars($q->getCategorieQuestion()) ?>" readonly/>
    </div>
    <div class="date--container">
        <div>
            <label id="title-date" for="dtnaissance">Date d'écriture des réponses</label>
            <span id="no-margin-top" class="flex-row"><p>Du </p><input id="date-input" type="date" name="ecritureDateDebut" id="ecritureDateDebut" placeholder="01-01-2001"/></span>
            <span class="flex-row"><p>Au </p> <input id="date-input" type="date" name="ecritureDateFin" id="ecritureDateFin" placeholder="01-01-2001"/></span>
        </div>
        <div>
            <label id="title-date" for="dtnaissance">Date des votes</label>
            <span id="no-margin-top" class="flex-row"><p>Du </p><input id="date-input" type="date" name="voteDateDebut" id="voteDateDebut" placeholder="01-01-2001"/></span>
            <span class="flex-row"><p>Au </p> <input id="date-input" type="date" name="voteDateFin" id="voteDateFin " placeholder="01-01-2001"/></span>
        </div>
    </div>
    <input type="hidden" name="controller" value="questions">
    <input type="hidden" name="action" value="updated">
    <input type="submit" value="Modifier la question">
</form>