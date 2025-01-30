
<?php
require_once './functions/doAnwaerter.php';
require_once './functions/doHistory.php';
?>
<div class='mt-2'></div>
<center><h2>Dashboard Anwärter*in</h2></center>
<center>

<?php
    doListeAnwaerter($link)?>
</center>


<div class='container'>
<div class="col-sm-9 col-md-7 col-lg-8 mx-auto">
<div class="card card-signin my-5">
<div class="card-body">
    <small>
    <table>
    <tr>
        <th colspan="3">
    Legende<br><br>
        </th>
    </tr>
    <tr>
        <th width="350px">
            Farbenverzeichnis
        </th>
        <th width="200px">
            Einsätze
        </th>
        <th width="200px">
            Aktion
        </th>
    </tr>
    <tr>
        <td valign="top">
            <span style="background-color: #7FFFD4">aktive(r) SR*in</span><br>
            <span style="background-color: #F88379">kein Interesse als SR*in</span><br>
            <span style="background-color: #FFA500">kein Interesse am Patensystem</span><br>
            <span style="background-color: #FFFAA0">mind. 3 geplante o. abgeschlossene Einsätze </span><br>
        </td>
        <td valign="top">
            g / s (o) [r]<br>
            g: geplant <br>
            s: statt gefunden<br>
            o: offene Berichte<br>
            r: Rückgaben
        </td>
        <td valign="top">
            <i class="fa fa-user"/>: Personendaten ändern <br><br>
            <i class="fa fa-futbol-o"/>: Spielleitungen
        </td>
    </tr>
</table>      
        </small>
           
</div>
</div>
</div>
</div>
