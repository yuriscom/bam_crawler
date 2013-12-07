<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class MoviesCrawler {

    private $baseUrl = "http://www.primewire.ag";

    public function construct() {
        
    }

    public function parseMoviePage($url) {
        $movie = array();
        $html = file_get_contents($url);

        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $xpath = new DOMXPath($doc);

        $querystring = str_replace($this->baseUrl, "", $url);
        preg_match("/\/watch-(\d*)-/", $querystring, $m);
        if (isset($m[1])) {
            $movie['prime_id'] = $m[1];
        }

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
                $movie['links'][] = array('url'=>$link,'version'=>$version);
            }
        }

        $query = "//div[@class='mlink_imdb']/a";
        $imdbLinkList = $xpath->query($query);
        if ($imdbLinkList->length) {
            $movie['imdb_link'] = $imdbLinkList->item(0)->getAttribute('href');
        }
        
        var_dump($movie);
        return $movie;
    }

    public function parseMoviesPage($url) {
        $html = file_get_contents($url);
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $xpath = new DOMXPath($doc);
        $query = "//div[@class='index_item index_item_ie']";
        $resultsList = $xpath->query($query);
        for ($i = 0; $i < $resultsList->length; $i++) {
            $curNode = $resultsList->item($i);
            $linkNode = $xpath->query("a", $curNode)->item(0);
            $link = $this->baseUrl . $linkNode->getAttribute('href');
            $movie = $this->parseMoviePage($link);
            var_dump($movie);
            die;
        }
    }

}



$paths = array("Entity");
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);

$conn = array(
           'driver' => 'pdo_mysql',
           'user' => 'root',
           'password' => "m4!x#cc8f",
           'dbname' => 'crawler',
       );
// obtaining the entity manager
$em = EntityManager::create($conn, $config);

$q = $em->createQueryBuilder()->select('u')->from('Entity\User','u')->getQuery();
$res = $q->getArrayResult();
p($res);
die; 

$url = "http://www.primewire.ag/?sort=date";
$crawler = new MoviesCrawler();
//$crawler->parseMoviesPage($url);
$crawler->parseMoviePage("http://www.primewire.ag/watch-226806-Race-Against-Time");
//$crawler->parseMoviePage("http://www.primewire.ag/watch-2743041-The-Night-Clerk");

// http://www.primewire.ag/?sort=date




