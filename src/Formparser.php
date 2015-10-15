<?php

namespace scipper\Formfile;

/**
 * 
 * @author Steffen Kowalski <sk@traiwi.de>
 *
 * @since 15.10.2015
 * @namespace scipper\Formfile
 * @package scipper\Formfile
 *
 */
class Formparser {
	
	/**
	 * 
	 * @var array
	 */
	protected $files;
	
	/**
	 * 
	 * @var array[Formfile]
	 */
	protected $formfiles;
	
	
	/**
	 * 
	 */
	public function __construct() {
		if(isset($_FILES) && !empty($_FILES)) {
			$this->files = $_FILES;
		} else {
			$this->files = array();
		}
		$this->formfiles = array();
	}
	
	/**
	 * 
	 */
	public function parse() {
		foreach($this->files as $inputName => $file) {
			if(is_array($file["name"])) {
				foreach($file["name"] as $k => $v) {
					if($file["error"][$k] != 0) {
						continue;
					}
					
					$formfile = new Formfile();
					$formfile->setName($file["name"][$k]);
					$formfile->setType($file["type"][$k]);
					$formfile->setTmpName($file["tmp_name"][$k]);
					$formfile->setError($file["error"][$k]);
					$formfile->setSize($file["size"][$k]);
					
					$this->formfiles[] = $formfile;
				}
				continue;
			}
			
			if($file["error"] != 0) {
				continue;
			}
			
			$formfile = new Formfile();
			$formfile->setName($file["name"]);
			$formfile->setType($file["type"]);
			$formfile->setTmpName($file["tmp_name"]);
			$formfile->setError($file["error"]);
			$formfile->setSize($file["size"]);
			
			$this->formfiles[] = $formfile;
		}
	}
	
	/**
	 * 
	 * @return multitype:\scipper\Formfile\Formfile
	 */
	public function getFormfiles() {
		return $this->formfiles;
	}
	
}

?>