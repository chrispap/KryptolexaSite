<?php
/* Find the category */
$Words = new LightSite($this->config['datafile']);
$wordCateg = $this->p2;
$wordContent = $Words->pages->getContentByTitle($wordCateg);
if ( $wordContent === false ) {
    $wordCateg = $Words->pages->getDefaultTitle();
    $wordContent = $Words->pages->getDefaultContent();
}

/* Create the Page */
$this->headerTitle = "Προβολή Κατηγορίας";
$this->contentTitle = $wordCateg;
$content = $wordContent;
if ($this->userid)
    $this->headerSubtext = "<a href=\"". $this->PATH."words/edit/".$wordCateg ."\" > Επεξεργασία </a>";

/* Create the Menu */
$this->menuCapture = "";
$this->menuItems = $Words->pages->getPageTitles();
foreach ($this->menuItems as &$menuItem ) {
    if ($wordCateg == $menuItem )
        $this->menuCapture .= "<div class='topNavigationLink'><a style='font-weight: bold; text-decoration:underline;' href='" . $this->PATH . "words/$menuItem'> $menuItem </a></div>\n";
    else
        $this->menuCapture .= "<div class='topNavigationLink'><a href='" . $this->PATH ."words/$menuItem'> $menuItem </a></div>\n";
}

/* Output the Content */
echo $content;
