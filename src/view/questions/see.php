<link rel="stylesheet" href="css/Questions/questions-see.css">
<section class="question-see--container">
    <section class="sect-see-question">
        <div class="sub-see-question-container">
            <h2><span class="title-sub-see-question">Titre:</span></h2>
            <p><?php echo($question->getTitreQuestion()) ?></p>
        </div>
        <div class="sub-see-question-container">
            <h2><span class="title-sub-see-question">Plan imposé:</span></h2>
            <?php
            if($sections == null){
                echo("<p>Aucun plan ajouté à la question</p>");
            }
            foreach ($sections as $section) {
                ?><p><?php echo($section->getTitreSection()); ?></p><?php
            }
            ?>
        </div>
        <div class="sub-see-question-container" id="sub-see-question-container-delais">
            <h2><span class="title-sub-see-question">Délais:</span></h2>
            <p id="sub-see-question-container-delais-pfirst">Réponses: Du <?php echo($question->getDateEcritureDebut()); ?> au <?php echo($question->getDateEcritureFin()); ?></p>
            <p>Vote: Du <?php echo($question->getDateVoteDebut()) ?> au <?php echo($question->getDateVoteFin()) ?></p>
        </div>
    </section>
    <hr class="inter-container-mobile" WIDTH="100px" COLOR="BLACK">
    <section class="reponse--container">
        <?php
        foreach ($reponses as $item){
            ?>
            <div class="reponse-id--container">
                <p class="reponse-number">Réponse n°<?php echo($item->getIdReponse()); ?></p>
                <p class="reponse-txt"><?php echo($item->getTexteReponse()); ?></p>
                <div class="autheur-and-nb-vote--container">
                    <?php
                    $autheur = (new \App\VoteIt\Model\Repository\UtilisateurRepository())->select($item->getAutheurId());
                    ?>
                    <p class="autheur-reponse">Autheur: <?php echo($autheur->getNom() . " " . $autheur->getPrenom()) ?></p>
                    <span class="nbVote-reponse"><img src="assets/questions/see/like.png" alt="Icone LikeVoteNombre"><?php echo($item->getNbVote()); ?></span>
                </div>
            </div>
            <?php
        }
        ?>
        <a href="frontController.php?controller=reponses&action=create"><button id="proposerReponse">Proposer une Réponse <img id="imgPropose" src="assets/questions/home/button-newquestion.png" alt="Icone de nouvelle question"></button></a>

    </section>
</section>