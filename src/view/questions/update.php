<link rel="stylesheet" href="css/formulaire.css">
<link rel="stylesheet" href="css/Questions/questions-formulaire.css">
<form class="formulaire--container" action="frontController.php?controller=questions&action=created" method="post">
    <div class="formulaire-template">
        <h2 class="title">Modification de question</h2>
        <div>
            <label for="autheur">Auteur</label>
            <input type="text" name="autheur" id="autheur" placeholder="JohnDoe10" value="<?php echo htmlspecialchars($question->getIdQuestion()) ?>" required/>
        </div>
        <div>
            <label for="titreQuestion">Titre</label>
            <input type="text" name="titreQuestion" id="titreQuestion" placeholder="TitreDeLaQuestion" value="<?php echo htmlspecialchars($question->getTitreQuestion()) ?>"   required/>
        </div>
        <div>
            <label for="categorieQuestion">Catégorie</label>
            <input type="text" name="categorieQuestion" id="categorieQuestion" placeholder="CategorieDeLaQuestion" value="<?php echo htmlspecialchars($question->getCategorieQuestion()) ?>" readonly required/>
        </div>
        <div class="date--container">
            <div>
                <label id="title-date" for="dtnaissance">Date d'écriture des réponses</label>
                <span id="no-margin-top" class="flex-row"><p>Du </p><input id="date-input" type="date" name="ecritureDateDebut" id="ecritureDateDebut" value="<?php echo htmlspecialchars($question->getDateEcritureDebut()) ?>" required /></span>
                <span class="flex-row"><p>Au </p> <input id="date-input" type="date" name="ecritureDateFin" id="ecritureDateFin" <?php echo htmlspecialchars($question->getDateEcritureFin()) ?> required /></span>
            </div>
            <div>
                <label id="title-date" for="dtnaissance">Date des votes</label>
                <span id="no-margin-top" class="flex-row"><p>Du </p><input id="date-input" type="date" name="voteDateDebut" id="voteDateDebut" value="<?php echo htmlspecialchars($question->getDateVoteDebut()) ?>" required/></span>
                <span class="flex-row"><p>Au </p> <input id="date-input" type="date" name="voteDateFin" id="voteDateFin " value="<?php echo htmlspecialchars($question->getDateVoteFin()) ?>" required /></span>
            </div>
        </div>

        <hr WIDTH="200">

        <div class="section-plan--container">
            <?php
            foreach($sectionIds as $section){
                ?>
                <div class="section-plan">
                    <label class="section-plan-label" for="section<?php echo($section->getIdSection()) ?>">Section n°<?php echo($section->getIdQuestion()); ?></label>
                    <input class="section-plan-input" type="text" name="sectionTitle<?php echo($section->getIdSection()) ?>" value="<?php echo($section->getTitreSection()) ?>">
                    <input class="section-plan-input" type="text" name="sectionDesc<?php echo($section->getIdSection()) ?>" value="<?php echo($section->getDescriptionSection()) ?>">
                </div>

                <?php
            }
            ?>
        </div>



        <div>
            <input type="hidden" name="controller" value="questions">
            <input type="hidden" name="action" value="updated">
            <input type="submit" value="Modifier la question">
        </div>
    </div>


</form>