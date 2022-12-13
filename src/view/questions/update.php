<link rel="stylesheet" href="css/formulaire.css">
<link rel="stylesheet" href="css/Questions/questions-formulaire.css">
<form class="formulaire--container" action="frontController.php?controller=questions&action=updated" method="post">
    <div class="formulaire-template">
        <h2 class="title">Modification de question</h2>
        <div>
            <label for="titreQuestion">Titre</label>
            <input type="text" name="titreQuestion" id="titreQuestion" placeholder="TitreDeLaQuestion" value="<?php echo htmlspecialchars($question->getTitreQuestion()) ?>"   required/>
        </div>
        <div>
            <label for="categorieQuestion">Catégorie</label>
            <select name="categorieQuestion" id="categorieQuestion" required>
                <option value="<?php echo($question->getCategorieQuestion()) ?>" selected>Actuel - <?php echo(htmlspecialchars($question->getCategorieQuestion())) ?></option>
                <?php
                $categories = (new \App\VoteIt\Model\Repository\CategorieRepository())->selectAll();
                foreach ($categories as $categorie){
                    ?><option value="<?php echo(htmlspecialchars($categorie->getNomCategorie())) ?>"><?php echo(htmlspecialchars($categorie->getNomCategorie())) ?></option><?php
                }
                ?>
            </select>
        </div>
        <div>
            <label for="responsableReponse">Responsable de réponse</label>
            <input type="text" name="respReponse" id="respReponse" placeholder="johndoe10@gmail.com, xxx@xxx.fr" value="<?php echo(htmlspecialchars($responsable)) ?>">
        </div>
        <div>
            <label for="votant">Utilisateur votant</label>
            <input type="text" name="userVotant" id="userVotant" placeholder="johndoe10@gmail.com, xxx@xxx.fr" value="<?php echo(htmlspecialchars($userVotant)) ?>">
        </div>
        <div class="date--container">
            <div>
                <label id="title-date" for="dtnaissance">Date d'écriture des réponses</label>
                <span id="no-margin-top" class="flex-row"><p>Du </p><input id="date-input" type="date" name="ecritureDateDebut" id="ecritureDateDebut" value="<?php echo htmlspecialchars($question->getDateEcritureDebut()) ?>" required /></span>
                <span class="flex-row"><p>Au </p> <input id="date-input" type="date" name="ecritureDateFin" id="ecritureDateFin" value="<?php echo htmlspecialchars($question->getDateEcritureFin()) ?>" required /></span>
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
                    <label class="section-plan-label" for="section<?php echo(htmlspecialchars($section->getIdSection())) ?>">Section n°<?php echo(htmlspecialchars($section->getIdQuestion())); ?></label>
                    <input class="section-plan-input" type="text" name="sectionTitle<?php echo(htmlspecialchars($section->getIdSection())) ?>" value="<?php echo(htmlspecialchars($section->getTitreSection())) ?>" <?php if($sectionPeutEtreModifier == false){ ?>readonly<?php } ?>>
                    <input class="section-plan-input" type="text" name="sectionDesc<?php echo(htmlspecialchars($section->getIdSection())) ?>" value="<?php echo(htmlspecialchars($section->getDescriptionSection())) ?>" <?php if($sectionPeutEtreModifier == false){ ?>readonly<?php } ?>>
                </div>

                <?php
            }
            ?>
        </div>



        <div>
            <input type="hidden" name="idQuestion" value="<?php echo(htmlspecialchars($_GET['idQuestion'])); ?>">
            <input type="hidden" name="controller" value="questions">
            <input type="hidden" name="action" value="updated">
            <input type="text" name="autheur" id="autheur" placeholder="JohnDoe10" value="<?php echo (htmlspecialchars($question->getAutheur()))  ?>" readonly hidden required/>
            <input type="submit" value="Modifier la question">
        </div>
    </div>


</form>