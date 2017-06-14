<?php

parse_str($_SERVER['QUERY_STRING'], $query);


$token = json_decode(file_get_contents("http://torrentapi.org/pubapi_v2.php?get_token=get_token"))->token;
echo file_get_contents("http://torrentapi.org/pubapi_v2.php?format=json_extended&sort=seeders&ranked=0&category=4;14;48;17;44;46;23;40;45;18;25;32;47;41;27;33;42;49;28;35&token=".$token."&mode=search&search_string=".$query['string']);



?>
