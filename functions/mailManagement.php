<?php
function doSendMail($anwaerterVorname,$anwaerterNachname,$datum,$pateVorname,$pateNachname,$staffel,$link) {
    $bearbeiter=doSelectBearbeiter($_SESSION['bearbeiterId'], $link);
    $current_time = date("d.m.Y H:i:s");
    $dat = new DateTime($datum);
    $datumSpiel=$dat->format('d.m.Y');
    
    // Empfänger und Absender
    $to = 'sr.matthias.muenkewarf@gmx.de';
    $from = 'no_reply@srostfriesland.net';
    $fromName = 'HomePage Patenschaft';

    // Betreff    
    $subject = 'neuer Patenbericht - Neuling: '.$anwaerterVorname.' '.$anwaerterNachname;

    $dateiname = $anwaerterNachname."_".$anwaerterVorname."_".$datum;
    // Dateipfad zur PDF
    $upload_folder = './berichte/'; //Das Upload-Verzeichnis
    $filename = $dateiname;
    $extension = 'pdf';
    
    $filePath = $upload_folder.$filename.'.'.$extension;
    $fileName = basename($filePath);

    // E-Mail-Header
    $boundary = md5(time()); // Einzigartiger Boundary-Wert für die Trennung der Teile der E-Mail

    $headers = "From: $fromName <$from>\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    
    // Nachrichtenkörper
    $message = "--$boundary\r\n";
    $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $message .= "Es wurde ein neuer Patenbericht hochgeladen.\r\n\r\n";
    $message .= "Anwärter*in: ".$anwaerterVorname." ".$anwaerterNachname."\r\n";
    $message .= "Spieldatum: ".$datumSpiel."\r\n\r\n";
    $message .= "Pate/Patin: ".$pateVorname." ".$pateNachname."\r\n";
    $message .= "Staffel: ".$staffel."\r\n\r\n";
    $message .= "Bearbeiter*in: ".$bearbeiter."\r\n";
    $message .= "Zeitpunkt: ".$current_time."\r\n\r\n";
    
    // PDF-Anhang
    $fileContent = file_get_contents($filePath);
    $fileContent = chunk_split(base64_encode($fileContent)); // Dateiinhalt in Base64 kodieren

    $message .= "--$boundary\r\n";
    $message .= "Content-Type: application/pdf; name=\"$fileName\"\r\n";
    $message .= "Content-Transfer-Encoding: base64\r\n";
    $message .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n\r\n";
    $message .= $fileContent . "\r\n";
    $message .= "--$boundary--"; // Ende der Nachricht

    // E-Mail senden
    mail($to, $subject, $message, $headers);

}

