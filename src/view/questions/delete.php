<?php

echo 'La question à bien été supprimée !';
self::afficheVue('view.php', ['questions' => $questions]);

?>