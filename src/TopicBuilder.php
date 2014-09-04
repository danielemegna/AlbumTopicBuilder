<?php

class TopicBuilder
{
  const EOLSTRING = "\n";

  private $topic;
  private $fields;
  
  function __construct($fields)
  {
    $this->topic = "";
    $this->fields = $fields;
  }

  function generateTopic()
  {
    $this->addImageIfSetted();
    $this->addSettedOnelineInfos();
    $this->addTracklist();
    $this->addDescriptionIfSetted();
    $this->addSpoilerElements(
    [
      "download-link" => ["Link: [url]", "[/url]"],
      "password" => ["Password: "]
    ],
    "[b]Download[/b]:");

    return $this->topic;
  }

  private function addImageIfSetted()
  {
    $this->addFieldIfSetted("img-url", "[img]", "[/img]".self::EOLSTRING);
  }

  private function addSettedOnelineInfos()
  {
    $this->addFieldIfSetted("album-title", "[b]Titolo[/b]: ");
    $this->addFieldIfSetted("artist", "[b]Artista[/b]: ");
    $this->addFieldIfSetted("year", "[b]Anno[/b]: ");
    $this->addFieldIfSetted("label", "[b]Etichetta[/b]: ");
    $this->addFieldIfSetted("quality", "[b]Qualità[/b]: ");
    $this->addFieldIfSetted("relase-date", "[b]Data rilascio[/b]: ");
    $this->addNewLine(); 
  }

  private function addDescriptionIfSetted()
  {
    $this->addFieldIfSetted(
      "description",
      "[b]Descrizione[/b]:".self::EOLSTRING.self::EOLSTRING,
      self::EOLSTRING
    );
  }

  private function addFieldIfSetted($elementlabel, $prefix, $suffix = "")
  {
    if($this->issetAndNotEmpty($this->fields, $elementlabel)) {
      $this->addTextToTopic($prefix.$this->fields[$elementlabel].$suffix);
      $this->addNewLine(); 
    }
  }
  
  private function addNewLine()
  {
    $this->addTextToTopic(self::EOLSTRING);
  }

  private function addTextToTopic($text)
  {
    $this->topic .= $text;
  }

  private function addTracklist($elementlabel = "tracklist", $prefix = "[b]Tracklist[/b]:")
  {
    if($this->issetAndNotEmpty($this->fields, $elementlabel)) {
      $this->addTextToTopic($prefix);
      $this->addNewLine(); 

      $n = 1;
      foreach($this->fields[$elementlabel] as $track) {
        $this->addNewLine(); 
        $this->addTextToTopic($n++.". ".$track);
      }
      $this->addNewLine(); 
      $this->addNewLine(); 
    }
  }

  private function addSpoilerElements($elements, $spoilerprefix)
  {
    $this->addTextToTopic("$spoilerprefix");
    $this->addNewLine();
    $this->addTextToTopic("[spoiler]");
    
    $sep = "";
    foreach($elements as $label => $xfix) {
      $prefix = count($xfix) > 0 ? $xfix[0] : "";
      $suffix = count($xfix) > 1 ? $xfix[1] : "";
      if($this->issetAndNotEmpty($this->fields, $label)) {
        $this->addTextToTopic($sep);
        $this->addTextToTopic(
          $prefix.
          $this->fields[$label].
          $suffix
        );
        $sep = self::EOLSTRING;
      }
    }

    $this->addTextToTopic("[/spoiler]"); 
  }

  private function issetAndNotEmpty($array, $label)
  {
    return isset($array[$label]) && $array[$label] != null && $array[$label] != '';
  }
}
