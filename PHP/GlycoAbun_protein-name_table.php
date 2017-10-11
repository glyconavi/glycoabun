
<?php
include("../head.php");
?>
<body>
<!-- <h2>Glycan Information</h2> -->
<?php

//header('Content-Type: text/plain;charset=UTF-8');
mb_internal_encoding("UTF-8");
ini_set('auto_detect_line_endings', 1);
ini_set('auto_detect_line_endings', 1);
date_default_timezone_set('Asia/Tokyo');
$timeHeader = date("Y-m-d_H-i-s");

$id="RC_1";
if(isset($_REQUEST['id'])) {
    if ($_REQUEST["id"] != "") {
        $id = trim($_REQUEST["id"]);
    }
}

$sparql_name = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX dcterms: <http://purl.org/dc/terms/>
PREFIX glycan: <http://purl.jp/bio/12/glyco/glycan#>
PREFIX sio: <http://semanticscience.org/resource/>
PREFIX gs: <http://glyconavi.org/glycosample/>
PREFIX ga: <http://glyconavi.org/glyabun/>
PREFIX exterms: <http://www.example.org/terms/>
PREFIX chebi: <http://bio2rdf.org/chebi:>
PREFIX faldo: <http://biohackathon.org/resource/faldo#>
PREFIX up: <http://purl.uniprot.org/core/>

SELECT ?gs_id ?rc_id ?abbreviation ?synonym ?bioresource
FROM <http://glyconavi.org/database/glycoabun>
WHERE {

# glycosample
?gs gs:glycosample_id ?gs_id .
?gs glycan:has_resource_entry ?br .

# ?br: bioresource
?br sio:has-component-part ?rc .
?br rdfs:label ?bioresource .
?rc ga:id ?rc_id .
VALUES ?rc_id { \"".$id."\" }
?rc ga:abbreviation ?abbreviation .
?rc sio:hasSynonym/sio:has-value ?synonym .

}";

$spqrqldata = "http://rdf.glyconavi.org:8890/sparql?default-graph-uri=&query=".urlencode($sparql_name)."&should-sponge=&format=application%2Fsparql-results%2Bjson&timeout=0&debug=on";
$getdata = file_get_contents($spqrqldata);
//echo "<div>".$getdata."</div>";
$json = mb_convert_encoding($getdata, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$arr = json_decode($json,true);

$bioresource = array();
$synonym = array();
$abbreviation = array();

foreach ($arr['results']['bindings'] as $val){
    $bioresource[] = $val['bioresource']['value'];
    $synonym[] = $val['synonym']['value'];
    $abbreviation[] = $val['abbreviation']['value'];

}

$bioresource = array_unique($bioresource);
if (count($bioresource) > 0) {
    //echo "<div><h3>Component of ".$bioresource[0]."</h3></div>";
}

$synonym = array_unique($synonym);
if (count($synonym) > 0) {
    //echo "<div>Synonym</div>";
    //echo "<div><ul>";
    foreach ($synonym as $val ) {
        //echo "<li>".$val."</li>";
    }
    //echo "</ul></div>";
}

$abbreviation = array_unique($abbreviation);
if (count($abbreviation) > 0) {
    //echo "<div>Abbreviation</div>";
    //echo "<div><ul>";
    foreach ($abbreviation as $val ) {
        //echo "<li>".$val."</li>";
    }
    //echo "</ul></div>";
}
?>
<div>
<table class="TwoWayBack">
	<thead>
	<tr>
		<th scope="cols">Entry</th>
		<th scope="cols">Data</th>
	</tr>
	</thead>
	<tbody>
<?php
        echo '<tr>'."\n";
        echo '<td>Resource</td>';
        echo '<td>Component of '.$bioresource[0].'</td>';
        echo '</tr>'."\n";

        echo '<tr>'."\n";
        echo '<td>Abbreviation</td>';
        echo '<td>';
        foreach ($abbreviation as $val ) {
            echo $val."<br>";
        }
        echo'</td>';
        echo '</tr>'."\n";

        echo '<tr>'."\n";
        echo '<td>Synonym</td>';
        echo '<td>';
        foreach ($synonym as $val ) {
            echo $val."<br>";
        }
        echo'</td>';
        echo '</tr>'."\n";

?>
	</tbody>
</table>
</div>


<?php
//include("footer.php");
?>

</body>
</html>
