<?php


$rpc_token = get_headers("http://192.168.1.1:9091/transmission/rpc")[2];
$token = json_decode(file_get_contents("http://torrentapi.org/pubapi_v2.php?get_token=get_token"))->token;

parse_str($_SERVER['QUERY_STRING'], $query);


?>
<html>

<head>
  <title>Search for torrents</title>
  <script
    src="https://code.jquery.com/jquery-3.2.1.js"
    integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
    crossorigin="anonymous"></script>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body class="container">
  <div style="margin-top:10px" class="col-md-6">
    <label>Search text</label><input class="form-control" id="searchTerm" />
    <label>Download location</label> <input class="form-control" value="/mnt/sda4/Media/Series/" id="dir" />
    <br />
    <button class="btn btn-primary col-xs-12" onclick="searchTorrent()">Search</button>
  </div>
  <div class="col-xs-12" id="here_table"></div>
</body>

<script>
var torrents;
function searchTorrent() {
  console.log("http://192.168.1.1:8000/search.php?string=" + $("#searchTerm").val());
  $.getJSON("http://192.168.1.1:8000/search.php?string=" + $("#searchTerm").val() , res => {
    console.log(res);
    $("#here_table").html('');
    torrents = res = res.torrent_results;
    var table = $('<table></table>').addClass('table');
    table.append('<thead><tr><th>Name</th><th>Seeders</th><th>Leechers</th><th>Size (MB)</th></tr></thead><tbody>')
    res.forEach((item, index) => {
      var row = $('<tr></tr>').addClass('bar');
      var data1 = $('<td></td>').text(item.title);
      var seeders = $('<td></td>').text(item.seeders);
      var leechers = $('<td></td>').text(item.leechers);
      var size = $('<td></td>').text((item.size / 1048576).toFixed(2));
      var data2 = $('<td><button class="btn btn-xs btn-info" onclick="download('+index+')">Download</button></td>');
      row.append(data1);
      row.append(seeders);
      row.append(leechers);
      row.append(size);
      row.append(data2);
      table.append(row);
    })
    table.append('</tbody>');
    $('#here_table').append(table);
  });

}
function download(index) {
  console.log(torrents[index]);
  var url = encodeURI("http://192.168.1.1:8000/download.php?dir=" +  $("#dir").val() + "&link=" + btoa(torrents[index].download));
  console.log(url);
  $.get(url, a => console.log(a));
}

</script>

</html>
