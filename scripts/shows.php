<?php

class ShowsCrawler {

    private $baseUrl = "http://www.primewire.ag";
    private $pagesPerRun = 1;
    private $db;

    public function __construct() {
        $this->db = Utils\Db::getInstance();
    }

    public function parseShowPage($url) {
        $show = array();
        $show['info'] = array();
        $show['info']['genres'] = array();
        $show['info']['countries'] = array();

        $querystring = str_replace($this->baseUrl, "", $url);
        preg_match("/\/watch-(\d*)-/", $querystring, $m);
        if (isset($m[1])) {
            $show['prime_id'] = $m[1];
        }

        $html = file_get_contents($url);

        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $xpath = new DOMXPath($doc);

        $showObj = $this->db->getTable("Show")->findBy(array("prime_id" => $show['prime_id']));

        if (!$showObj) {
            $query = "//div[@class='index_container']/div/h1[@class='titles']";
            $show['title'] = trim($xpath->query($query)->item(0)->nodeValue);

            // movie info
            $query = "//div[@class='movie_info']";
            $showInfo = $xpath->query($query)->item(0);

            $descriptionList = $xpath->query("table/tr/td/p", $showInfo);
            if ($descriptionList->length) {
                $show['description'] = trim($descriptionList->item(0)->nodeValue);
            }

            $trList = $xpath->query("table/tr", $showInfo);
            if ($trList->length) {
                for ($i = 0; $i <= $trList->length; $i++) {
                    $trNode = $trList->item($i);
                    $tdNameList = $xpath->query("td[@width='70']", $trNode);

                    if (!$tdNameList->length) {
                        continue;
                    }

                    $tdName = trim($tdNameList->item(0)->nodeValue);
                    $name = strtolower(trim($tdName, ":"));
                    $tdList = $xpath->query("td", $trNode);
                    if ($tdList->length != 2) {
                        continue;
                    }

                    $tdNode = $tdList->item(1);
                    $subValueList = $xpath->query("span/a", $tdNode);
                    if ($subValueList->length) {
                        $value = array();
                        for ($j = 0; $j < $subValueList->length; $j++) {
                            $value[] = strip_tags(trim($subValueList->item($j)->nodeValue));
                        }
                    } else {
                        $value = strip_tags(trim($tdNode->nodeValue));
                    }


                    $show['info'][$name] = $value;
                }
            }

            $query = "//div[@class='mlink_imdb']/a";
            $imdbLinkList = $xpath->query($query);
            if ($imdbLinkList->length) {
                $show['imdb_link'] = $imdbLinkList->item(0)->getAttribute('href');
            }

            // saving to db
            $this->db->em->getConnection()->beginTransaction();

            $showObj = new Entity\Show;
            $showObj->prime_id = $show['prime_id'];
            $showObj->title = $show['title'];
            $showObj->description = (isset($show['description']) ? $show['description'] : "");
            $showObj->released = (isset($show['info']['released']) ? $show['info']['released'] : "");
            $showObj->imdb_link = (isset($show['imdb_link']) ? $show['imdb_link'] : "");
            $this->db->em->persist($showObj);
            $this->db->em->flush();

            if (is_array($show['info']['genres'])) {
                foreach ($show['info']['genres'] as $genre) {
                    $genreObjAr = $this->db->getTable("Genre")->findBy(array("name" => $genre));
                    if (!count($genreObjAr)) {
                        $genreObj = new Entity\Genre();
                        $genreObj->name = $genre;
                        $this->db->em->persist($genreObj);
                        $this->db->em->flush();
                    } else {
                        $genreObj = current($genreObjAr);
                    }

                    $showGenreObj = new Entity\ShowGenre();
                    $showGenreObj->show = $showObj;
                    $showGenreObj->genre = $genreObj;
                    $this->db->em->persist($showGenreObj);
                    $this->db->em->flush();
                }
            }


            if (is_array($show['info']['countries'])) {
                foreach ($show['info']['countries'] as $country) {
                    $countryObjAr = $this->db->getTable("Country")->findBy(array("name" => $country));
                    if (!count($countryObjAr)) {
                        $countryObj = new Entity\Country;
                        $countryObj->name = $country;
                        $this->db->em->persist($countryObj);
                        $this->db->em->flush();
                    } else {
                        $countryObj = current($countryObjAr);
                    }

                    $showCountryObj = new Entity\ShowCountry();
                    $showCountryObj->movie = $showObj;
                    $showCountryObj->country = $countryObj;
                    $this->db->em->persist($showCountryObj);
                    $this->db->em->flush();
                }
            }

            $this->db->em->getConnection()->commit();
        }

        // go through episodes
        $query = "//div[@id='first']/div[@class='tv_container']";
        $showLinkTableList = $xpath->query($query);
        for ($i = 0; $i < $showLinkTableList->length; $i++) {
            $curNode = $showLinkTableList->item($i);
            $episodeLinkList = $xpath->query("div[@class='tv_episode_item']/a", $curNode);
            for ($j = 0; $j < $episodeLinkList->length; $j++) {
                $curEpisodeLink = $episodeLinkList->item($j)->getAttribute('href');
                $link = $this->baseUrl . $curEpisodeLink;
                $ret = $this->parseEpisodePage($link, $showObj);
            }
        }
    }

    public function parseEpisodePage($url, $showObj) {
        $episode = array();
        $episode['links'] = array();
        $episode['info'] = array();
        $episode['info']['genres'] = array();
        $episode['info']['countries'] = array();

        $querystring = str_replace($this->baseUrl, "", $url);
        preg_match("/\/season-(\d*)-episode-(\d*)/", $querystring, $m);
        if (count($m) != 3) {
            return false;
        }

        $episode['season'] = $m[1];
        $episode['episode'] = $m[2];

        $html = file_get_contents($url);

        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $xpath = new DOMXPath($doc);

        // movie info
        $query = "//div[@class='movie_info']";
        $episodeInfo = $xpath->query($query)->item(0);

        $descriptionList = $xpath->query("table/tr/td/p", $episodeInfo);
        if ($descriptionList->length) {
            $episode['description'] = trim($descriptionList->item(0)->nodeValue);
        }

        $trList = $xpath->query("table/tr", $episodeInfo);
        if ($trList->length) {
            for ($i = 0; $i <= $trList->length; $i++) {
                $trNode = $trList->item($i);
                $tdNameList = $xpath->query("td[@width='70']", $trNode);

                if (!$tdNameList->length) {
                    continue;
                }

                $tdName = trim($tdNameList->item(0)->nodeValue);
                $name = strtolower(trim($tdName, ":"));
                $tdList = $xpath->query("td", $trNode);
                if ($tdList->length != 2) {
                    continue;
                }

                $tdNode = $tdList->item(1);
                $subValueList = $xpath->query("span/a", $tdNode);
                if ($subValueList->length) {
                    $value = array();
                    for ($j = 0; $j < $subValueList->length; $j++) {
                        $value[] = strip_tags(trim($subValueList->item($j)->nodeValue));
                    }
                } else {
                    $value = strip_tags(trim($tdNode->nodeValue));
                }


                $episode['info'][$name] = $value;
            }
        }

        // movie links
        //$query = "//div[@id='first']/table[contains(@class,'movie_version')]";
        $query = "//div[@id='first']/table";
        $episodeLinkTableList = $xpath->query($query);
        //print $episodeLinkTableList->length; die;
        for ($i = 0; $i < $episodeLinkTableList->length; $i++) {
            $curNode = $episodeLinkTableList->item($i);
            $versionList = $xpath->query("tbody/tr/td/span[@class='version_host']/script", $curNode);
            if (!$versionList->length) {
                continue;
            }

            preg_match("/\('([^']*)'\)/", trim($versionList->item(0)->nodeValue), $m);
            $version = '';
            if (isset($m[1])) {
                $version = $m[1];
                if ($version == 'HD Sponsor') {
                    continue;
                }
            } else {
                if (strstr(trim($versionList->item(0)->nodeValue), 'HD Sponsor')) {
                    continue;
                }
            }

            $linkList = $xpath->query("tbody/tr/td/span[@class='movie_version_link']/a", $curNode);

            if ($linkList->length) {
                $link = $this->baseUrl . $linkList->item(0)->getAttribute('href');
                $episode['links'][] = array('url' => $link, 'version' => $version);
            }
        }

        $this->db->em->getConnection()->beginTransaction();

        $episodeObj = new Entity\ShowEpisode();
        $episodeObj->season = $episode['season'];
        $episodeObj->episode = $episode['episode'];
        $episodeObj->title = (isset($episode['info']['title']) ? $episode['info']['title'] : "");
        $episodeObj->description = (isset($episode['description']) ? $episode['description'] : "");
        $episodeObj->air_date = (isset($episode['info']['air date']) ? $episode['info']['air date'] : "");
        $episodeObj->show = $showObj;
        $this->db->em->persist($episodeObj);
        $this->db->em->flush();
        
        foreach ($episode['links'] as $link) {
            $linkObj = new Entity\EpisodeLink();
            $linkObj->episode = $episodeObj;
            $linkObj->link = $link['url'];
            $linkObj->version = $link['version'];
            $this->db->em->persist($linkObj);
            $this->db->em->flush();
        }
        
        $this->db->em->getConnection()->commit();
        
        return $episode;
    }

    public function parseShowsPage() {
        $statusObj = $this->db->getTable("CrawlerStatus")->find(2);
        $page = $statusObj->page + 1;
        for ($i = $page; $i < $page + $this->pagesPerRun; $i++) {
            echo "parsing page " . $i . "\n";
            $url = $this->baseUrl . "/?tv=&sort=views&page=" . $i;
            $html = file_get_contents($url);
            $doc = new DOMDocument();
            @$doc->loadHTML($html);
            $xpath = new DOMXPath($doc);
            $query = "//div[@class='index_item index_item_ie']";
            $resultsList = $xpath->query($query);
            for ($j = 0; $j < $resultsList->length; $j++) {
                $curNode = $resultsList->item($j);
                $linkNode = $xpath->query("a", $curNode)->item(0);
                $link = $this->baseUrl . $linkNode->getAttribute('href');

                $ret = $this->parseShowPage($link);
                if ($ret) {
                    echo "saved: " . $ret['title'] . "\n";
                } else {
                    echo "movie wasn't saved\n";
                }
            }
        }
        $statusObj->page = $i - 1;
        $this->db->em->persist($statusObj);
        $this->db->em->flush();
    }

}

$crawler = new ShowsCrawler();
$crawler->parseShowsPage();