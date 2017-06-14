<?php

parse_str($_SERVER['QUERY_STRING'], $query);


$token = get_headers("http://192.168.1.1:9091/transmission/rpc")[2];
$body = '{
  "arguments": {
    "download-dir":"'.$query['dir'].'",
    "filename": "'.base64_decode($query['link']).'"
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
print_r($reuslt);
?>
