<link rel="stylesheet" href="css/Questions/questions-see.css">
<link rel="stylesheet" href="css/switch-top.css">
<?php


//SWITCH QUESTIONS
use \App\VoteIt\Model\Repository\QuestionsRepository;
$tab = (new QuestionsRepository())->allIdQuestion();
?>
<div class="switch-top">
    <?php
    if ($_GET['idQuestion'] != $tab[0]) {
        echo '<a class="switch-top-left fullleft" href="frontController.php?controller=questions&action=see&idQuestion=' . $tab[array_search($_GET['idQuestion'], $tab) - 1] . '">← Question précédante</a>';
    }
    if ($_GET['idQuestion'] != $tab[count($tab) - 1]) {
        if($_GET['idQuestion'] == $tab[0]){
            echo '<a class="switch-top-right fullright" href="frontController.php?controller=questions&action=see&idQuestion=' . $tab[array_search($_GET['idQuestion'], $tab) + 1] . '">Question suivante →</a>';
        }else {
            echo '<a class="switch-top-right" href="frontController.php?controller=questions&action=see&idQuestion=' . $tab[array_search($_GET['idQuestion'], $tab) + 1] . '">Question suivante →</a>';

        }
    }

    use \App\VoteIt\Model\Repository\PermissionsRepository;
    use \App\VoteIt\Lib\ConnexionUtilisateur;
    $permission = (new PermissionsRepository())->getPermissionQuestionParIdUtilisateur($_GET['idQuestion'], ConnexionUtilisateur::getLoginUtilisateurConnecte());
    ?>
</div>
<section class="button-top">
    <?php
    use \App\VoteIt\Model\Repository\VoteRepository;

    $canModifOrDelete = false;

    if (ConnexionUtilisateur::estConnecte()) {
        $user = (new \App\VoteIt\Model\Repository\UtilisateurRepository())->select(ConnexionUtilisateur::getLoginUtilisateurConnecte());

        if((strcmp($question->getAutheur(), $user->getIdentifiant()) == 0) or (strcmp($user->getGrade(), "Organisateur") == 0) or (strcmp($user->getGrade(), "Administrateur") == 0)){
            $canModifOrDelete = true;
        }
        if ($canModifOrDelete or (strcmp($permission, "responsable de proposition") == 0)) {
            $dateNow = date("Y-m-d");
            if ($question->getDateEcritureDebut() <= $dateNow && $dateNow <= $question->getDateEcritureFin()) {
                ?> <a
                    href="frontController.php?controller=reponses&action=create&idQuestion=<?php echo(rawurlencode($_GET['idQuestion'])); ?>">
                    <button id="buttonTop">Proposer une Réponse <img id="imgButtonTop"
                                                                     src="assets/questions/home/button-newquestion.png"
                                                                     alt="Icone de nouvelle reponse"></button></a><?php
            } else {
                ?>
                <button id="buttonTop-disable">Réponse Indisponible<img id="imgButtonTop"
                                                                        src="assets/questions/home/button-newquestion.png"
                                                                        alt="Icone de nouvelle reponse"></button><?php
            }
        }
    }

    ?>


</section>
<section class="question-see--container">

    <section class="sect-see-question">
        <div class="sub-see-question-container">
            <h2><span class="title-sub-see-question">Détail de la question<span
                            class="colored">:</span> </span><?php if ($canModifOrDelete == true) { ?><a
                    href="frontController.php?controller=questions&action=update&idQuestion=<?php echo(rawurlencode($_GET['idQuestion'])) ?>">
                        <img class="ml12px" src="assets/questions/see/edit.png" alt="nope"></a><a
                        href="frontController.php?controller=questions&action=delete&idQuestion=<?php echo(rawurlencode($_GET['idQuestion'])) ?>">
                        <img class="ml8px" src="assets/questions/see/delete.png" alt="nope"></a><?php } ?></h2>
            <p class="title-question-p"><span
                        class="bolder">Titre:</span> <?php echo(htmlspecialchars($question->getTitreQuestion())) ?></p>
            <p><span class="bolder">Auteur:</span> <?php
                $autheur = (new \App\VoteIt\Model\Repository\UtilisateurRepository())->select($question->getAutheur());
                echo(htmlspecialchars($autheur->getNom()) . " " . htmlspecialchars($autheur->getPrenom())) ?></p>
        </div>
        <div class="sub-see-question-container">
            <h2><span class="title-sub-see-question">Plan imposé <span class="colored">:</span></span></h2>
            <?php
            if ($sections == null) {
                echo("<p>Aucun plan ajouté à la question</p>");
            }
            foreach ($sections as $section) {
                ?>
                <div class="section-plan--container">
                    <p class="section-p"><span
                                class="bolder"><?php echo(htmlspecialchars($section->getTitreSection())); ?></span>:</p>
                    <p class="section-p"> • <?php echo(htmlspecialchars($section->getDescriptionSection())); ?></p>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="sub-see-question-container" id="sub-see-question-container-delais">
            <h2><span class="title-sub-see-question">Délais <span class="colored">:</span></span></h2>
            <p id="sub-see-question-container-delais-pfirst"><span class="bolder">Réponses</span>:
                Du <?php echo(htmlspecialchars($question->getDateEcritureDebutFR())); ?>
                au <?php echo(htmlspecialchars($question->getDateEcritureFinFR())); ?></p>
            <p><span class="bolder">Vote</span>: Du <?php echo(htmlspecialchars($question->getDateVoteDebutFR())) ?>
                au <?php echo(htmlspecialchars($question->getDateVoteFinFR())) ?></p>
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
        if ($dateNow > $question->getDateVoteFin()) {
            $idMaxVote = (new \App\VoteIt\Model\Repository\ReponsesRepository())->getIdReponseMaxVoteParIdQuestion($question->getIdQuestion());
            foreach ($reponses as $item) {
                if($item->getIdReponse() == $idMaxVote){
                    ?>
                    <a href="frontController.php?controller=reponses&action=see&idReponse=<?php echo(rawurlencode($item->getIdReponse())) ?>&seeId=<?php echo($i); ?>">
                        <div class="reponse-id--container">
                            <p class="reponse-number">Réponse <span class="colored">Gagnante</span></p>
                            <p class="reponse-title"><?php echo(htmlspecialchars($item->getTitreReponse())) ?></p>
                            <div class="autheur-and-nb-vote--container">
                                <?php
                                $autheur = (new \App\VoteIt\Model\Repository\UtilisateurRepository())->select($item->getAutheurId());
                                ?>
                                <p class="autheur-reponse">
                                    Auteur: <?php echo(htmlspecialchars($autheur->getNom()) . " " . htmlspecialchars($autheur->getPrenom())) ?></p>
                                <span class="nbVote-reponse"><img src="assets/questions/see/like.png"
                                                                  alt="Icone LikeVoteNombre"><?php echo(htmlspecialchars((VoteRepository::getNbVoteForReponse($item->getIdReponse())))); ?></span>
                            </div>
                        </div>
                    </a>
                    <?php
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
                            $autheur = (new \App\VoteIt\Model\Repository\UtilisateurRepository())->select($item->getAutheurId());
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