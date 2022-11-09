<link rel="stylesheet" href="css/Questions/questions-formulaire.css">
<form class="questions-formulaire--container" action="frontController.php?controller=questions&action=created" method="post">
    <h2>Crée une question</h2>

    <div>
        <label for="identifiant">Autheur</label>
        <input type="text" name="autheur" id="autheur" placeholder="JohnDoe10"/>
    </div>
    <div>
        <label for="mail">Titre</label>
        <input type="text" name="titreQuestion" id="titreQuestion" placeholder="TitreDeLaQuestion"/>
    </div>
    <div>
        <label for="password">Description</label>
        <input type="text" name="texteQuestion" id="texteQuestion" placeholder="TexteDeLaQuestion"/>
    </div>
    <div>
        <label for="prenom">Plan</label>
        <input type="text" name="planQuestion" id="planQuestion" placeholder="PlanDeLaQuestion"/>
    </div>
    <div>
        <label for="nom">Catégorie</label>
        <input type="text" name="categorieQuestion" id="categorieQuestion" placeholder="CategorieDeLaQuestion"/>
    </div>
    <div class="date--container">
        <div>
            <label id="title-date" for="dtnaissance">Date écriture réponses</label>
            <span id="no-margin-top" class="flex-row"><p>Du </p><input id="date-input" type="date" name="ecritureDateDebut" id="ecritureDateDebut" placeholder="01-01-2001"/></span>
            <span class="flex-row"><p>au </p> <input id="date-input" type="date" name="ecritureDateFin" id="ecritureDateFin" placeholder="01-01-2001"/></span>
        </div>
        <div>
            <label id="title-date" for="dtnaissance">Date votes</label>
            <span id="no-margin-top" class="flex-row"><p>Du </p><input id="date-input" type="date" name="voteDateDebut" id="voteDateDebut" placeholder="01-01-2001"/></span>
            <span class="flex-row"><p>au </p> <input id="date-input" type="date" name="voteDateFin" id="voteDateFin " placeholder="01-01-2001"/></span>
        </div>
    </div>


    <input type="hidden" name="controller" value="questions">
    <input type="hidden" name="action" value="created">
    <input type="submit" value="Poser la question">

</form>