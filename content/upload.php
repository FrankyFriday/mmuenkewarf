<style>
    .buttonUpload{
        width: 100%;
        
    }
</style>
<?php
$detail=$_GET['detail'];

if($detail=="stammdaten"){
?>

<div class='container'>
    <div class="row">
        <div class="col-lg-7 mx-auto">
            <div class="card card-signin my-4">
                <div class="card-body">
                    
                            <h2 class="container card-title text-center btn-lg btn-warning">S T A M M D A T E N upload</h2>
                <form action="?content=uploadStammdaten" method="post" enctype="multipart/form-data">
                    
                    <div class="form-label-group mt-4">
                        
                        <label for="file">Wähle eine Excel-Datei (.xls):</label>
                    
                        <input type="file" id="file" name="file" class="btn btn-outline-secondary form-control" accept=".xls" required  aria-label="" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-label-group mt-4">
                    <button class="buttonUpload" type="submit">Hochladen</button>
                    <div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } 

if($detail=="spielestatistik"){
?>

<div class='container'>
    <div class="row">
        <div class="col-lg-7 mx-auto">
            <div class="card card-signin my-4">
                <div class="card-body">
                    
                            <h2 class="container card-title text-center btn-lg btn-warning">S P I E L E S T A T I S T I K upload</h2>
                <form action="?content=uploadSpielestatistik" method="post" enctype="multipart/form-data">
                    <div class="form-label-group mt-4">
                        
                        <span>Sollte die entsprechende Datei als *.pdf vorliegen, bitte einmal <a href="https://smallpdf.com/de/pdf-in-excel" target="_blank" >hier</a> umwandeln</span>
                    
                        
                    </div>
                    <div class="form-label-group mt-4">
                        
                        <label for="file">Wähle eine Excel-Datei (.xls):</label>
                    
                        <input type="file" id="file" name="file" class="btn btn-outline-secondary form-control" accept=".xls" required  aria-label="" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-label-group mt-4">
                    <button class="buttonUpload" type="submit">Hochladen</button>
                    <div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } 
   