<?php

$table = new PhabricatorFileImageMacro();
foreach (new LiskMigrationIterator($table) as $macro) {
  $name = $macro->getName();

  echo "Linking macro '{$name}'...\n";

  $editor = new PhabricatorEdgeEditor();

  $phids[] = $macro->getFilePHID();
  $phids[] = $macro->getAudioPHID();
  $phids = array_filter($phids);

  if ($phids) {
    foreach ($phids as $phid) {
      $editor->addEdge(
        $macro->getPHID(),
        PhabricatorObjectHasFileEdgeType::EDGECONST ,
        $phid);
    }
    $editor->save();
  }
}

echo "Done.\n";
