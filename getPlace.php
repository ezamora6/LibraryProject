<?php

$key = '';
$key2 = 'AIzaSyBcmZdDHZjW71FA4WWlLiNufQaQmTZ1qso';
function api_call($path)
{
   sleep(1);
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL,$path);
   curl_setopt($ch, CURLOPT_FAILONERROR,1);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
   curl_setopt($ch, CURLOPT_TIMEOUT, 15);
   $retValue = curl_exec($ch);
   curl_close($ch);
   return $retValue;
}

print_r($_cookie);
echo $lont = $_COOKIE['lon'];
echo $latt = $_COOKIE['lat'];
$ISBN = $_REQUEST['ISBN'];
getPlaceInfo($ISBN, $key, $key2);


function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


//print_r($sxml);

function getPlaceInfo($ISBN, $key, $key2)
{
    $ip = getRealIpAddr();
    $xml = api_call('http://www.worldcat.org/webservices/catalog/content/libraries/' . $ISBN . '?ip=' . $ip . "&wskey={" . $key . '}' );
    //$sxml = new SimpleXMLElement($xml);
    $sxml = simplexml_load_file('example.xml');
    header('Content-Type: text/plain');
    //print_r($sxml);
    $library = array();
    
    foreach($sxml->xpath('//physicalLocation') as $name)
    {
        array_push($library, (string)$name);
    }
    array_shift($library);
    foreach($library as &$temp)
    {
        $temp = str_replace(' ', '+', $temp);
    }
    $places = array();
    foreach ($library as $location)
    {
        $xml = api_call('https://maps.googleapis.com/maps/api/geocode/xml?address=' . $location .'&key=' .$key2);
        header('Content-Type: text/plain');
        $sxml = new SimpleXMLElement($xml);
        $lat = (double) $sxml->result->geometry->location->lat;
        $lon = (double) $sxml->result->geometry->location->lon;
        $placeInfo = array ((string)$location, $lat, $lon);
        array_push($places, $placeInfo);
    }
    return $places;
}


?>