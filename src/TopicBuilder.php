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
    $this->addDownloadLinks();
    $this->removeLastNewLineIfEmpty();

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

  private function addDownloadLinks()
  {
    foreach($this->fields["download-links"] as $link)
    {
      $label = $link[0];
      $url = $link[1];
      $password = count($link) > 2 ? $link[2] : null;
      
      $this->addTextToTopic("[b]".$label."[/b]:");
      $this->addNewLine();
      
      $this->addTextToTopic("[spoiler]");
      $this->addTextToTopic("Link: [url]".$url."[/url]");
      
      if($password != null) {
        $this->addNewLine();
        $this->addTextToTopic("Password: $password");
      }

      $this->addTextToTopic("[/spoiler]"); 
      $this->addNewLine();
    }
  }

  private function addTextToTopic($text)
  {
    $this->topic .= $text;
  }

  private function removeLastNewLineIfEmpty()
  {
    $topic_len  = strlen($this->topic);
    $eol_len    = strlen(self::EOLSTRING);
    
    if(substr($this->topic, -($eol_len)) === self::EOLSTRING)
      $this->topic = substr($this->topic, 0, $topic_len-$eol_len);
  }
  
  private function issetAndNotEmpty($array, $label)
  {
    return isset($array[$label]) && $array[$label] != null && $array[$label] != '';
  }
}
