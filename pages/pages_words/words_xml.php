<?php
require_once ("light-site.php");
$this->bypassRender = true;
$site = new LightSite("data/word_data.php");
$categories = $site->pages->getDataArray();
$wbid = 1; // Use this to recognize updated versions of this document

header('Content-type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n\n";

    echo "<wordbase id=\"$wbid\">";

        /* List the categories */
        echo "<categories>";
            foreach ($categories as &$category)
                echo "<category categ_id=\"" . trim($category['id']) . "\">" . trim($category['title']) . "</category>\n";
        echo "</categories>";

            /* List the words of each category */
            foreach ($categories as &$category) {
                echo "\n<category-words categ_id=\"" . trim($category['id']) . "\">" . "\n";
                $wordTxt = trim($category['content'], " -\n\r\t");
                if (strlen($wordTxt)>3) {
                    $wordArr = explode("-", $wordTxt);
                    foreach ($wordArr as &$word) echo "\t<word>" . trim($word) . "</word>" . "\n";
                }
                echo "</category-words>" . "\n";
            }

    echo "</wordbase>";

?>
