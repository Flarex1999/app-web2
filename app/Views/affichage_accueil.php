<h3>Actualités</h3><br />


<?php
if (!empty($id) && is_array($id)) {

    echo ('<table class="table table-stripped">
        <thead>
           <tr>
           <th scope="col"> <h4> Intitule </h4> </th>
           <th scope="col"> <h4> Description </h4> </th>
           <th scope="col"> <h4> Date </h4> </th>
           <th scope="col"> <h4> Auteur </h4> </th>
          </tr>');

    echo ("<thead>");

    foreach ($id as $new) {
        echo ("<tr>");
        echo ("<td>" . $new['new_intitule'] . "</td>");
        echo ("<td>" . $new['new_description'] . "</td>");
        echo ("<td>" . $new['new_date'] . "</td>");
        echo ("<td>" . $new['cpt_login'] . "</td>");
        echo ("<tr>");
    }

    echo ("<table>");
} else {
    echo ("Aucune actualité pour le moment !");
}

?>