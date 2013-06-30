<?php
$this->contentTitle = "Κρυπτόλεξα";
$this->headerTitle = "Κεντρική";
?>

<div class="entry">

    <div class="rightfloat">
        <img src="<?php echo $this->IMAGE_PATH; ?>kryptolexo-screenshot-device.png" border="0" onclick="showImage(this.src);" >
        <img src="<?php echo $this->IMAGE_PATH; ?>kryptolexo-screenshot2.png" border="0" onclick="showImage(this.src);" >
        <img src="<?php echo $this->IMAGE_PATH; ?>kryptolexo-screenshot3.jpg" border="0" onclick="showImage(this.src);" >
    </div>

    <div id="typeWriterPar" style="display: none;" >
    <p>Το γνωστό παιχνίδι <i style='mso-bidi-font-style:normal'>κρυπτόλεξο</i>
    υλοποιημένο για Android συσκευές. Σκοπός είναι να βρεθούν οι κρυμμένες λέξεις ανάμεσα στα ανακατεμένα γράμματα.
    Υπάρχουν διάφορες κατηγορίες λέξεων, καθώς και τρία επίπεδα δυσκολίας.</p>

    <p>Η εφαρμογή αυτή έχει βραβευτεί σε Πανελλήνιο διαγωνισμό που
    διοργανώθηκε από την <span lang=EN-US style='mso-ansi-language:EN-US'>HTC</span>
    <b> κερδίζωντας την 2<sup>η</sup> θέση </b> στην κατηγορία παιχνίδια.</p>

    <div class="links" >
        <p> Μπορείτε να την κατεβάσετε <em>δωρεάν</em> απο το Google Play :D <i class="icon-arrow-right"></i>
            <a style="float: right;" href="https://play.google.com/store/apps/details?id=chris.kryptolexa">
                <img alt="Get it on Google Play" src="https://developer.android.com/images/brand/el_generic_rgb_wo_45.png" />
            </a>
        </p>
    </div>

    </div>

</div>

<script type="text/javascript">
    $("#typeWriterPar").delay(200).typewriter();
</script>
