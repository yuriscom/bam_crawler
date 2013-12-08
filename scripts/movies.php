<?php



class MoviesCrawler {

    private $baseUrl = "http://www.primewire.ag";
    private $db;

    public function __construct() {
        $this->db = Utils\Db::getInstance();
    }

    public function parseMoviePage($url) {
        $movie = array();
        $querystring = str_replace($this->baseUrl, "", $url);
        preg_match("/\/watch-(\d*)-/", $querystring, $m);
        if (isset($m[1])) {
            $movie['prime_id'] = $m[1];
        }
        
        $rec = $this->db->getTable("Movie")->find($movie['prime_id']);
        if ($rec) {
            return false;
        }
        
        
        $html = file_get_contents($url);

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
                $movie['links'][] = array('url'=>$link,'version'=>$version);
            }
        }

        $query = "//div[@class='mlink_imdb']/a";
        $imdbLinkList = $xpath->query($query);
        if ($imdbLinkList->length) {
            $movie['imdb_link'] = $imdbLinkList->item(0)->getAttribute('href');
        }
        
        
        $this->db->em->getConnection()->beginTransaction();
        
        $movieObj = new Entity\Movie;
        $movieObj->prime_id = $movie['prime_id'];
        $movieObj->title = $movie['title'];
        $movieObj->description = $movie['description'];
        $movieObj->released = $movie['info']['released'];
        $movieObj->runtime = $movie['info']['runtime'];
        $movieObj->imdb_link = $movie['imdb_link'];
        $this->db->em->persist($movieObj);
        $this->db->em->flush();
        
        foreach ($movie['links'] as $link) {
            $linkObj = new Entity\MovieLink;
            $linkObj->movie_id = $movieObj->id;
            $linkObj->link = $link['url'];
            $linkObj->version = $link['version'];
            $this->db->em->persist($linkObj);
            $this->db->em->flush();
        }
        
        if (is_array($movie['info']['genres'])) {
            foreach ($movie['info']['genres'] as $jenre) {
                $jenreObj = $this->db->getTable("genre")->findBy(array("name"=>$jenre));
                p($jenreObj); die;

            }
        }
        
        
        
        
        $this->db->em->getConnection()->commit();
        
        
        
        die("ok");
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





//$q = $em->createQueryBuilder()->select('u')->from('Entity\User','u')->getQuery();
//$res = $q->getArrayResult();
//p($res);
//die; 

$url = "http://www.primewire.ag/?sort=date";
$crawler = new MoviesCrawler();
//$crawler->parseMoviesPage($url);
$crawler->parseMoviePage("http://www.primewire.ag/watch-226806-Race-Against-Time");
//$crawler->parseMoviePage("http://www.primewire.ag/watch-2743041-The-Night-Clerk");

// http://www.primewire.ag/?sort=date




