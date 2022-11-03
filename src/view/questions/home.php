<link rel="stylesheet" href="css/Questions/questions-home.css" type="text/css" >
<section class="votes-home--container">
    <button id="proposerQuestionButton">Proposer une Question <img id="imgPropose" src="assets/questions/home/button-newquestion.png" alt="Icone de nouvelle question"></button>
</section>
<section class="listeQuestion">
           <p id="question-title">Question <span class="colored">:</span></p>
       <a href="assets/question/imageFiltre.png" id="filtre">Filtrer <img id="imgFiltre" src="assets/questions/home/filter.png" alt="Icone de filtre"></a>
</section>
<?php
        foreach ($questions as $id) { ?>
            <div class="question-id--container">
                <div id="titreQuestion" >
                    <?php
                    echo $id->getTitreQuestion();
                    ?>
                </div>
                <div id="texteQuestion" >
                    <?php echo $id->getTexteQuestion(); ?>
                </div>
                <div id="auteurEtCategorie">
                    <div id="auteur">
                        <div class="ball">
                        </div>
                        <?php echo $id->getAutheur();?>
                    </div>
                    <div id="categorie" >
                        <?php echo $id->getCategorieQuestion();?>
                    </div>
                </div>
            </div>

        <?php } ?>


