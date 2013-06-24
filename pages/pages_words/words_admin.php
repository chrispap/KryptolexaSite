<?php
$this->headerTitle = "Διαχείριση λέξεων";
$this->contentTitle = "Διαχείριση λέξεων";
$this->headerSubtext = "Όλες οι κατηγορίες";

$Words = new LightSiteAdmin($this->config['datafile']);
$Words->createForm($this->FULL_PATH);
$Words->handleForm($this->admin);
$Words->printForm();
