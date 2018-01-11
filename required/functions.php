<?php
	function str_random($length)
	{
		$alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
	}

	function send_mail($to, $subject, $message)
	{
     // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
     $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

     // En-têtes additionnels
     $headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
     $headers .= 'From: Camaguru <camaguru@example.com>' . "\r\n";
     $headers .= 'Cc: camaguru_archive@example.com' . "\r\n";
     $headers .= 'Bcc: camaguru_verif@example.com' . "\r\n";
     // Envoi
     mail($to, $subject, $message, $headers);
 	}

     function clearDir($dossier) {
         $ouverture=@opendir($dossier);
         if (!$ouverture) return;
         while($fichier=readdir($ouverture)) {
             if ($fichier == '.' || $fichier == '..') continue;
                 if (is_dir($dossier."/".$fichier)) {
                     $r=clearDir($dossier."/".$fichier);
                     if (!$r) return false;
                 }
                 else {
                     $r=@unlink($dossier."/".$fichier);
                     if (!$r) return false;
                 }
          }
          closedir($ouverture);
          $r=@rmdir($dossier);
          if (!$r) return false;
              return true;
     }
?>