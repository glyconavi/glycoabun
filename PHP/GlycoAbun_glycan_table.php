
<?php
include("../head.php");
?>
<style type="text/css">
.img-block {
  width: 300px;
  height: 300px;
  
	-webkit-transition: all 0.1s;
	transition: all 0.1s;
}

.img-block img:hover{
	-webkit-transform: scale(2);
	transform: scale(2);
}

a.img-block img:hover {
	-webkit-transform: scale(2);
	transform: scale(2);
}


</style>
<body>
<!-- <h2>Glycan Information</h2> -->
<table class="TwoWayBack">
	<thead>
	<tr>
		<!-- <th scope="cols">Entry</th> -->
        
        <th scope="cols">Glycosylation Site</th>
        <th scope="cols">Abundance ratio</th>
		<th scope="cols">Glycan component</th>
        <th scope="cols">Proposed glycan</th>
        <!-- <th scope="cols">Order</th> -->
	</tr>
	</thead>
	<tbody>

<?php
//header('Content-Type: text/plain;charset=UTF-8');
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

// json
$glycoforms = file_get_contents("http://bio.glyconavi.org/GlycoAbun/GlycoAbun_glycoinfo_json.php?id=".$id);
$json = mb_convert_encoding($glycoforms, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$arr = json_decode($json,true);

if ($arr === NULL) {
    return;
}
else{   
    $resarray = array();
    $arr = $arr["results"]["bindings"];
}





foreach ($arr as $gi) {
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

SELECT ?pos ?order ?from ?to  ?wurcs ?glycan_image ?mod_wurcs ?mod_glycan_image
FROM <http://glyconavi.org/database/glycoabun>
WHERE {

# abundance
?gf sio:has-proper-part ?gi .
?gf ga:order ?order .
VALUES ?gi { <".$gi['gi']['value']."> }

#glycosylation site
OPTIONAL {
?gf sio:is-covalently-connected-to ?loc .
?loc faldo:begin ?begin .
?begin faldo:position ?pos .
}

# glycan structure
?gi sio:has-part ?gcomp .
?gcomp chebi:32854 ?glycan .
?glycan ga:wurcs ?wurcs .
?glycan foaf:depiction ?glycan_image .

OPTIONAL {
?glycan ga:modified ?mod .
?mod ga:modified_glycan ?mod_glycan .
?mod_glycan ga:wurcs ?mod_wurcs .
?mod_glycan foaf:depiction ?mod_glycan_image .
?mod ga:method ?method .
}

#?method rdf:type ?method_type .
# abundance ratio
OPTIONAL {
?gi exterms:percentage ?par .
?par ga:from ?par_from .
?par_from sio:has-value ?from .
?par ga:to ?par_to .
?par_to sio:has-value ?to .
}

}";




if (strlen($id) > 0) {
    $sparqlformat =  "format=application%2Fsparql-results%2Bjson";
    $spqrqldata = "http://rdf.glyconavi.org:8890/sparql?default-graph-uri=&query=".urlencode($sparql_name)."&should-sponge=&".$sparqlformat."&timeout=0&debug=on";
    $getdata = file_get_contents($spqrqldata);
}

$json = mb_convert_encoding($getdata, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$arr = json_decode($json,true);

if ($arr === NULL) {
    return;
}
else{
    
    $resarray = array();
    $arr = $arr["results"]["bindings"];

        echo '<tr>'."\n";
        //echo '<th scope="row">'.$ressouce["gf_id"]["value"].'</th>'."\n";
        //$ressouce["pos"]["value"];
        //echo '<td><font size="5">'.$ressouce["pos"]["value"].'</font></td>'."\n";
        if ($arr[0]["pos"]["value"]) {
            echo '<th scope="row"><font size="5">Ans-'.$arr[0]["pos"]["value"].'</font></th>'."\n";
        }
        else {
            echo '<th scope="row"><font size="5">'.$arr[0]["pos"]["value"].'</font></th>'."\n";
        }

                // $ressouce["from"]["value"];
        $percent = "%";
        if ($arr[0]["from"]["value"] == "n.d." || $arr[0]["from"]["value"] === null){
            $percent = "";
        }


        if ($arr[0]["order"]["value"] == "1") {
            echo '<td><font color="red" size="6">'.$arr[0]["from"]["value"].$percent.'</font></td>'."\n";
        }
        else {
            echo '<td><font size="6">'.$arr[0]["from"]["value"].$percent.'</font></td>'."\n";
        }


        echo '<td>'."\n";
        foreach ($arr as $ressouce) {

            if ($firstobj !== $ressouce["glycan_image"]["value"]) {

                $pubchem = str_replace("https://pubchem.ncbi.nlm.nih.gov/rest/pug_view/image/biologic/", "", $ressouce["glycan_image"]["value"]);
                $pubchem = str_replace("/SVG", "", $pubchem);
                if(strpos($ressouce["glycan_image"]["value"],'glytoucan') !== false){
                            $gtn = str_replace("https://glytoucan.org/glycans/", "", $ressouce["glycan_image"]["value"]);
                            $gtn = str_replace("/image?style=extended&format=png&notation=cfg", "", $gtn);

                            echo '<a class="img-block" href="https://glytoucan.org/Structures/Glycans/'.$gtn.'" target="_blank"><img src="'.$ressouce["glycan_image"]["value"].'" alt="" ></a>'."\n";
                }
                else {
                    echo '<a class="img-block"><img src="'.$ressouce["glycan_image"]["value"].'" alt="" ></a>'."\n";
                }
            }
            $firstobj = $ressouce["glycan_image"]["value"];            
        }
        echo '</td>'."\n";

        echo '<td>'."\n";
        foreach ($arr as $ressouce) {

            if ($firstobj !== $ressouce["mod_glycan_image"]["value"]) {
                $gtn = str_replace("https://glytoucan.org/glycans/", "", $ressouce["mod_glycan_image"]["value"]);
                $gtn = str_replace("/image?style=extended&format=png&notation=cfg", "", $gtn);
                echo '<a class="img-block" href="https://glytoucan.org/Structures/Glycans/'.$gtn.'" target="_blank"><img src="'.$ressouce["mod_glycan_image"]["value"].'" alt="" ></a>'."\n";        
            }
            $firstobj = $ressouce["mod_glycan_image"]["value"];            
        }
        echo '</td></tr>'."\n";
}

}

?>


	</tbody>
</table>



<?php
//include("footer.php");
?>

</body>
</html>
