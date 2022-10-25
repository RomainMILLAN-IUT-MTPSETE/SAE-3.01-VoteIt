<link rel="stylesheet" href="css/Questions/questions-home.css" type="text/css" >
<section class="votes-home--container">
    <button id="proposerQuestionButton">Proposer une Question <img id="imgPropose" src="assets/questions/home/button-newquestion.png" alt="Icone de nouvelle question"></button>
    <section class="listeQuestion">
        <div id="question-title--container">
            <p id="question-title">Question <span class="colored">:</span></p>
        </div>
        <a href="assets/question/imageFiltre.pn" id="filtre">Filtrer <img id="imgFiltre" src="assets/questions/home/filter.png" alt="Icone de filtre"></a>
    </section>
    <section class="questions-list--container">
        <?php
        foreach ($questions as $item){
            ?>
            <div class="question-div">

            </div>
            <?php
        }
        ?>
    </section>
</section>