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

SELECT ?gs_id ?rc_id  ?pos ?order ?from ?to  ?wurcs ?glycan_image ?mod_wurcs ?mod_glycan_image
FROM <http://glyconavi.org/database/glycoabun>
WHERE {

# glycosample
?gs gs:glycosample_id ?gs_id .
?gs glycan:has_resource_entry ?br .

# ?br: bioresource
?br sio:has-component-part ?rc .
?rc ga:id ?rc_id .
VALUES ?rc_id { \"".$id."\" }

# abundance
?rc ga:has_abundance ?ga .
?ga sio:has-direct-part ?gf .
?gf sio:has-proper-part ?gi .
?gf ga:order ?order .
#glycosylation site
?gf sio:is-covalently-connected-to ?loc .
?loc faldo:begin ?begin .
?begin faldo:position ?pos .

# glycan structure
?gi sio:has-part ?gcomp .
?gcomp chebi:32854 ?glycan .
?glycan ga:wurcs ?wurcs .
?glycan foaf:depiction ?glycan_image .
?glycan foaf:depiction ?glycan_img .
?glycan ga:modified ?mod .
?mod ga:modified_glycan ?mod_glycan .
?mod_glycan ga:wurcs ?mod_wurcs .
?mod_glycan foaf:depiction ?mod_glycan_image .
?mod_glycan foaf:depiction ?mod_glycan_img .
?mod ga:method ?method .

#?method rdf:type ?method_type .
# abundance ratio
?gi exterms:percentage ?par .
?par ga:from ?par_from .
?par_from sio:has-value ?from .
?par ga:to ?par_to .
?par_to sio:has-value ?to .
}";

// json
//format=application%2Fsparql-results%2Bjson&timeout=0&debug=on


$spqrqldata = "http://rdf.glyconavi.org:8890/sparql?default-graph-uri=&query=".urlencode($sparql_name)."&should-sponge=&format=application%2Fsparql-results%2Bjson&timeout=0&debug=on";
$getdata = file_get_contents($spqrqldata);
echo $getdata;
?>