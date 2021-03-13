#!/usr/bin/env php
<?php

	// http://php.net/manual/en/function.error-reporting.php
	error_reporting(E_ALL & ~(E_WARNING|E_NOTICE));


class App {
	protected $lesson_url_list = '';
	protected $lesson_url_data = array();
	protected $code_url_list = '';
	protected $code_url_data = array();

	protected function find_lesson_list() {

		$base_url = 'http://lazyfoo.net/tutorials/SDL/index.php';

		$doc = new DOMDocument; // http://php.net/manual/en/class.domdocument.php

		$doc->preserveWhiteSpace = false; // http://php.net/manual/en/class.domdocument.php#domdocument.props.preservewhitespace

		$doc->loadHTMLFile($base_url); // http://php.net/manual/en/domdocument.loadhtmlfile.php

		$xpath = new DOMXPath($doc); // http://php.net/manual/en/class.domxpath.php

		$query = '//a[@class="tutLink"]/@href';

		$nodes = $xpath->query($query); // http://php.net/manual/en/domxpath.query.php

		if (is_null($nodes)) { // http://php.net/manual/en/function.is-null.php
			return;
		}


		$list = '';
		$data = array();
		// http://php.net/manual/en/class.domnodelist.php
		// http://php.net/manual/en/class.domnode.php
		foreach ($nodes as $node) {

			$source_file_name = $node->nodeValue;

			//var_dump($node);


			if (strstr($source_file_name, '..')) { // http://php.net/manual/en/function.strstr.php
				continue;
			}

			if (strstr($source_file_name, 'http://www.libsdl.org')) { // http://php.net/manual/en/function.strstr.php
				continue;
			}


			$source_url = dirname($base_url) . '/' . $source_file_name;

			#echo $source_url . PHP_EOL;

			$list .= $source_url . PHP_EOL;

			$data[] = $source_url;
		}

		$this->lesson_url_list = $list;
		$this->lesson_url_data = $data;

	}

	protected function find_lesson_source($base_url) {



		$doc = new DOMDocument; // http://php.net/manual/en/class.domdocument.php

		$doc->preserveWhiteSpace = false; // http://php.net/manual/en/class.domdocument.php#domdocument.props.preservewhitespace

		$doc->loadHTMLFile($base_url); // http://php.net/manual/en/domdocument.loadhtmlfile.php

		$xpath = new DOMXPath($doc); // http://php.net/manual/en/class.domxpath.php

		$query = '//a[@class="tutLink"]/@href';

		$nodes = $xpath->query($query); // http://php.net/manual/en/domxpath.query.php

		if (is_null($nodes)) { // http://php.net/manual/en/function.is-null.php
			return;
		}



		// http://php.net/manual/en/class.domnodelist.php
		// http://php.net/manual/en/class.domnode.php
		foreach ($nodes as $node) {

			$source_file_name = $node->nodeValue;

			//var_dump($node);


			if (!strstr($source_file_name, '.zip')) { // http://php.net/manual/en/function.strstr.php
				continue;
			}



			$source_url = dirname($base_url) . '/' . $source_file_name;


			#echo $source_url . PHP_EOL;

			$this->code_url_list .= $source_url . PHP_EOL;

			$this->code_url_data[] = $source_url;
		}





	}

	public function run() {
		$this->find_lesson_list();

		//echo $this->lesson_url_list;
		//var_dump($this->lesson_url_data);

		foreach ($this->lesson_url_data as $key => $lesson_url) {
			//$lesson_url='http://lazyfoo.net/tutorials/SDL/02_getting_an_image_on_the_screen/index.php';
			//var_dump($lesson_url);
			if ($key == 0) {
				$lesson_url = 'http://lazyfoo.net/tutorials/SDL/01_hello_SDL/linux/cli/index.php';
			} else if ($key == 5) {
				$lesson_url = 'http://lazyfoo.net/tutorials/SDL/06_extension_libraries_and_loading_other_image_formats/linux/cli/index.php';
			} else if ($key == 51) {
				$lesson_url = 'http://lazyfoo.net/tutorials/SDL/52_hello_mobile/index2.php';
			} else if ($key == 52) {
				$lesson_url = 'http://lazyfoo.net/tutorials/SDL/53_extensions_and_changing_orientation/android_linux/index.php';
			}


			$this->find_lesson_source($lesson_url);

		}

		//var_dump($this->code_url_data);
		//echo $this->code_url_list;

		$list_file_path = __DIR__ . '/dl.txt';

		file_put_contents($list_file_path, $this->code_url_list); // http://php.net/manual/en/function.file-put-contents.php

		system('wget -c -i ' . $list_file_path); // http://php.net/manual/en/function.system.php

	}
}


(new App)->run();
