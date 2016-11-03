<?php
include 'util.php';
include 'stats.php';

// Globally namespaced version of the class
class u extends \utilphp\util { }
// ok, php, my friend

$quiet_mode = false;
if(isset($_REQUEST['quiet']))
{
	$quiet_mode = true;
	header("Content-Type: text/plain");
}

if($quiet_mode)
{
	print "package;version;platform;download;hits;last_download\n";
}

$data = read_stats();
// u::var_dump($data);

$files = scandir('packages/');
foreach($files as $file)
{
	// bug si el package tiene "-"
	if(u::ends_with($file, "-cmake.tar.gz"))
	{
		$substance = $file;
		$substance = substr($substance, 0, strrpos($substance, "-"));
		$platform = substr($substance, strrpos($substance, "-")+1);
		$substance = substr($substance, 0, strrpos($substance, "-"));
		$version = substr($substance, strrpos($substance, "-")+1);
		$substance = substr($substance, 0, strrpos($substance, "-"));
		$package = $substance;
		if(!isset($_REQUEST['platform']) || ($_REQUEST['platform'] == $platform))
		{
			$hits_info = get_hits($data, $file);
			$hits = $hits_info[0];
			$last_download = $hits_info[1];
			if($last_download === NULL)
			{
				if(!$quiet_mode)
				{
					$formatted = "never downloaded";
				}
				else
				{
					$formatted = "---";
				}
			}
			else
			{
				if(!$quiet_mode)
				{
					$formatted = $last_download->format("d-m-Y H:i");
				}
				else
				{
					$formatted = $last_download->format("c");
				}
			}
			if(!$quiet_mode)
			{
				echo "package: " . $package . "<br \>";
				echo "version: " . $version . "<br \>";
				echo "platform: " . $platform . "<br \>";
				if($hits > 0)
				{
					echo "<a href='download.php?file=".$file."'>Download</a> (".$hits." hits, last download: ".$formatted.")";
				}
				else
				{
					echo "<a href='download.php?file=".$file."'>Download</a> (".$hits." hits)";
				}
				echo "<br /><br />";
			}
			else
			{
				print $package.";".$version.";".$platform.";"."download.php?file=".$file.";".$hits.";".$formatted."\n";
			}
		}
	}
}

?>

