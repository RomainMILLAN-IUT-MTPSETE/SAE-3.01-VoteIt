<link rel="stylesheet" href="css/Questions/questions-see.css">
<link rel="stylesheet" href="css/switch-top.css">
<?php
//USES
use \App\VoteIt\Model\Repository\VoteRepository;
use \App\VoteIt\Model\Repository\UtilisateurRepository;
use \App\VoteIt\Model\Repository\ReponsesRepository;


?>
<div class="switch-top">
    <?php
    if ($_GET['idQuestion'] != $allIdQuestion[0]) {
        echo '<a class="switch-top-left fullleft" href="frontController.php?controller=questions&action=see&idQuestion=' . $allIdQuestion[array_search($_GET['idQuestion'], $allIdQuestion) - 1] . '">← Question précédente</a>';
    }
    if ($_GET['idQuestion'] != $allIdQuestion[count($allIdQuestion) - 1]) {
        if($_GET['idQuestion'] == $allIdQuestion[0]){
            echo '<a class="switch-top-right fullright" href="frontController.php?controller=questions&action=see&idQuestion=' . $allIdQuestion[array_search($_GET['idQuestion'], $allIdQuestion) + 1] . '">Question suivante →</a>';
        }else {
            echo '<a class="switch-top-right" href="frontController.php?controller=questions&action=see&idQuestion=' . $allIdQuestion[array_search($_GET['idQuestion'], $allIdQuestion) + 1] . '">Question suivante →</a>';
        }
    }
    ?>
</div>
<section class="button-top">
    <?php

    if ($canModifOrDelete or $estReponsable) {
        if ($periodeReponse) {
            ?>
            <a href="frontController.php?controller=reponses&action=create&idQuestion=<?php echo(rawurlencode($_GET['idQuestion'])); ?>">
                <button id="buttonTop">Proposer une Réponse <img id="imgButtonTop" src="assets/questions/home/button-newquestion.png" alt="Icone de nouvelle reponse"></button>
            </a>
            <?php
        } else {
            ?><a href="frontController.php?controller=questions&action=vote&idQuestion=<?php echo(rawurlencode($_GET['idQuestion'])); ?>">
                <button id="buttonTop">Voter pour cette réponse <img id="imgButtonTop" src="assets/reponses/see/like.png" alt="Icone de nouvelle reponse"></button>
            </a><?php
        }
    }

    ?>


</section>
<section class="question-see--container">
    <section class="sect-see-question">
        <div class="sub-see-question-container">
            <h2><span class="title-sub-see-question">Détail de la question<span class="colored">:</span></span>
                <?php if ($canModifOrDelete == true) { ?>
                    <a href="frontController.php?controller=questions&action=update&idQuestion=<?php echo(rawurlencode($_GET['idQuestion'])) ?>">
                        <img class="ml12px" src="assets/questions/see/edit.png" alt="nope">
                    </a>
                    <a href="frontController.php?controller=questions&action=delete&idQuestion=<?php echo(rawurlencode($_GET['idQuestion'])) ?>">
                        <img class="ml8px" src="assets/questions/see/delete.png" alt="nope">
                    </a>
                <?php } ?>
            </h2>
            <p class="title-question-p"><span class="bolder">Titre: </span><?php echo(htmlspecialchars($question->getTitreQuestion())) ?></p>
            <p><span class="bolder">Auteur: </span><?php echo(htmlspecialchars($auteur->getNom()) . " " . htmlspecialchars($auteur->getPrenom())) ?></p>
        </div>

        <div class="sub-see-question-container">
            <h2><span class="title-sub-see-question">Plan imposé <span class="colored">:</span></span></h2>
            <?php
                if ($sections == null) {
                    echo("<p>Aucun plan ajouté à la question</p>");
                }else {
                    foreach ($sections as $section) {
                        ?>
                        <div class="section-plan--container">
                            <p class="section-p">
                                <span class="bolder"><?php echo(htmlspecialchars($section->getTitreSection())); ?></span>
                                :
                            </p>
                            <p class="section-p"> • <?php echo(htmlspecialchars($section->getDescriptionSection())); ?></p>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>

        <div class="sub-see-question-container" id="sub-see-question-container-delais">
            <h2><span class="title-sub-see-question">Délais <span class="colored">:</span></span></h2>
            <p id="sub-see-question-container-delais-pfirst"><span class="bolder">Réponses</span>:
                Du <?php echo(htmlspecialchars($question->getDateEcritureDebutFR())); ?>
                au <?php echo(htmlspecialchars($question->getDateEcritureFinFR())); ?>
                <?php if($periodeReponse) { ?>
                    <span style="color: #3c763d;" class="green">✔</span>
                <?php }else { ?>
                    <span style="color: #a94442;" class="red">✖</span>
                <?php } ?>
            </p>
            <p><span class="bolder">Vote</span>:
                Du <?php echo(htmlspecialchars($question->getDateVoteDebutFR())) ?>
                au <?php echo(htmlspecialchars($question->getDateVoteFinFR())) ?>
                <?php if($periodeVote) { ?>
                    <span style="color: #3c763d;" class="green">✔</span>
                <?php }else { ?>
                    <span style="color: #a94442;" class="red">✖</span>
                <?php } ?>
            </p>
        </div>
    </section>

    <hr class="inter-container-mobile" WIDTH="100px" COLOR="BLACK">

    <section class="reponse--container">
        <div class="title-reponse-container">
            <h2 class="title-sub-see-reponse"><?php
                if (count($reponses) <= 1) {
                    echo 'Réponse';
                } else {
                    echo 'Réponses';
                }
                ?> (<?php
                echo count($reponses)
                ?>)<span class="colored">:</span></h2>
        </div>

        <?php
        $i = 1;
        $dateNow = date("Y-m-d");

        if ($question->getDateVoteFin() < $dateNow) {
            if($nbVoteMax == -1){
                foreach($reponses as $item){
                    ?>
                    <a href="frontController.php?controller=reponses&action=see&idReponse=<?php echo(rawurlencode($item->getIdReponse())) ?>&seeId=<?php echo($i); ?>">
                        <div class="reponse-id--container">
                            <p class="reponse-number">Réponse <span class="red">non valide</span></p>
                            <p class="reponse-title"><?php echo(htmlspecialchars($item->getTitreReponse())) ?></p>
                            <div class="autheur-and-nb-vote--container">
                                <?php $autheur = (new UtilisateurRepository())->select($item->getAutheurId()); ?>
                                <p class="autheur-reponse">Auteur: <?php echo(htmlspecialchars($autheur->getNom()) . " " . htmlspecialchars($autheur->getPrenom())) ?></p>
                                <span class="nbVote-reponse"><img src="assets/questions/see/like.png" alt="Icone LikeVoteNombre"><?php echo(htmlspecialchars((VoteRepository::getNbVoteForReponse($item->getIdReponse())))); ?></span>
                            </div>
                        </div>
                    </a>
                    <?php
                }
            }else {
                $idMaxVote = (new ReponsesRepository())->getIdReponseWithVoteMaxParIdQuestion($question->getIdQuestion());

                foreach ($reponses as $item) {
                    if(count($idMaxVote) > 1){
                        for ($r=0; $r<count($idMaxVote); $r++) {
                            if($item->getIdReponse() == $idMaxVote[$r]){
                                $idMaxVote[$r] = -1;
                                ?>
                                <a href="frontController.php?controller=reponses&action=see&idReponse=<?php echo(rawurlencode($item->getIdReponse())) ?>&seeId=<?php echo($i); ?>">
                                    <div class="reponse-id--container">
                                        <p class="reponse-number">Réponse <span class="colored">gagnante ex-aequo</span></p>
                                        <p class="reponse-title"><?php echo(htmlspecialchars($item->getTitreReponse())) ?></p>
                                        <div class="autheur-and-nb-vote--container">
                                            <?php $autheur = (new UtilisateurRepository())->select($item->getAutheurId()); ?>
                                            <p class="autheur-reponse">Auteur: <?php echo(htmlspecialchars($autheur->getNom()) . " " . htmlspecialchars($autheur->getPrenom())) ?></p>
                                            <span class="nbVote-reponse"><img src="assets/questions/see/like.png" alt="Icone LikeVoteNombre"><?php echo(htmlspecialchars((VoteRepository::getNbVoteForReponse($item->getIdReponse())))); ?></span>
                                        </div>
                                    </div>
                                </a>
                                <?php
                            }
                        }
                    }else {
                        if($item->getIdReponse() == $idMaxVote[0]){
                            ?>
                            <a href="frontController.php?controller=reponses&action=see&idReponse=<?php echo(rawurlencode($item->getIdReponse())) ?>&seeId=<?php echo($i); ?>">
                                <div class="reponse-id--container">
                                    <p class="reponse-number">Réponse <span class="colored">gagnante</span></p>
                                    <p class="reponse-title"><?php echo(htmlspecialchars($item->getTitreReponse())) ?></p>
                                    <div class="autheur-and-nb-vote--container">
                                        <?php $autheur = (new UtilisateurRepository())->select($item->getAutheurId());?>
                                        <p class="autheur-reponse">Auteur: <?php echo(htmlspecialchars($autheur->getNom()) . " " . htmlspecialchars($autheur->getPrenom())) ?></p>
                                        <span class="nbVote-reponse"><img src="assets/questions/see/like.png" alt="Icone LikeVoteNombre"><?php echo(htmlspecialchars((VoteRepository::getNbVoteForReponse($item->getIdReponse())))); ?></span>
                                    </div>
                                </div>
                            </a>
                            <?php
                        }
                    }


                }
            }
        }else {
            foreach ($reponses as $item) {
                ?>
                <a href="frontController.php?controller=reponses&action=see&idReponse=<?php echo(rawurlencode($item->getIdReponse())) ?>&seeId=<?php echo($i); ?>">
                    <div class="reponse-id--container">
                        <p class="reponse-number">Réponse n°<?php echo(htmlspecialchars($i)); ?></p>
                        <p class="reponse-title"><?php echo(htmlspecialchars($item->getTitreReponse())) ?></p>
                        <div class="autheur-and-nb-vote--container">
                            <?php
                            $autheur = (new UtilisateurRepository())->select($item->getAutheurId());
                            ?>
                            <p class="autheur-reponse">
                                Auteur: <?php echo(htmlspecialchars($autheur->getNom()) . " " . htmlspecialchars($autheur->getPrenom())) ?></p>
                            <span class="nbVote-reponse"><img src="assets/questions/see/like.png"
                                                              alt="Icone LikeVoteNombre"><?php echo(htmlspecialchars((VoteRepository::getNbVoteForReponse($item->getIdReponse())))); ?></span>
                        </div>
                    </div>
                </a>
                <?php
                $i++;
            }
        }
        ?>
    </section>
</section>