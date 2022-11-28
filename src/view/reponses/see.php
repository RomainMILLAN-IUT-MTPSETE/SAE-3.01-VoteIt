<link rel="stylesheet" href="css/Reponses/reponses-see.css">
<section class="button-top">
    <?php
    use \App\VoteIt\Model\Repository\VoteRepository;
    //USERCHANGE
    $voteState = (new VoteRepository())->stateVote($reponse->getIdQuestion(), "nadalc");
    $dateNow = date("Y-m-d");
    if($voteState == true && $question->getDateVoteDebut() < $dateNow  && $dateNow < $question->getDateVoteFin()){
        ?><a href="frontController.php?controller=reponses&action=vote&idReponse=<?php echo($_GET['idReponse']); ?>"><button id="buttonTop">Voter pour cette réponse <img id="imgButtonTop" src="assets/reponses/see/like.png" alt="Icone de nouvelle reponse"></button></a><?php
    }else {
        ?><button id="buttonTop-disable">Vote indisponible <img id="imgButtonTop" src="assets/reponses/see/like.png" alt="Icone de nouvelle reponse"></button><?php
    }
    ?>
</section>
<section class="reponse-see--container">

    <div class="title-reponse--container">
        <div class="title">
            <h2>Réponse n°<?php echo($reponse->getIdReponse()); ?>: <a href="frontController.php?controller=reponses&action=update&idReponse=<?php echo($reponse->getIdReponse()) ?>"><img src="assets/reponses/see/edit.png" alt="Icone d edition de reponse"></a><a href="frontController.php?controller=reponses&action=delete&idReponse=<?php echo($reponse->getIdReponse()) ?>"><img src="assets/reponses/see/delete.png" alt=""></a></h2></h2>
        </div>
        <p class="title-reponse-p"><?php echo($reponse->getTitreReponse()); ?></p>
        <div class="info-container">
            <div><span class="info-reponse-span"><p><span class="bolder">Auteur</span>: <?php echo($reponse->getAutheurId()) ?></span></div>
            <div><span class="info-reponse-span"><p><span class="bolder">Votes</span>: <?php echo($reponse->getNbVote()); ?></p><img src="assets/reponses/see/like.png" alt="Icone de vote"></span></div>
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
                    <h2><?php echo((new SectionRepository())->selectFromIdSection($item->getIdSection())->getTitreSection()) ?>:</h2>
                </div>
                <p><?php echo($item->getTexteSection()) ?></p>
            </div>
            <?php
        }
        ?>
    </div>

</section>