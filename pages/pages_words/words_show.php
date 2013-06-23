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
if ($this->userid) {
    $this->headerSubtext = "<a href=\"". $this->PATH."words/edit/".$wordCateg ."\" >Επεξεργασία</a>";
    if ($this->admin) $this->headerSubtext = $this->headerSubtext . "<br/><a href=\"". $this->PATH.'words/admin' ."\" >Admin</a>";

}

/* Create the Menu */
echo "<div class='wordMenu' >";
$menuItems = $Words->pages->getPageTitles();
foreach ($menuItems as &$menuItem ) {
    if ($wordCateg == $menuItem )
        echo "<div class='wordMenuItem'><a style='font-weight: bold; text-decoration:underline;' href='" . $this->PATH . "words/$menuItem'> $menuItem </a></div>";
    else
        echo "<div class='wordMenuItem'><a href='" . $this->PATH ."words/$menuItem'> $menuItem </a></div>";
}
echo "</div>";

/* Output the Content */
echo $content;
