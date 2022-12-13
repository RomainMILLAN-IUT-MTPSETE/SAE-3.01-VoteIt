<link rel="stylesheet" href="css/Reponses/reponses-see.css">
<link rel="stylesheet" href="css/switch-top.css">
<?php

use \App\VoteIt\Model\Repository\ReponsesRepository;

$tab = (new ReponsesRepository())->allIdReponseByIdQuestion($reponse->getIdQuestion());

?>
<div class="switch-top">
    <?php
    if ($_GET['idReponse'] != $tab[0]) {
        $seeId = $_GET['seeId'] - 1;
        echo '<a class="switch-top-left fullleft" href="frontController.php?controller=reponses&action=see&idReponse=' . $tab[array_search($_GET['idReponse'], $tab) - 1] . '&seeId=' . $seeId . '">← Réponse précédente</a>';
    }
    if ($_GET['idReponse'] != $tab[count($tab) - 1]) {
        $seeId = $_GET['seeId'] + 1;
        if ($_GET['idReponse'] == $tab[0]) {
            echo '<a class="switch-top-right fullright" href="frontController.php?controller=reponses&action=see&idReponse=' . $tab[array_search($_GET['idReponse'], $tab) + 1] . '&seeId=' . $seeId . '">Réponse suivante →</a>';
        } else {
            echo '<a class="switch-top-right" href="frontController.php?controller=reponses&action=see&idReponse=' . $tab[array_search($_GET['idReponse'], $tab) + 1] . '&seeId=' . $seeId . '">Réponse suivante →</a>';

        }
    }
    ?>
</div>
<section class="button-top">
    <?php

    use \App\VoteIt\Lib\ConnexionUtilisateur;
    use \App\VoteIt\Model\Repository\VoteRepository;
    use \App\VoteIt\Model\Repository\PermissionsRepository;

    $estCoAuteur = (new PermissionsRepository())->getPermissionCoAuteurParIdUtilisateurEtIdReponse($reponse->getIdReponse(), ConnexionUtilisateur::getLoginUtilisateurConnecte());
    $estVotant = (new PermissionsRepository())->getPermissionVotantParIdUtilisateurEtIdQuestion($reponse->getIdQuestion(), ConnexionUtilisateur::getLoginUtilisateurConnecte());
    //USERCHANGE
    $voteState = false;
    $canDelete = false;
    $canModif = false;
    if (ConnexionUtilisateur::estConnecte()) {
        $user = (new \App\VoteIt\Model\Repository\UtilisateurRepository())->select(ConnexionUtilisateur::getLoginUtilisateurConnecte());

        if ((strcmp($reponse->getAutheurId(), $user->getIdentifiant()) == 0) or (strcmp($user->getGrade(), "Organisateur") == 0) or (strcmp($user->getGrade(), "Administrateur") == 0)) {
            $canDelete = true;
            $canModif = true;
        }
        if($estCoAuteur){
            $canModif = true;
        }
        if (($estVotant == true)) {
            $voteState = (new VoteRepository())->stateVote($reponse->getIdQuestion(), $user->getIdentifiant());
            $dateNow = date("Y-m-d");
            if ($voteState == true && $question->getDateVoteDebut() <= $dateNow && $dateNow <= $question->getDateVoteFin()) {
                ?><a
                href="frontController.php?controller=reponses&action=vote&idReponse=<?php echo(rawurlencode($_GET['idReponse'])); ?>">
                    <button id="buttonTop">Voter pour cette réponse <img id="imgButtonTop"
                                                                         src="assets/reponses/see/like.png"
                                                                         alt="Icone de nouvelle reponse"></button>
                </a><?php
            } else {
                ?>
                <button id="buttonTop-disable">Vote indisponible <img id="imgButtonTop"
                                                                      src="assets/reponses/see/like.png"
                                                                      alt="Icone de nouvelle reponse"></button><?php
            }
        }
    }

    ?>
</section>
<section class="reponse-see--container">

    <div class="title-reponse--container">
        <div class="title">
            <h2>Réponse n°<?php echo(htmlspecialchars($_GET['seeId'])); ?> <span
                        class="colored">:</span> <?php if ($canModif == true && $canDelete == true) { ?><a
                    href="frontController.php?controller=reponses&action=update&idReponse=<?php echo(rawurlencode($reponse->getIdReponse())) ?>">
                        <img src="assets/reponses/see/edit.png" alt="Icone d edition de reponse"></a><a
                        href="frontController.php?controller=reponses&action=delete&idReponse=<?php echo(rawurlencode($reponse->getIdReponse())) ?>">
                        <img src="assets/reponses/see/delete.png" alt=""></a><?php } ?><?php if($canModif == true && $canDelete == false) {?><a
                    href="frontController.php?controller=reponses&action=updatecoauteur&idReponse=<?php echo(rawurlencode($reponse->getIdReponse())) ?>">
                        <img src="assets/reponses/see/edit.png" alt="Icone d edition de reponse"></a><?php } ?></h2></h2>
        </div>
        <p class="title-reponse-p"><?php echo(htmlspecialchars($reponse->getTitreReponse())); ?></p>
        <div class="info-container">
            <div><span class="info-reponse-span"><p><span
                                class="bolder">Auteur</span>: <?php echo(htmlspecialchars($reponse->getAutheurId())) ?></span>
            </div>
            <div><span class="info-reponse-span"><p><span
                                class="bolder">Votes</span>: <?php echo(htmlspecialchars(VoteRepository::getNbVoteForReponse($reponse->getIdReponse()))); ?></p><img
                            src="assets/reponses/see/like.png" alt="Icone de vote"></span></div>
        </div>
    </div>
    <hr WIDTH="400px">
    <div class="sections-reponse--container">
        <?php

        use \App\VoteIt\Model\Repository\SectionRepository;

        foreach ($sectionsReponse as $item) {
            ?>
            <div class="section-container">
                <div class="section-title">
                    <h2><?php echo(htmlspecialchars((new SectionRepository())->selectFromIdSection($item->getIdSection())->getTitreSection())) ?>
                        <span class="colored">:</span></h2>
                </div>
                <p><?php echo(htmlspecialchars($item->getTexteSection())) ?></p>
            </div>
            <?php
        }
        ?>
    </div>

</section>