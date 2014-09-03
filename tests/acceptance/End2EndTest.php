<?php

class End2EndTest extends PHPUnit_Framework_TestCase
{
  function testEnvironmentIsRunning()
  {
    $this->assertTrue(true);
  }

  function testCanCreateNewTopicBuilder()
  {
    $tb = new TopicBuilder([]); 
    $this->assertNotNull($tb);
  }

  function testTopicBuilderCanBuildACompleteAlbumDownloadPage()
  {
    $tb = new TopicBuilder([ 
      "img-url"     => "http://i58.tinypic.com/2qi5i5g.jpg",
      "album-title" => "My Krazy Life [Deluxe Version]",
      "artist"      => "YG",
      "year"        => "2014",
      "relase-date" => "18 Marzo 2014",
      "label"       => "Pu\$haz Ink, CTE World, Def Jam Recordings",
      "quality"     => "mp3 320 kbps",
      "description"  => "My Krazy Life is the debut studio album by American rapper YG. The album was released on March 18, 2014, by Pu\$haz Ink, CTE World and Def Jam Recordings. Its recording process took place from 2012 to 2014 in various recording studios, mostly in Atlanta, Georgia and Los Angeles, California.",
      "tracklist"   => [
        "The Put On Intro",
        "Bpt",
        "I Just Wanna Party (Feat. ScHoolboy Q & Jay Rock)",
        "Left, Right (Feat. DJ Mustard)",
        "Bicken Back Being Bool",
        "Meet the Flockers (Feat. Tee Cee)",
        "My N***a (Feat. Jeezy & Rich Homie Quan)",
        "Do It To Ya (Feat. TeeFLii)",
      ],
      "download-link" => "https://mega.co.nz/#!SpoFBaLC!v-GOjp2ZCJMj6qCGwyrGyN-z0H0L8I6WtdOSnT0P948",
      "password"      => "shady90@downloadhunter"
    ]);

    $generated = $tb->generateTopic();
    $this->assertEquals(
      "[img]http://i58.tinypic.com/2qi5i5g.jpg[/img]

[b]Titolo[/b]: My Krazy Life [Deluxe Version]
[b]Artista[/b]: YG
[b]Anno[/b]: 2014
[b]Etichetta[/b]: Pu\$haz Ink, CTE World, Def Jam Recordings
[b]Qualità[/b]: mp3 320 kbps
[b]Data rilascio[/b]: 18 Marzo 2014

[b]Tracklist[/b]:

1. The Put On Intro
2. Bpt
3. I Just Wanna Party (Feat. ScHoolboy Q & Jay Rock)
4. Left, Right (Feat. DJ Mustard)
5. Bicken Back Being Bool
6. Meet the Flockers (Feat. Tee Cee)
7. My N***a (Feat. Jeezy & Rich Homie Quan)
8. Do It To Ya (Feat. TeeFLii)

[b]Descrizione[/b]:

My Krazy Life is the debut studio album by American rapper YG. The album was released on March 18, 2014, by Pu\$haz Ink, CTE World and Def Jam Recordings. Its recording process took place from 2012 to 2014 in various recording studios, mostly in Atlanta, Georgia and Los Angeles, California.

[b]Download[/b]:
[spoiler]Link: [url]https://mega.co.nz/#!SpoFBaLC!v-GOjp2ZCJMj6qCGwyrGyN-z0H0L8I6WtdOSnT0P948[/url]
Password: shady90@downloadhunter[/spoiler]",
      $generated
    );
  }

  function testTopicBuilderCanBuildATinyAlbumTopic()
  {
    $tb = new TopicBuilder([
      "album-title" => "Sayonara",
      "artist" => "Club Dogo",
      "year" => "2014",
      "label" => "Universal Music",
      "quality" => "m4a - iTunes",
      "download-link" => "http://adf.ly/rir0R",
    ]);

    $generated = $tb ->generateTopic();
    $this->assertEquals(
      "[b]Titolo[/b]: Sayonara
[b]Artista[/b]: Club Dogo
[b]Anno[/b]: 2014
[b]Etichetta[/b]: Universal Music
[b]Qualità[/b]: m4a - iTunes

[b]Download[/b]:
[spoiler]Link: [url]http://adf.ly/rir0R[/url][/spoiler]",
      $generated
    );
  }
}
