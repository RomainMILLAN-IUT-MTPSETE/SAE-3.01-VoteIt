<link rel="stylesheet" href="css/Questions/questions-see.css">
<section class="button-top">
    <?php
    use \App\VoteIt\Model\Repository\VoteRepository;
    $dateNow = date("Y-m-d");
    if($question->getDateEcritureDebut() <= $dateNow  && $dateNow <= $question->getDateEcritureFin()){
        ?>    <a href="frontController.php?controller=reponses&action=create&idQuestion=<?php echo(rawurlencode($_GET['idQuestion'])); ?>"><button id="buttonTop">Proposer une Réponse <img id="imgButtonTop" src="assets/questions/home/button-newquestion.png" alt="Icone de nouvelle reponse"></button></a><?php
    }else {
        ?>    <button id="buttonTop-disable">Réponse Indisponible<img id="imgButtonTop" src="assets/questions/home/button-newquestion.png" alt="Icone de nouvelle reponse"></button><?php
    }
    ?>
</section>
<section class="question-see--container">

    <section class="sect-see-question">
        <div class="sub-see-question-container">
            <h2><span class="title-sub-see-question">Question n°<?php echo(htmlspecialchars($question->getIdQuestion())) ?>  <span class="colored">:</span> </span><a href="frontController.php?controller=questions&action=update&idQuestion=<?php echo(rawurlencode($_GET['idQuestion'])) ?>"><img class="ml12px"
                            src="assets/questions/see/edit.png" alt="nope"></a><a href="frontController.php?controller=questions&action=delete&idQuestion=<?php echo(rawurlencode($_GET['idQuestion'])) ?>"><img class="ml8px"
                                                                                               src="assets/questions/see/delete.png" alt="nope"></a></h2>
            <p class="title-question-p"><span class="bolder">Titre:</span> <?php echo(htmlspecialchars($question->getTitreQuestion())) ?></p>
            <p><span class="bolder">Auteur:</span> <?php
                $autheur = (new \App\VoteIt\Model\Repository\UtilisateurRepository())->select($question->getAutheur());
                echo(htmlspecialchars($autheur->getNom()) . " " . htmlspecialchars($autheur->getPrenom())) ?></p>
        </div>
        <div class="sub-see-question-container">
            <h2><span class="title-sub-see-question">Plan imposé  <span class="colored">:</span></span></h2>
            <?php
            if($sections == null){
                echo("<p>Aucun plan ajouté à la question</p>");
            }
            foreach ($sections as $section) {
                ?>
                <div class="section-plan--container">
                    <p class="section-p"><span class="bolder"><?php echo(htmlspecialchars($section->getTitreSection())); ?></span>:</p>
                    <p class="section-p">  • <?php echo(htmlspecialchars($section->getDescriptionSection())); ?></p>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="sub-see-question-container" id="sub-see-question-container-delais">
            <h2><span class="title-sub-see-question">Délais  <span class="colored">:</span></span></h2>
            <p id="sub-see-question-container-delais-pfirst"><span class="bolder">Réponses</span>: Du <?php echo(htmlspecialchars($question->getDateEcritureDebutFR())); ?> au <?php echo(htmlspecialchars($question->getDateEcritureFinFR())); ?></p>
            <p><span class="bolder">Vote</span>: Du <?php echo(htmlspecialchars($question->getDateVoteDebutFR())) ?> au <?php echo(htmlspecialchars($question->getDateVoteFinFR())) ?></p>
        </div>
    </section>
    <hr class="inter-container-mobile" WIDTH="100px" COLOR="BLACK">
    <section class="reponse--container">
        <?php
        foreach ($reponses as $item){
            ?>
            <a href="frontController.php?controller=reponses&action=see&idReponse=<?php echo(rawurlencode($item->getIdReponse())) ?>">
                <div class="reponse-id--container">
                <p class="reponse-number">Réponse n°<?php echo(htmlspecialchars($item->getIdReponse())); ?></p>
                <p class="reponse-title"><?php echo(htmlspecialchars($item->getTitreReponse())) ?></p>
                <div class="autheur-and-nb-vote--container">
                    <?php
                    $autheur = (new \App\VoteIt\Model\Repository\UtilisateurRepository())->select($item->getAutheurId());
                    ?>
                    <p class="autheur-reponse">Auteur: <?php echo(htmlspecialchars($autheur->getNom()) . " " . htmlspecialchars($autheur->getPrenom())) ?></p>
                    <span class="nbVote-reponse"><img src="assets/questions/see/like.png" alt="Icone LikeVoteNombre"><?php echo(htmlspecialchars((VoteRepository::getNbVoteForReponse($item->getIdReponse())))); ?></span>
                </div>
            </div>
            </a>
            <?php
        }
        ?>
    </section>
</section>