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
	 * @var integer
	 */
	const FORMPARSER_UPLOAD_ERR_FORBIDDEN = 101;
	
	
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
					if(substr($file["name"][$k], 0, 1) == ".") {
						$this->reportError(self::FORMPARSER_UPLOAD_ERR_FORBIDDEN);
						continue;
					}
					
					if($file["error"][$k] != 0) {
						$this->reportError($file["error"][$k]);
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
			
			if(substr($file["name"], 0, 1) == ".") {
				$this->reportError(self::FORMPARSER_UPLOAD_ERR_FORBIDDEN);
				continue;
			}
			
			if($file["error"] != 0) {
				$this->reportError($file["error"]);
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
	 * @param integer $code
	 */
	public function reportError($code) {
		switch ($code) {
			case UPLOAD_ERR_INI_SIZE: {
				error_log("the uploaded file exceeds the upload_max_filesize directive in php.ini");
			} break;
			case UPLOAD_ERR_FORM_SIZE: {
				error_log("the uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form");
			} break;
			case UPLOAD_ERR_PARTIAL: {
				error_log("the uploaded file was only partially uploaded");
			} break;
			case UPLOAD_ERR_NO_FILE: {
				error_log("no file was uploaded");
			} break;
			case UPLOAD_ERR_NO_TMP_DIR: {
				error_log("missing a temporary folder");
			} break;
			case UPLOAD_ERR_CANT_WRITE: {
				error_log("failed to write file to disk");
			} break;
			case UPLOAD_ERR_EXTENSION: {
				error_log("file upload stopped by extension");
			} break;
			case self::FORMPARSER_UPLOAD_ERR_FORBIDDEN: {
				error_log("uploading this type of file is forbidden");
			} break;
		
			default: {
				error_log("Unknown upload error");
			} break;
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