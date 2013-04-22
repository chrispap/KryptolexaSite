<?php
$this->contentTitle = "Κρυπτόλεξα";
$this->headerTitle = "Κεντρική";

$this->menuItems = array(
    $this->PATH.'screenshots' => "ΣΤΙΓΜΙΟΤΥΠΑ",
    $this->PATH.'words' => "ΛΕΞΕΙΣ",

);

if ($this->admin) $this->headerSubtext = "<a href=\"". $this->PATH.'words/admin' ."\" > Admin </a>";

foreach ($this->menuItems as $href=>$text ) {
    $this->menuCapture .= "<div class='topNavigationLink'><a href='$href'>$text</a></div>\n";
}

?>

<div class="entry">

    <div class="rightfloat">
        <img src="<?php echo $this->IMAGE_PATH; ?>kryptolexo-screenshot-device.png" border="0" onclick="showImage(this.src);" >
        <img src="<?php echo $this->IMAGE_PATH; ?>kryptolexo-screenshot2.png" border="0" onclick="showImage(this.src);" >
        <img src="<?php echo $this->IMAGE_PATH; ?>kryptolexo-screenshot3.jpg" border="0" onclick="showImage(this.src);" >
    </div>

    <p class=MsoNormal>Το γνωστό παιχνίδι <i style='mso-bidi-font-style:normal'>κρυπτόλεξο</i>
    υλοποιημένο για Android συσκευές.<br>
    Σκοπός είναι να βρεθούν οι κρυμμένες λέξεις ανάμεσα στα ανακατεμένα γράμματα.<br>
    Υπάρχουν διάφορες κατηγορίες λέξεων, καθώς και τρία επίπεδα δυσκολίας.</p>

    <p class=MsoNormal>Η εφαρμογή αυτή έχει βραβευτεί σε Πανελλήνιο διαγωνισμό που
    διοργανώθηκε από την <span lang=EN-US style='mso-ansi-language:EN-US'>HTC</span>
    <b> κερδίζωντας την 2<sup>η</sup> θέση </b> στην κατηγορία παιχνίδια.</p>

    <div class="links" >
        <ul>
            <li><a href="https://play.google.com/store/apps/details?id=chris.kryptolexa"><img alt="Get it on Google Play" src="https://developer.android.com/images/brand/el_generic_rgb_wo_45.png" /></a></li>
        <ul>
    </div>

</div>
