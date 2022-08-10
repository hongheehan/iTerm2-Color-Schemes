#!/usr/bin/env php
<?php
/*
	Run this file to create mintty theme files.
	And copy these files to Cygwin's /usr/share/mintty/themes directory.
*/

$home_dir = dirname(__DIR__);
$source_dir = "$home_dir/vscode";
$target_dir = "$home_dir/mintty";

try {

	foreach(glob("$source_dir/*.json") as $file) {

		$theme_name = pathinfo($file, PATHINFO_FILENAME); 
		
		$settings = json_decode(file_get_contents($file), true);
		if(json_last_error())
			throw new Exception("$theme_name.json: json format error!");

		$colors = [
			"# theme: $theme_name",
			"# source: https://github.com/hongheehan/iTerm2-Color-Schemes",
			'',
		];
			
		$settings = array_shift($settings);
		$name = null;
		foreach($settings as $key => $value) {	
			switch($key) {
				case 'terminal.foreground':			$name = 'ForegroundColour'; break;
				case 'terminal.background':			$name = 'BackgroundColour'; break;
				case 'terminalCursor.foreground':	$name = 'CursorColour'; break;
				case 'terminal.ansiBlack':			$name = 'BoldBlack'; break;
				case 'terminal.ansiBlue':			$name = 'BoldBlue'; break;
				case 'terminal.ansiCyan':			$name = 'BoldCyan'; break;
				case 'terminal.ansiGreen':			$name = 'BoldGreen'; break;
				case 'terminal.ansiMagenta':		$name = 'BoldMagenta'; break;
				case 'terminal.ansiRed':			$name = 'BoldRed'; break;
				case 'terminal.ansiWhite':			$name = 'BoldWhite'; break;
				case 'terminal.ansiYellow':			$name = 'BoldYellow'; break;
				case 'terminal.ansiBrightBlack':	$name = 'Black'; break;
				case 'terminal.ansiBrightBlue':		$name = 'Blue'; break;
				case 'terminal.ansiBrightCyan':		$name = 'Cyan'; break;
				case 'terminal.ansiBrightGreen':	$name = 'Green'; break;
				case 'terminal.ansiBrightMagenta':	$name = 'Magenta'; break;
				case 'terminal.ansiBrightRed':		$name = 'Red'; break;
				case 'terminal.ansiBrightWhite':	$name = 'White'; break;
				case 'terminal.ansiBrightYellow':	$name = 'Yellow'; break;
			}
			if($name)
				$colors[] = "$name=$value";
		}

		$colors[] = '';
		file_put_contents("$target_dir/$theme_name", implode("\n", $colors));

		echo "create $theme_name.", PHP_EOL;
	}

} catch(Exception $e) {
	echo $e->getMessage(), PHP_EOL;
}

