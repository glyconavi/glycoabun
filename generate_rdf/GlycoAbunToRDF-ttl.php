<?php
header('Content-Type: text/plain;charset=UTF-8');
ini_set('auto_detect_line_endings', 1);
ini_set('auto_detect_line_endings', 1);
date_default_timezone_set('Asia/Tokyo');
//$timeHeader = date("Y-m-d_H-i-s");
$timeHeader = date("Y-m-d_");

//作成したいディレクトリ（のパス）
$directory_path = "RDF";    //この場合、同じ階層に「RDF」というディレクトリを作成する 
//「$directory_path」で指定されたディレクトリが存在するか確認
if(file_exists($directory_path)){
	//存在したときの処理
	echo "作成しようとしたディレクトリは既に存在します\n";
}else{
	//存在しないときの処理（「$directory_path」で指定されたディレクトリを作成する）
	if(mkdir($directory_path, 0777)){
		//作成したディレクトリのパーミッションを確実に変更
		chmod($directory_path, 0777);
		//作成に成功した時の処理
		echo "作成に成功しました\n";
	}else{
		//作成に失敗した時の処理
		echo "作成に失敗しました\n";
	}
}

//$fileHeader = date("Y-m-d");
$savepath = $directory_path.DIRECTORY_SEPARATOR."glycoabun_glyconavi_".$timeHeader.".ttl";

$DataString = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .\n";
$DataString .= "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#> .\n";
$DataString .= "PREFIX owl: <http://www.w3.org/2002/07/owl#> .\n";
$DataString .= "PREFIX xsd: <http://www.w3.org/2001/XMLSchema#> .\n";
$DataString .= "PREFIX dc: <http://purl.org/dc/elements/1.1/> .\n";
$DataString .= "PREFIX dcterms: <http://purl.org/dc/terms/> .\n";
$DataString .= "PREFIX foaf: <http://xmlns.com/foaf/0.1/> .\n";
$DataString .= "PREFIX skos: <http://www.w3.org/2004/02/skos/core#> .\n";
$DataString .= "PREFIX void: <http://rdfs.org/ns/void#> .\n";
$DataString .= "PREFIX prov: <http://www.w3.org/ns/prov#> .\n";
$DataString .= "PREFIX glycan: <http://purl.jp/bio/12/glyco/glycan#> .\n";
$DataString .= "PREFIX up: <http://purl.uniprot.org/core/> .\n";
$DataString .= "PREFIX faldo: <http://biohackathon.org/resource/faldo#> .\n";
$DataString .= "PREFIX UO: <http://purl.obolibrary.org/obo/> .\n";
$DataString .= "PREFIX gs: <http://glyconavi.org/glycosample/> .\n";
$DataString .= "PREFIX ga: <http://glyconavi.org/glyabun/> .\n";
$DataString .= "PREFIX gb: <http://glyconavi.org/glycobio/> .\n";
$DataString .= "PREFIX sio: <http://semanticscience.org/resource/> .\n";
$DataString .= "PREFIX chebi: <http://bio2rdf.org/chebi:> .\n";
$DataString .= "PREFIX exterms: <http://www.example.org/terms/> .\n";
$DataString .= "PREFIX pav:   <http://purl.org/pav/> .\n";
$DataString .= "PREFIX dcat:  <http://www.w3.org/ns/dcat#> .\n";
$DataString .= "\n";

$DataString .= "<http://glyconavi.org/database/glycoabun>\n";
$DataString .= "        a                           void:Dataset ;\n";
$DataString .= "        dcterms:description        \"Glycan abundance ratio -version ".$timeHeader."\" ;\n";
$DataString .= "        dcterms:license             <http://creativecommons.org/licenses/by/2.1/> ;\n";
$DataString .= "        dcterms:publisher           <http://glyconavi.org> ;\n";
$DataString .= "        dcterms:title              \"GlycoAbun RDF\" ;\n";
$DataString .= "        pav:contributedBy           < https://orcid.org/0000-0001-9504-189X> ;\n";
$DataString .= "        pav:version                \"0.1c\";\n";
$DataString .= "        dcterms:hasVersion         <http://glyconavi.org/GlycoAbun/0.1c> ;\n";
$DataString .= "        dcat:landingPage            <https://bio.glyconavi.org/GlycoAbun> .\n";
$DataString .= "\n";



file_put_contents($savepath, $DataString, FILE_APPEND | LOCK_EX); //追記モード


$fileArray = array();

foreach(glob('txt/{*.txt}',GLOB_BRACE) as $file) {
	if(is_file($file)) {
		$fileArray[] = $file;
		echo "file:\t".$file."\n";
	}
}

sort($fileArray);


// get file names
foreach($fileArray as $file) {
	if(is_file($file)) {
		// get file path
		//echo htmlspecialchars($file)."\n";
		// blocks
		$blocks = array();

		try {
			$filedata = file_get_contents($file);
			$str = str_replace(array("\r\n","\r","\n"), "\n", $filedata);
			$blocks = explode("$$$$\n", $str);
			//$blocks = explode(PHP_EOL, $str);
		}
		catch (Exception $e) {
			echo $e;
		}

		// 1st block - biosample, components
		// 2nd, 3rd, ... block - component

		echo "count:\t".count ($blocks)."\n";
		$blocks0_parts = explode("####\n", $blocks[0]);
		$block_parts = explode("####\n", $blocks[1]);




		$PubMedId = array();
		$glycosample_id = "";
		//$resorceArray = array();
		$component_id = array();
		$resorce_id = array();
		$bio_resorce_label = array();
		$protein_name = array();
		$resorce_type = array();
		$rdfs_comment = array();

		$resorce_id = array();
		$component_id = array();
		$component_Lablel = array();
		$sub_molecule_id = array();
		$UniProt_id = array();
		$resorce_component_id = array();
		$component = array();
		$AA_Sequence = array();
		$glycoforms = array();

		$referenced_protein_id = array();
		$glycoform_id = array();
		$Location = array();
		$auth_site = array();
		$UniProt_site = array();
		$glycoform_label = array();


		$referenced_saccharide_id = array();
		$abundance_ratio_from = array();
		$abundance_ratio_to = array();
		$glyco_label = array();
		$auth_label = array();
		$GlyTouCan_id = array();
		$modified_glycan = array();
		$modification_method = array();

		// block 0
		foreach ($blocks0_parts as $part) {
			$lines = explode("\n", $part);
			
			foreach ($lines as $line) {
				// @pubmed
				if(strpos($line,"@pubmed") !== false){
					$pm = explode("\t", $line);
					if ($pm[1] == 1) {
						$pmids = explode("\t", $lines[3]);
						foreach ($pmids as $pmid) {
							//echo "PMID:\t".$pmid."\n";
							array_push($PubMedId, $pmid);
						}
						foreach ($PubMedId as $pmid) {
							echo "PMID:\t".$pmid."\n";
						}
					}
				}

				// @glycosample
				if(strpos($line,"@glycosample") !== false){
					$gs = explode("\t", $line);
					if ($gs[1] == 1) {
						$glycosample = $lines[3];
					}
					echo "glycosample id:\t".$lines[3]."\n";
				}

				/*
				@resorce	5
				resorce.id
				bio.resorce.label
				protein.name
				resorce.type
				rdfs:comment
				*/
				// @resorce
				if(strpos($line,"@resorce") !== false){

					$res = explode("\t", $line);
					// $res[1] = 5;
					/*
					for ($num = 1; $num <= $res[1]; $num++){
						array_push($resorceArray, $lines[$num]);
					}
					foreach ($resorceArray as $resorce) {
						echo "resorce:\t".$resorce."\n";
					}
					*/

					$dataline = explode("\t", $lines[$res[1] + 1]);
					echo "dataline: ".$dataline[1]."\n";

					$datas = explode("\t", $lines[$res[1] + $dataline[1] + 1]);

					array_push($resorce_id, $datas[0]);
					array_push($bio_resorce_label, $datas[1]);
					array_push($protein_name, $datas[2]);
					array_push($resorce_type, $datas[3]);
					array_push($rdfs_comment, $datas[4]);

					foreach ($datas as $data) {
						echo "data:\t".$data."\n";
					}					
				}

				// @components
				$dlines = 0;
				if(strpos($line,"@components") !== false){
					$res = explode("\t", $line);
					$dataline = explode("\t", $lines[$res[1] + 1]);
					echo "dataline: ".$dataline[1]."\n";
					$dlines = $dataline[1];
					echo "dlines:".$dlines."\n";
				

					$count1 = $res[1] + 2;
					$count2 = $res[1] + 2 + $dlines;
					echo "count1:".$count1."\n";
					echo "count2:".$count2."\n";
					for ($num = $count1; $num < $count2; $num++){
						//echo "num:".$num."\n";
						$compdata = explode("\t", $lines[$num]);
						array_push($resorce_id, $compdata[0]);
						array_push($resorce_component_id, $compdata[1]);
						array_push($component_Lablel, $compdata[2]);
						//array_push($sub_molecule_id, $compdata[3]);
						array_push($UniProt_id, $compdata[3]);

					}


					echo "resorce_id count:\t".count($resorce_component_id)."\n";

					for ($num = 0; $num < count($resorce_component_id); $num++){
						echo "resorce_id:\t".$resorce_id[$num]."\n";
						echo "referenced.protein.id:\t".$resorce_component_id[$num]."\n";
						echo "referenced.protein.Lablel:\t".$component_Lablel[$num]."\n";
						//echo "sub_molecule_id:\t".$sub_molecule_id[$num]."\n";
						echo "UniProt.id:\t".$UniProt_id[$num]."\n";
					}
				}
			}

		}

		// block 1-
		// $block_parts
		// @protein.component
		foreach ($block_parts as $part) {
			$lines = explode("\n", $part);
			// @protein.component\t
			if(strpos($lines[0],"@protein.component") !== false){
				$comps = explode("\t", $lines[3]);
				foreach ($comps as $co) {
					//echo "PMID:\t".$pmid."\n";
					array_push($component, $co);
				}
				foreach ($component as $compon) {
					echo "referenced.protein.id:\t".$compon."\n";
				}
			}

			// @sequence
			if(strpos($lines[0],"@sequence") !== false){
				$seqs = explode("\t", $lines[3]);
				foreach ($seqs as $seq) {
					//echo "PMID:\t".$pmid."\n";
					array_push($AA_Sequence, $seq);
				}
				foreach ($AA_Sequence as $se) {
					echo "AA.Sequence:\t".$se."\n";
				}
			}

			// @glycoform.info
			/*
			[0]@glycoform.info	6
			[1]referenced.protein.id
			[2]glycoform.id
			[3]Location
			[4]auth.site
			[5]UniProt.site
			[6]glycoform.label
			[7]_line	2
			[8]RP1	GF1	Loc1	52	76	Glycoform of N-Glycosylation site (Asn-52) of hCG alpha
			[9]RP1	GF2	Loc2	78	102	Glycoform of N-Glycosylation site (Asn-78) of hCG alpha
			*/
			if(strpos($lines[0],"@glycoform.info") !== false){
				$number = explode("\t", $lines[0]);				
				//echo "number:".$number[1]."\n";
				$infoCount = explode("\t", $lines[$number[1] + 1]);
				//echo "infoCount:".$infoCount[1]."\n";
				$star = $number[1] + 2; //$infoCount[1];
				//echo "start line:".$star."\n";

				$datalines = $star + $infoCount[1];
				for ($num = $star; $num < $datalines; $num++){
					//echo "lines[num]:".$lines[$num]."\n";
					$datacontents = explode("\t", $lines[$num]);

					array_push($referenced_protein_id, $datacontents[0]);
					array_push($glycoform_id, $datacontents[1]);
					array_push($Location, $datacontents[2]);
					array_push($auth_site, $datacontents[3]);
					array_push($UniProt_site, $datacontents[4]);
					array_push($glycoform_label, $datacontents[5]);

					foreach ($datacontents as $datacontent) {
						echo "\t".$datacontent."\n";
					}

				}
			}

			/*
			@glycofrom.abun	8
			referenced.saccharide.id
			abundance.ratio.from
			abundance.ratio.to
			glyco.label
			auth.label
			GlyTouCan.id
			modified.glycan
			modification.method
			_line	6
			RS1	18	18	N2@Asn52	N2	G77252PU	Alditol	Reduction
			RS2	50	50	N1-4'@Asn52	N1-4'	G14996IQ	Alditol	Reduction
			RS3	19	19	N1-A@Asn52	N1-A	G53962WT	Alditol	Reduction
			RS4	10	10	N1-AB@Asn52	N1-AB	G65890UA	Alditol	Reduction
			RS5	61	61	N2@Asn78	N2	G77252PU	Alditol	Reduction
			RS6	39	39	N1-4'@Asn78	N1-4'	G14996IQ	Alditol	Reduction
			*/
			if(strpos($lines[0],"@glycofrom.abun") !== false){
				$number = explode("\t", $lines[0]);				
				//echo "number:".$number[1]."\n";
				$infoCount = explode("\t", $lines[$number[1] + 1]);
				//echo "infoCount:".$infoCount[1]."\n";
				$star = $number[1] + 2; //$infoCount[1];
				//echo "start line:".$star."\n";

				$datalines = $star + $infoCount[1];
				//echo "datalines line:".$datalines."\n";

				for ($num = $star; $num < $datalines; $num++){
					//echo "lines[num]:".$lines[$num]."\n";
					$datacontents = explode("\t", $lines[$num]);

					array_push($referenced_saccharide_id, $datacontents[0]);
					array_push($abundance_ratio_from, $datacontents[1]);
					array_push($abundance_ratio_to, $datacontents[2]);
					array_push($glyco_label, $datacontents[3]);
					array_push($auth_label, $datacontents[4]);
					array_push($GlyTouCan_id, $datacontents[5]);
					array_push($modified_glycan, $datacontents[6]);
					array_push($modification_method, $datacontents[7]);

					foreach ($datacontents as $datacontent) {
						echo "\t".$datacontent."\n";
					}
				}
			}








		}


		file_put_contents($savepath, "\n", FILE_APPEND | LOCK_EX); //追記モード
	}
	foreach ($fileArray as $file) {
		echo "read...\n".htmlspecialchars($file)."\n";
	}
	echo "wrote...\n".htmlspecialchars($savepath)."\n";
}
echo "fin...";
?>  