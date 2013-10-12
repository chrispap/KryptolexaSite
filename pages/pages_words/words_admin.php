<?php
$this->headerTitle = "Διαχείριση λέξεων";
$this->contentTitle = "Διαχείριση λέξεων";
$this->headerSubtext = "Όλες οι κατηγορίες";

$Words = new LightSiteAdmin($this->config['datafile']);
$Words->createForm($this->FULL_PATH);
$Words->handleForm($this->admin);
$Words->printForm();

if (!isset($this->userid)) echo "<em style=\"color: #DD0000;\"> Οι αλλαγές που θα κάνετε δεν θα αποθηκευτούν διότι δεν είστε συνδεδεμένος. </em>";
else if (!$this->admin)    echo "<em style=\"color: #DD0000;\"> Οι αλλαγές που θα κάνετε δεν θα αποθηκευτούν διότι δεν είστε admininstrator. </em>";

