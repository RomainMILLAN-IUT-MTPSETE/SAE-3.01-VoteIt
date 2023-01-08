<link rel="stylesheet" href="css/formulaire.css">
<link rel="stylesheet" href="css/Questions/questions-formulaire.css">
<form id="form" class="formulaire--container" action="frontController.php?controller=reponses&action=created" method="post" autocomplete="off">
    <div class="formulaire-template">
        <h2 class="title">Création de la réponse</h2>
        <div class="div-form-normal">
            <label for="titreReponse">Titre de la réponse</label>
            <input type="text" name="titreReponse" id="titreReponse" placeholder="Titre de la réponse" required>
        </div>
        <div class="autocomplete" id="co-auteur-container">
            <label for="votant">Utilisateur(s) Co-Auteur(s)</label>
            <input type="text" id="userCoAuteur" placeholder="johndoe10@gmail.com">
        </div>
        <div style="display: flex; flex-direction: row; align-items: left;">
            <div id="ajout-co-auteur" style="width: 21px; margin: 4px 2px;">
                <img id="plus" style="width: 21px; height: 21px;" src="assets/questions/update/add.png" alt="ajout d'un co-auteur">
            </div>
            <div id="supprimer-co-auteur" style="width: 21px; margin: 4px 2px;">
                <img id="minus" style="width: 21px; height: 21px;" src="assets/questions/update/minus.png" alt="suppression d'un co-auteur">
            </div>
        </div>
        <div class="section-text--container">
            <?php
            $i=1;
            foreach($sections as $section){
                ?>
                <hr width="200">
                <div class="section-container">
                    <label id="title-section-container" for="titreSection">Section n°<?php echo(htmlspecialchars($i)); ?></label>
                    <p><?php echo(htmlspecialchars($section->getTitreSection())); ?>: <?php echo(htmlspecialchars($section->getDescriptionSection())) ?></p>
                    <input type="hidden" name="idSection<?php echo(htmlspecialchars($i)); ?>" value="<?php echo(htmlspecialchars($section->getIdSection())); ?>" required>
                    <textarea name="texteSection<?php echo(htmlspecialchars($i)); ?>" required></textarea>
                </div>
                <?php
                $i++;
            }
            ?>
        </div>
        <div id="end-form">
            <input type="hidden" name="nbSection" value="<?php echo(htmlspecialchars($i-1)); ?>">
            <input type="number" name="idQuestion" id="idQuestion" placeholder="11" value="<?php echo(htmlspecialchars($_GET['idQuestion'])); ?>" hidden readonly/>
            <input type="text" name="autheur" id="autheur" value="<?php echo(\App\VoteIt\Lib\ConnexionUtilisateur::getLoginUtilisateurConnecte()) ?>" placeholder="JohnDoe10" hidden required/>
            <input type="submit" value="Créer la réponse" id="submit-btn">
        </div>
        <script type="text/javascript" src="src=../../../web/js/questions/script.js"></script>
        <script type="text/javascript">
            <?php
            use App\VoteIt\Model\Repository\UtilisateurRepository;
            $mails = (new UtilisateurRepository())->getMails();
            ?>
            var mails = JSON.parse(atob('<?php echo base64_encode(json_encode($mails));?>'));
            autocomplete(document.getElementById('userCoAuteur'), mails);
            const plusCoauteur = document.getElementById('ajout-co-auteur');
            const moinsCoAuteur = document.getElementById('supprimer-co-auteur');         
            const submit = document.getElementById('submit-btn');

            plusCoauteur.addEventListener('click', () => {
                const newInput = document.createElement('input');
                newInput.type = 'text';
                newInput.id = 'userCoAuteur';
                newInput.placeholder = 'johndoe10@gmail.com';
                newInput.className = 'autocomplete-input';
                newInput.style.marginTop = '20px';
                document.getElementById('co-auteur-container').appendChild(newInput);
                autocomplete(newInput, mails);
            });

            moinsCoAuteur.addEventListener('click', () => {
                const parent = document.getElementById('co-auteur-container');
                parent.removeChild(parent.lastChild);
            });

            submit.addEventListener('click', () => {
                //Co-auteurs
                const coAuteurContainer = document.querySelector('#co-auteur-container');
                const listCoAuteur = coAuteurContainer.querySelectorAll('input#userCoAuteur');
                var resCoAuteur = "";
                for(var i=0; i<listCoAuteur.length-1; i++){
                    resCoAuteur += listCoAuteur[i].value + ", ";
                }
                resCoAuteur += listCoAuteur[listCoAuteur.length-1].value;
                const inputCoAuteur = document.createElement('input');
                inputCoAuteur.type = 'hidden';
                inputCoAuteur.name = 'userCoAuteur';
                inputCoAuteur.value = resCoAuteur;
                document.getElementById('end-form').appendChild(inputCoAuteur);
                //Submit
                document.getElementById('form').submit();
            });
        </script>
    </div>
</form>