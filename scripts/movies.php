<?php

class MoviesCrawler {

    private $baseUrl = "http://www.primewire.ag";
    private $pagesPerRun = 5;
    private $db;
    public $flag = array();

    public function __construct() {
        $this->db = Utils\Db::getInstance();
        $this->flag['update'] = 0;
    }

    public function parseMoviePage($url) {
        $movie = array();
        $movie['links'] = array();
        $movie['info'] = array();
        $movie['info']['genres'] = array();
        $movie['info']['countries'] = array();
        $updating = 0;
        // saving to db
        $this->db->em->getConnection()->beginTransaction();

        $querystring = str_replace($this->baseUrl, "", $url);
        preg_match("/\/watch-(\d*)-/", $querystring, $m);
        if (isset($m[1])) {
            $movie['prime_id'] = $m[1];
        }

        $rec = $this->db->getTable("Movie")->findBy(array("prime_id" => $movie['prime_id']));
        if (count($rec)) {
            if ($this->flag['update']) {
                $updating = 1;
                $existingMovieObj = current($rec);
                $this->db->em->remove($existingMovieObj);
                $this->db->em->flush();
            } else {
                return 1;
            }
        }


        //$html = file_get_contents($url);
        $html = $this->getContent($url);
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $xpath = new DOMXPath($doc);

        $query = "//div[@class='index_container']/div/h1[@class='titles']";
        $movie['title'] = trim($xpath->query($query)->item(0)->nodeValue);

        // movie info
        $query = "//div[@class='movie_info']";
        $movieInfo = $xpath->query($query)->item(0);

        $descriptionList = $xpath->query("table/tr/td/p", $movieInfo);
        if ($descriptionList->length) {
            $movie['description'] = trim($descriptionList->item(0)->nodeValue);
        }

        $trList = $xpath->query("table/tr", $movieInfo);
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


                $movie['info'][$name] = $value;
            }
        }

        // movie links
        //$query = "//div[@id='first']/table[contains(@class,'movie_version')]";
        $query = "//div[@id='first']/table";
        $movieLinkTableList = $xpath->query($query);
        //print $movieLinkTableList->length; die;
        for ($i = 0; $i < $movieLinkTableList->length; $i++) {
            $curNode = $movieLinkTableList->item($i);
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
                $movie['links'][] = array('url' => $link, 'version' => $version);
            }
        }

        $query = "//div[@class='mlink_imdb']/a";
        $imdbLinkList = $xpath->query($query);
        if ($imdbLinkList->length) {
            $movie['imdb_link'] = $imdbLinkList->item(0)->getAttribute('href');
        }

        if (!isset($movie['title'])) {
            return 2;
        }


        $movieObj = new Entity\Movie;
        $movieObj->prime_id = $movie['prime_id'];
        $movieObj->title = $movie['title'];
        $movieObj->description = (isset($movie['description']) ? $movie['description'] : "");
        $movieObj->released = (isset($movie['info']['released']) ? $movie['info']['released'] : "");
        $movieObj->runtime = (isset($movie['info']['runtime']) ? $movie['info']['runtime'] : "");
        $movieObj->imdb_link = (isset($movie['imdb_link']) ? $movie['imdb_link'] : "");
        if ($updating) {
            echo "updating: " . $movieObj->title . "\n";
            $movieObj->updated_on = new \DateTime(date("Y-m-d H:i:s"));
        }
        $this->db->em->persist($movieObj);
        $this->db->em->flush();

        foreach ($movie['links'] as $link) {
            $linkObj = new Entity\MovieLink();
            $linkObj->movie = $movieObj;
            $linkObj->link = $link['url'];
            $linkObj->version = $link['version'];
            $this->db->em->persist($linkObj);
            $this->db->em->flush();
        }

        if (is_array($movie['info']['genres'])) {
            foreach ($movie['info']['genres'] as $genre) {
                $genreObjAr = $this->db->getTable("Genre")->findBy(array("name" => $genre));
                if (!count($genreObjAr)) {
                    $genreObj = new Entity\Genre();
                    $genreObj->name = $genre;
                    $this->db->em->persist($genreObj);
                    $this->db->em->flush();
                } else {
                    $genreObj = current($genreObjAr);
                }

                $movieGenreObj = new Entity\MovieGenre();
                $movieGenreObj->movie = $movieObj;
                $movieGenreObj->genre = $genreObj;
                $this->db->em->persist($movieGenreObj);
                $this->db->em->flush();
            }
        }


        if (is_array($movie['info']['countries'])) {
            foreach ($movie['info']['countries'] as $country) {
                $countryObjAr = $this->db->getTable("Country")->findBy(array("name" => $country));
                if (!count($countryObjAr)) {
                    $countryObj = new Entity\Country;
                    $countryObj->name = $country;
                    $this->db->em->persist($countryObj);
                    $this->db->em->flush();
                } else {
                    $countryObj = current($countryObjAr);
                }

                $movieCountryObj = new Entity\MovieCountry();
                $movieCountryObj->movie = $movieObj;
                $movieCountryObj->country = $countryObj;
                $this->db->em->persist($movieCountryObj);
                $this->db->em->flush();
            }
        }

        $this->db->em->getConnection()->commit();

        return $movie;
    }

    public function parseMoviesPage() {
        if ($this->flag['update']) {
            $page = 1;
            $toPage = (isset($this->flag['num_pages']) ? $this->flag['num_pages'] : 1);
        } else {
            $statusObj = $this->db->getTable("CrawlerStatus")->find(1);
            $page = $statusObj->page + 1;
            $toPage = $page + $this->pagesPerRun;
        }
        for ($i = $page; $i < $toPage; $i++) {
            echo "parsing page " . $i . "\n";
            if ($this->flag['update']) {
                $url = $this->baseUrl . "/?page=" . $i;
            } else {
                $url = $this->baseUrl . "/?sort=alphabet&page=" . $i;
            }
            //$html = file_get_contents($url);
            $html = $this->getContent($url);
            $doc = new DOMDocument();
            @$doc->loadHTML($html);
            $xpath = new DOMXPath($doc);
            $query = "//div[@class='index_item index_item_ie']";
            $resultsList = $xpath->query($query);
            if (!$resultsList->length) {
                echo "Probably we were banned again. Call Yuri\n\n";
            }
            for ($j = 0; $j < $resultsList->length; $j++) {
                $curNode = $resultsList->item($j);
                $linkNode = $xpath->query("a", $curNode)->item(0);
                $link = $this->baseUrl . $linkNode->getAttribute('href');
                $ret = $this->parseMoviePage($link);

                if (is_array($ret)) {
                    echo "saved: " . $ret['title'] . "\n";
                } else {
                    switch ($ret) {
                        case 1:
                            echo "link " . $link . " already exists\n";
                            break;
                        case 2:
                            echo "couldn't parse title of link " . $link . "\n";
                            break;
                        default:
                            echo "movie wasn't saved of link " . $link . "\n";
                            break;
                    }
                }
            }
        }
        $statusObj->page = $i - 1;
        $this->db->em->persist($statusObj);
        $this->db->em->flush();
        echo "Job finished\n";
    }

    private function getContent($url) {
        /*
          ob_start();
          system("wget -qO- '".$url."'");
          $content = ob_get_clean();
          //p($content); die;
          //print $content; die;
          //print substr($content,0,200); die;
         */

        $data = array();

        $version = rand(5, 40) . "." . rand(0, 9);
        $headers = array(
            'Content-type: application/x-www-form-urlencoded',
            'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:12.0) Gecko/20100101 Firefox/' . $version,
        );

        $context = stream_context_create(array
            (
            'http' => array(
                'method' => 'GET',
                'header' => $headers,
                'content' => http_build_query($data)
            )
                ));

        $content = file_get_contents($url, false, $context);

        return $content;
    }

}

$crawler = new MoviesCrawler();
if (isset($flag['update'])) {
    $crawler->flag = $flag;
}
$crawler->parseMoviesPage();
//$crawler->parseMoviePage("http://www.primewire.ag/watch-226806-Race-Against-Time");
//$crawler->parseMoviePage("http://www.primewire.ag/watch-2743041-The-Night-Clerk");





