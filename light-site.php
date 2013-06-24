<?php

class LightSite {

    protected $dataFileName;
    public $pages;

    public function __construct ($filename) {
        $this->dataFileName = $filename;
        $this->pages = new Pages($this->dataFileName);
    }

}

class LightSiteAdmin extends LightSite {

    protected $form, $actionUrl, $newPageTitle, $newPageID, $pagesFieldset;

    public function __construct($filename){
        parent::__construct($filename);
        $this->pages->setEditable(true);
        require_once 'HTML/QuickForm2.php';
    }
    private function addPageToForm(&$title,  &$id, &$content){
        $group = $this->pagesFieldset->addElement('group', "page_".$id);
        $group->appendChild(HTML_QuickForm2_Factory::createElement('text', 'title', array('size' => 30, 'maxlength' => 30))->setValue($title));
        $group->appendChild(HTML_QuickForm2_Factory::createElement('text', 'id', array('size' => 30, 'maxlength' => 30))->setValue($id));
        $group->appendChild(HTML_QuickForm2_Factory::createElement('checkbox', 'delete', array('class' => 'deleteCheckbox')));
        $group->appendChild(HTML_QuickForm2_Factory::createElement('textarea', 'content', array('size' => 50, 'maxlength' => 5000 ))->setValue($content));
    }
    public function createForm($actionUrl){
        /* Create the form object */
        $this->actionUrl = $actionUrl;
        $this->form = new HTML_Quickform2('wordEditForm', 'post', array('action' => $actionUrl));

        /* Create the fieldset for new page */
        $fieldset = $this->form->addElement('fieldset', ' ', array('class' => 'newPageFieldset'))->setLabel('Νέα κατηγορία');
        $this->newPageTitle = $fieldset->addElement('text', 'newPage')->setLabel('Τίτλος Νέας Σελίδας');
        $this->newPageID = $fieldset->addElement('text', 'newPageID')->setLabel('Κωδικό Όνομα Νέας Σελίδας');

        /* Create the fieldset with the categories */
        $this->pagesFieldset = $this->form->addElement('fieldset')->setLabel('Επεξεργασία σελίδων');
        foreach($this->pages->getDataArray() as $key=>$page) {
            $this->addPageToForm($page['title'], $page['id'], $page['content']);
        }

        /* Add the submit button */
        $this->form->addElement('submit', null, array('value' => 'Καταχώρηση Αλλαγών', 'class' => 'submitButton' ));
    }
    public function handleForm($perm=false){
        if ( !$this->form->isSubmitted() ) return;
        if ( !isset($this->form) ) $this->createForm();

        /* Read new page data */
        $newPageDataArray = array();
        foreach($this->pagesFieldset->getElements() as $e) {
            if($e->getType()!='group') continue; // Skip any non-group elements
            $group = $e->getElements();
            if ($group[2]->getValue()) continue; // if user checked delete checkbox we discard this page by not adding it to the new dataArray

            $pageTitle = $group[0]->getValue();
            $pageId = $group[1]->getValue();
            $pageContent = $group[3]->getValue();

            array_push( $newPageDataArray, array('title' => $pageTitle, 'id' => $pageId, 'content' => str_replace("\n", "-", $pageContent)));
        }

        /* Add the new page if there is one */
        if ( ($nt = $this->newPageTitle->getValue()) != "" &&
             ($nid = $this->newPageID->getValue()) != "")
        {
            $ncont = "";
            array_push( $newPageDataArray, array('title' => $nt, 'id' => $nid , 'content' => $ncont));
            $this->addPageToForm($nt, $nid, $ncont); // After proccessing tha new data the page is redirected so that new Page appears in the form
        }

        $this->pages->setDataArray($newPageDataArray);
        if ($perm) $this->saveData();
        header("location: ". $this->actionUrl);
    }
    public function printForm(){
        echo $this->form;
    }
    public function saveData(){
        $exp_data = $this->pages->exportData();
        if ($exp_data == NULL) return false;

        ob_start();
        echo $exp_data;
        $str = ob_get_clean();
        return file_put_contents($this->dataFileName, "<?php\n\n".$str);
    }

}

class Pages {

    protected $pageDataArray, $read_only;

    public function __construct($flnm){
        $this->read_only = true;
        require($flnm);
        $this->pageDataArray = $pageData;
    }

    /* Methods for READING */
    public function setEditable($val){
        if ( !is_bool($val) ) return false;
        $this->read_only = !$val;
        return true;
    }
    public function getDataArray(){
        return $this->pageDataArray;
    }
    public function getPageTitles(){
        $pageDataArray = array();
        foreach ( $this->pageDataArray as &$page )
            $pageDataArray[] = $page['title'];

        return $pageDataArray;
    }
    public function getContentByTitle($title){
        foreach( $this->pageDataArray as &$page)
            if ($page['title'] == $title) return $page['content'];

        return false;
    }
    public function getDefaultTitle(){
        if(count($this->pageDataArray) != 0)
            return $this->pageDataArray[0]['title'];
        return false;
    }
    public function getDefaultContent(){
        if(count($this->pageDataArray) != 0)
            return $this->pageDataArray[0]['content'];
        return false;
    }

    /* Methods for EDITING */
    public function addPage($title, $content){
        //array_push($this->pageDataArray, array('title' => $title, 'content' => $content));
        $this->pageDataArray[] =  array('title' => $title, 'content' => $content);
    }
    public function setTitle($oldTitle, $newTitle) {
        foreach( $this->pageDataArray as &$page){
            if ($page['title'] == $oldTitle) {
                $page['title'] = $newTitle;
                return;
            }
        }
        return false;
    }
    public function setContent($title, $newContent) {
        foreach( $this->pageDataArray as &$page){
            if ($page['title'] == $title) {
                $page['content'] = $newContent;
                return;
            }
        }
        return false;
    }
    public function setDataArray($newData){
        $this->pageDataArray = $newData;
    }
    public function exportData(){
        if ($this->read_only) return NULL;

        if(!isset( $this->pageDataArray ))
            return false;
        else {
            $ret = var_export($this->pageDataArray, true);
            if ($ret) return "\$pageData = ".$ret.";\n\n";
            else return false;
        }
    }

}
