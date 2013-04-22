<?php
require_once ("light-site.php");

if ($this->p2 == "admin" && $this->admin)
{
    include("pages/pages_words/words_admin.php");
}

else if ($this->p2 == "edit" && $this->userid)
{
    include("pages/pages_words/words_edit.php");
}

else if ($this->p2 == "xml")
{
    include "pages/pages_words/words_xml.php";
}

else
{
    include("pages/pages_words/words_show.php");
}
