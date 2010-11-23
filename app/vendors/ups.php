<?php
/*
<!--
* 01 - UPS Next Day Air
* 02 - UPS Second Day Air
* 03 - UPS Ground
* 07 - UPS Worldwide Express
* 08 - UPS Worldwide Expedited
* 11 - UPS Standard
* 12 - UPS Three-Day Select
* 14 - UPS Next Day Air Early AM
* 54 - UPS Worldwide Express Plus
* 59 - UPS Second Day Air AM
* 65 - UPS Saver

-->
*/

class Ups{

	function getShippingPrice($start_zip, $dest_zip, $service, $weight, $length, $width, $height, $rawdata = false) 
	{
	//echo "<Br>" . $service . "<Br>";
	
		// This script was written by Mark Sanborn at http://www.marksanborn.net
		// If this script benefits you are your business please consider a donation
		// You can donate at http://www.marksanborn.net/donate.
	
		// ========== CHANGE THESE VALUES TO MATCH YOUR OWN ===========
	
		$AccessLicenseNumber = 'EC36B3494DABAE18'; // Your license number
		$UserId = 'ugpadmin'; // Username
		$Password = 'P13g4u31.'; // Password
		$PostalCode = $start_zip; // Zipcode you are shipping FROM
		$ShipperNumber = '35W170'; // Your UPS shipper number
	
		// =============== DON'T CHANGE BELOW THIS LINE ===============
	
	
	    	$data ="<?xml version=\"1.0\"?>
	    	<AccessRequest xml:lang=\"en-US\">
	    		<AccessLicenseNumber>$AccessLicenseNumber</AccessLicenseNumber>
	    		<UserId>$UserId</UserId>
	    		<Password>$Password</Password>
	    	</AccessRequest>
	    	<?xml version=\"1.0\"?>
	    	<RatingServiceSelectionRequest xml:lang=\"en-US\">
	    		<Request>
	    			<TransactionReference>
	    				<CustomerContext>Bare Bones Rate Request</CustomerContext>
	    				<XpciVersion>1.0001</XpciVersion>
	    			</TransactionReference>
	    			<RequestAction>Rate</RequestAction>
	    			<RequestOption>Rate</RequestOption>
	    		</Request>
	    	<PickupType>
	    		<Code>01</Code>
	    	</PickupType>
	    	<Shipment>
	    		<Shipper>
	    			<Address>
	    				<PostalCode>$PostalCode</PostalCode>
	    				<CountryCode>US</CountryCode>
	    			</Address>
				<ShipperNumber>$ShipperNumber</ShipperNumber>
	    		</Shipper>
	    		<ShipTo>
	    			<Address>
	    				<PostalCode>$dest_zip</PostalCode>
	    				<CountryCode>US</CountryCode>
					<ResidentialAddressIndicator/>
	    			</Address>
	    		</ShipTo>
	    		<ShipFrom>
	    			<Address>
	    				<PostalCode>$PostalCode</PostalCode>
	    				<CountryCode>US</CountryCode>
	    			</Address>
	    		</ShipFrom>
	    		<Service>
	    			<Code>" . $service . "</Code>
	    		</Service>
	    		<Package>
	    			<PackagingType>
	    				<Code>02</Code>
	    			</PackagingType>
	    			<Dimensions>
	    				<UnitOfMeasurement>
	    					<Code>IN</Code>
	    				</UnitOfMeasurement>
	    				<Length>$length</Length>
	    				<Width>$width</Width>
	    				<Height>$height</Height>
	    			</Dimensions>
	    			<PackageWeight>
	    				<UnitOfMeasurement>
	    					<Code>LBS</Code>
	    				</UnitOfMeasurement>
	    				<Weight>$weight</Weight>
	    			</PackageWeight>
	    		</Package>
	    	</Shipment>
	    	</RatingServiceSelectionRequest>";
	    	$ch = curl_init("https://www.ups.com/ups.app/xml/Rate");
	    	curl_setopt($ch, CURLOPT_HEADER, 1);
	    	curl_setopt($ch,CURLOPT_POST,1);
	    	curl_setopt($ch,CURLOPT_TIMEOUT, 90);
			//curl_setopt($ch,CURLOPT_PROXY,'http://proxy.shr.secureserver.net:3128');
	    	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	    	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    	curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	    	$result=curl_exec ($ch);
			//echo $result ; echo $data;
	    	$data = strstr($result, '<?');
	    	$xml_parser = xml_parser_create();
	    	xml_parse_into_struct($xml_parser, $data, $vals, $index);
	    	xml_parser_free($xml_parser);
	    	$params = array();
	    	$level = array();
	    	foreach ($vals as $xml_elem) {
	    	 if ($xml_elem['type'] == 'open') {
	    	if (array_key_exists('attributes',$xml_elem)) {
	    		 list($level[$xml_elem['level']],$extra) = array_values($xml_elem['attributes']);
	    	} else {
	    		 $level[$xml_elem['level']] = $xml_elem['tag'];
	    	}
	    	 }
	    	 if ($xml_elem['type'] == 'complete') {
	    	$start_level = 1;
	    	$php_stmt = '$params';
	    	while($start_level < $xml_elem['level']) {
	    		 $php_stmt .= '[$level['.$start_level.']]';
	    		 $start_level++;
	    	}
	    	$php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';
	    	eval($php_stmt);
	    	 }
	    	}
	    	curl_close($ch);
	    	if($rawdata){
	    		return $data;
	    	}else{
	    		return $params['RATINGSERVICESELECTIONRESPONSE']['RATEDSHIPMENT']['TOTALCHARGES']['MONETARYVALUE'];
	    	}
	    }
	    
	    
	    
	function ups_transit($code, $start_zip, $fromCityName, $dest_zip, $toCityName, $order_printed_date, $raw = false) 
	{
	
		// This script was written by Mark Sanborn at http://www.marksanborn.net
		// If this script benefits you are your business please consider a donation
		// You can donate at http://www.marksanborn.net/donate.
	
		// ========== CHANGE THESE VALUES TO MATCH YOUR OWN ===========
	
		$AccessLicenseNumber = 'EC36B3494DABAE18'; // Your license number
		$UserId = 'ugpadmin'; // Username
		$Password = 'P13g4u31.'; // Password
		$PostalCode = $start_zip; // Zipcode you are shipping FROM
		$ShipperNumber = '35W170'; // Your UPS shipper number
	
		// =============== DON'T CHANGE BELOW THIS LINE ===============
	
	
	    	$data ="<?xml version=\"1.0\"?>
			<AccessRequest xml:lang=\"en-US\">
				<AccessLicenseNumber>$AccessLicenseNumber</AccessLicenseNumber>
				<UserId>$UserId</UserId>
				<Password>$Password</Password>
			</AccessRequest>
			<?xml version=\"1.0\"?>
			<TimeInTransitRequest xml:lang=\"en-US\">
				<Request>
					<TransactionReference>
						<CustomerContext>Time in Transit</CustomerContext>
						<XpciVersion>1.0002</XpciVersion>
					</TransactionReference>
					<RequestAction>TimeInTransit</RequestAction>
				</Request>
				<TransitFrom>
					<AddressArtifactFormat>
						<PoliticalDivision2>$fromCityName</PoliticalDivision2>
						<PostcodePrimaryLow>$PostalCode</PostcodePrimaryLow>
						<CountryCode>US</CountryCode>
					</AddressArtifactFormat>
				</TransitFrom>
				<TransitTo>
					<AddressArtifactFormat>
						<PoliticalDivision2>$toCityName</PoliticalDivision2>
						<PostcodePrimaryLow>$dest_zip</PostcodePrimaryLow>
						<CountryCode>US</CountryCode>
					</AddressArtifactFormat>
				</TransitTo>
				<ResidentialAddressIndicator>Residential</ResidentialAddressIndicator>
				<PickupDate>$order_printed_date</PickupDate>
				<MaximumListSize>49</MaximumListSize>
			</TimeInTransitRequest>";
			
			$ch = curl_init("https://www.ups.com/ups.app/xml/TimeInTransit");
	    	curl_setopt($ch, CURLOPT_HEADER, 1);
	    	curl_setopt($ch,CURLOPT_POST,1);
	    	curl_setopt($ch,CURLOPT_TIMEOUT, 90);
	    	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	    	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    	curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	    	$result=curl_exec ($ch);
			//echo $result; // THIS LINE IS FOR DEBUG PURPOSES ONLY-IT WILL SHOW IN HTML COMMENTS
			$data = strstr($result, '<?');
			$temp1=split("</ServiceSummary><ServiceSummary>", $result);
			$temp2=split("<ServiceSummary>", $temp1[0]);
			$temp3=split("</ServiceSummary>", $temp1[(sizeof($temp1)-1)]);
			$SSarray=array();
			$str = $temp2[1];
			
			for ($i=1; $i < (sizeof($temp1) - 1); $i++)
			{
				$str .= $temp1[$i];
			}
			
			$str .= $temp3[0];
			
			switch ($code)
			{
			    case '01':
			        $match = "UPS Next Day Air";
			        break;
			    case 'DA':
			        $match = "UPS Next Day Air";
			        break;
			    case '02':
			        $match = "UPS 2nd Day Air";
			        break;
			     case '2DA':
			        $match = "UPS 2nd Day Air";
			        break;
			    case '03':
			        $match = "UPS Ground";
			        break;
			    case 'GND':
			        $match = "UPS Ground";
			        break;
			    case '12':
			        $match = "UPS 3 Day Select";
			        break;
			    case '3DS':
			        $match = "UPS 3 Day Select";
			        break;
			    case '2DM':
			        $match = "UPS 2nd Day Air A.M.";
			        break;
			    case '14':
			        $match = "UPS Next Day Air Early A.M.";
			        break;
			    case '65':
			        $match = "UPS Next Day Air Saver";
			        break;
			    case '1DP':
			        $match = "UPS Next Day Air Saver";
			        break;
			    default:
			        $match = "piubasdlhvbadklsjvblakhdsbvlkjasdbflvkjsdbfuvbsdoifuvblsdfvois"; //no match found
			        break;
			}
			$temp1 = split($match, $str);
			$temp2 = split("<BusinessTransitDays>", $temp1[1]);
			$temp3 = split("</BusinessTransitDays>", $temp2[1]);
	    	curl_close($ch);
	    	
	    	if($raw){
	    		return $data;
	    	}else{
	    		return $temp3[0];
	    	}
	 }
}
?>
