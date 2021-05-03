<?php


// Samsung external drive with RDF cache
$caches = array(
	//'zoobank' => '/Volumes/Samsung_T5/rdf-archive/zoobank/rdf',
	'zoobank' => '/Users/rpage/Development/rdf-archive/zoobank/rdf',

);	

// Path to local storage of LSID is the reverse of the domain name
$domain_path = array(
	'zoobank' => array('org', 'zoobank', 'act'),
);

$database = 'zoobank';

// Fetch XML files
$basedir = $caches[$database];

$files1 = scandir($basedir);

//$files1 = array('bf');

foreach ($files1 as $directory)
{
	echo "$directory\n";

	// UUID directories
	if (preg_match('/^[0-9a-f]{2}$/', $directory))
	{	
		$files2 = scandir($basedir . '/' . $directory);
		
		// individual XML files
		
		$contents = '';
		foreach ($files2 as $filename)
		{		
			if (preg_match('/\.xml$/', $filename))
			{	
				$full_filename = $basedir . '/' . $directory . '/' . $filename;
				
				$xml = file_get_contents($full_filename);
				
				// make sure XML document is on one line by replacing end of lines 
				$xml = preg_replace("/\R/", " ", $xml) . "\n";
											
				$contents .= $xml;
			}
		}
		
		
		// Store archive in file 			
		$path = 'lsid/' . join('/', $domain_path[$database]);
		
		$path .= '/' . $directory . '.xml.gz';
		
		file_put_contents($path, gzencode($contents));
		
	}
}


?>


