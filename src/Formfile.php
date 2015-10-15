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
class Formfile {

	/**
	 * 
	 * @var string
	 */
	protected $name;

	/**
	 * 
	 * @var string
	 */
	protected $type;

	/**
	 * 
	 * @var string
	 */
	protected $tmpName;

	/**
	 * 
	 * @var integer
	 */
	protected $error;

	/**
	 * 
	 * @var integer
	 */
	protected $size;
	
	
	/**
	 * 
	 */
	public function __construct() {
		$this->name = "";
		$this->type = "";
		$this->tmpName = "";
		$this->error = 0;
		$this->size = 0;
	}
	
	/**
	 * 
	 * @param string $data
	 */
	public function setName($data) {
		$this->name = (string) $data;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getName() {
		return (string) $this->name;
	}
	
	/**
	 * 
	 * @param string $data
	 */
	public function setType($data) {
		$this->type = (string) $data;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getType() {
		return (string) $this->type;
	}
	
	/**
	 * 
	 * @param string $data
	 */
	public function setTmpName($data) {
		$this->tmpName = (string) $data;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getTmpName() {
		return (string) $this->tmpName;
	}
	
	/**
	 * 
	 * @param integer $data
	 */
	public function setError($data) {
		$this->error = (integer) $data;
	}
	
	/**
	 * 
	 * @return integer
	 */
	public function getError() {
		return (integer) $this->error;
	}
	
	/**
	 * 
	 * @param integer $data
	 */
	public function setSize($data) {
		$this->size = (integer) $data;
	}
	
	/**
	 * 
	 * @return integer
	 */
	public function getSize() {
		return (integer) $this->size;
	}
	
	/**
	 * 
	 * @param string $path
	 * @param string $filename
	 * @return string
	 * @throws FormfileException
	 */
	public function save($path, $filename = "") {
		if($filename == "") {
			$filename = $this->name;
		}
		
		if(!file_exists($path)) {
			if(!mkdir($path, 0750, true)) {
				throw new FormfileException("folder '" . $path . "' could not be created.");
			}
		}
			
		$absolute = $path.$filename;
		if(file_exists($absolute)) {
			error_log("file '" . $absolute . "' will be overwritten.");
		}
			
		if(!move_uploaded_file($this->getTmpName(), $absolute)) {
			throw new FormfileException(error_get_last()["message"]);
		}
		
		return $absolute;
	}
	
}

?>