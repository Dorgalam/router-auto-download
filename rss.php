<?php

$token = get_headers("http://192.168.1.1:9091/transmission/rpc")[2];
$xml = simplexml_load_string(file_get_contents("http://showrss.info/user/117264.rss?magnets=true&namespaces=true&name=null&quality=null&re=null"));

foreach ($xml->channel->item as $item) {
  if((time() - strtotime($item->pubDate))/(60*60*24) < 1) {
    preg_match('/s\d\d/i', $item->title, $matches);
    $body = '{
      "arguments": {
        "download-dir": "/mnt/sda4/Media/Series/'.$item->children("tv", true)->show_name.'/Season '.intval(substr($matches[0], 1)).'",
        "filename": "'.$item->link.'"
      },
      "method": "torrent-add"
    }';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://192.168.1.1:9091/transmission/rpc");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",$token));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    $result = curl_exec($ch);
  }
}
?>
