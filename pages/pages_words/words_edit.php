<?php
/* Handle the FORM */
if (isset($_POST['formSubmitted'])){
    $Words = new LightSiteAdmin($this->config['datafile']);
    $Words->pages->setContent($_POST['oldPageTitle'],  trim($_POST['newPageContent'], " -\n\r\t"));
    $Words->pages->setTitle($_POST['oldPageTitle'], $_POST['newPageTitle']);
    $Words->saveData();
    header("location: ". $this->makePath(array("words", $this->p3)));
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
$this->menuCapture = "";
$this->menuItems = $Words->pages->getPageTitles();
foreach ($this->menuItems as &$menuItem ) {
    $ed = "/edit";
    if ($wordCateg == $menuItem )
        $this->menuCapture .= "<div class='topNavigationLink'><a style='font-weight: bold; text-decoration:underline;' href='" . $this->PATH . "words/edit/$menuItem'> $menuItem </a></div>\n";
    else
        $this->menuCapture .= "<div class='topNavigationLink'><a href='" . $this->PATH ."words/edit/$menuItem'> $menuItem </a></div>\n";
}

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
    . "</form>"
);
