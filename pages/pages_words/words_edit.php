<?php
/* Handle the FORM */
if (isset($_POST['formSubmitted'])) {
    if ($this->userid )
    {
        $Words = new LightSiteAdmin($this->config['datafile']);
        $Words->pages->setContent($_POST['oldPageTitle'],  trim($_POST['newPageContent'], " -\n\r\t"));
        $Words->pages->setTitle($_POST['oldPageTitle'], $_POST['newPageTitle']);
        $Words->saveData();
    }
    header("location: ". $this->FULL_PATH);
    return;
}

/* Find the category */
$Words = new LightSite($this->config['datafile']);
$wordCateg = $this->p3;
$wordContent = $Words->pages->getContentByTitle($wordCateg);
if ( $wordContent === false ) {
    $wordCateg = $Words->pages->getDefaultTitle();
    $wordContent = $Words->pages->getDefaultContent();
}

/* Create the Page */
$this->headerTitle = "Επεξεργασία Κατηγορίας";
$this->contentTitle = $wordCateg;
$this->headerSubtext = "<a href=\"". $this->PATH . "words/" . $wordCateg ."\" > Τέλος Επεξεργασίας </a>";

/* Create the Menu */
echo "<div class='wordMenu' >";
$menuItems = $Words->pages->getPageTitles();
foreach ($menuItems as &$menuItem ) {
    if ($wordCateg == $menuItem )
        echo "<div class='wordMenuItem'><a style='font-weight: bold; text-decoration:underline;' href='" . $this->PATH . "words/edit/$menuItem'> $menuItem </a></div>";
    else
        echo "<div class='wordMenuItem'><a href='" . $this->PATH ."words/edit/$menuItem'> $menuItem </a></div>";
}
echo "</div>";

/* Output the Content */
$num_lines = substr_count($wordContent, "\n");
echo(
    "<form method=\"post\" action=\"" .$this->FULL_PATH. "\" >"
        . "<input type=\"hidden\" name=\"formSubmitted\" value=\"1\" >"
        . "<input type=\"hidden\" name=\"oldPageTitle\" value=\"$wordCateg\" >"
        . "<input type='text' name ='newPageTitle' value='$wordCateg' />"
        . "<br/>"
        . "<textarea name=\"newPageContent\" rows=\"$num_lines\" >$wordContent</textarea>"
        . "<br/>"
        . "<input type='submit' value='Αποθήκευση Αλλαγών' name='submit' class='submitButton' />"
        . (isset($this->userid)? "" : "<em style=\"color: #DD0000;\"> Οι αλλαγές που θα κάνετε δεν θα αποθηκευτούν διότι δεν είστε συνδεδεμένος. </em>")
    . "</form>"
);
