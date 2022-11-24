<link rel="stylesheet" href="css/Questions/questions-see.css">
<section class="button-top">
    <a href="frontController.php?controller=reponses&action=create&idQuestion=<?php echo($_GET['idQuestion']); ?>"><button id="buttonTop">Proposer une Réponse <img id="imgButtonTop" src="assets/questions/home/button-newquestion.png" alt="Icone de nouvelle reponse"></button></a>
</section>
<section class="question-see--container">

    <section class="sect-see-question">
        <div class="sub-see-question-container">
            <h2><span class="title-sub-see-question">Question n°<?php echo($question->getIdQuestion()) ?>:</span><a href="frontController.php?controller=questions&action=update&idQuestion=<?php echo($_GET['idQuestion']) ?>"><img class="ml12px"
                            src="assets/questions/see/edit.png" alt="nope"></a><a href="frontController.php?controller=questions&action=delete&idQuestion=<?php echo($_GET['idQuestion']) ?>"><img class="ml8px"
                                                                                               src="assets/questions/see/delete.png" alt="nope"></a></h2>
            <p class="title-question-p"><?php echo($question->getTitreQuestion()) ?></p>
        </div>
        <div class="sub-see-question-container">
            <h2><span class="title-sub-see-question">Plan imposé:</span></h2>
            <?php
            if($sections == null){
                echo("<p>Aucun plan ajouté à la question</p>");
            }
            foreach ($sections as $section) {
                ?>
                <div class="section-plan--container">
                    <p class="section-p"><?php echo($section->getTitreSection()); ?>:</p>
                    <p class="section-p">  • <?php echo($section->getDescriptionSection()); ?></p>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="sub-see-question-container" id="sub-see-question-container-delais">
            <h2><span class="title-sub-see-question">Délais:</span></h2>
            <p id="sub-see-question-container-delais-pfirst">Réponses: Du <?php echo($question->getDateEcritureDebutFR()); ?> au <?php echo($question->getDateEcritureFinFR()); ?></p>
            <p>Vote: Du <?php echo($question->getDateVoteDebutFR()) ?> au <?php echo($question->getDateVoteFinFR()) ?></p>
        </div>
    </section>
    <hr class="inter-container-mobile" WIDTH="100px" COLOR="BLACK">
    <section class="reponse--container">
        <?php
        foreach ($reponses as $item){
            ?>
            <a href="frontController.php?controller=reponses&action=see&idReponse=<?php echo($item->getIdReponse()) ?>">
                <div class="reponse-id--container">
                <p class="reponse-number">Réponse n°<?php echo($item->getIdReponse()); ?></p>
                <p class="reponse-title"><?php echo($item->getTitreReponse()) ?></p>
                <div class="autheur-and-nb-vote--container">
                    <?php
                    $autheur = (new \App\VoteIt\Model\Repository\UtilisateurRepository())->select($item->getAutheurId());
                    ?>
                    <p class="autheur-reponse">Autheur: <?php echo($autheur->getNom() . " " . $autheur->getPrenom()) ?></p>
                    <span class="nbVote-reponse"><img src="assets/questions/see/like.png" alt="Icone LikeVoteNombre"><?php echo($item->getNbVote()); ?></span>
                </div>
            </div>
            </a>
            <?php
        }
        ?>
        <!--<a href="frontController.php?controller=reponses&action=create&idQuestion=<?php echo($_GET['idQuestion']); ?>"><button id="proposerReponse">Proposer une Réponse <img id="imgPropose" src="assets/questions/home/button-newquestion.png" alt="Icone de nouvelle question"></button></a>-->

    </section>
</section>