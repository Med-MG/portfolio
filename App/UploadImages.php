<?php 

namespace App;

/**
 * Upload images
 *
 * PHP version 7.0
 */


class uploadImages{
	/**
     * Image type
     * @var string
     */
    public $image_type;
    /**
     * Image max size
     * @var string
     */
    public $min_size;
    /**
     * Image minimum size
     * @var string
     */
    public $max_size;
    /**
     * max number of files
     * @var integer
     */
    public $max_files;
    /**
     * Folder path
     * @var string
     */
    public $folder;
    /**
     * errors array
     * @var array
     */
	public $error;
	/**
     * Class constructor
     *
     * @return void
     */
	function __construct(){
		$this->image_type = "jpg|jpeg|png|gif";
		$this->min_size = 24;
		$this->max_size = (1024*1024*3);
		$this->max_files = 10;
		$this->error = array();
	}
	/**
     * Counting the number of images method
     *
     * @return int return an integer
     */
	public function countImages()
	{
		foreach ($_FILES as $file)
		{
			return count($file["name"]);	
		}
    }
    
	/**
     * This method returns an array of images data
     *
     * @return array returns an array or images
     */
	public function getImages()
	{
		$images = array();
		foreach ($_FILES as $file)
		{
			for ($x = 0; $x < count($file["name"]); $x++)
			{
				$images[] = array(
				"name" => $file["name"][$x], 
				"size"=> $file["size"][$x],
				"tmp_name" => $file["tmp_name"][$x],
				"type" => $file["type"][$x],
				"error" => $file["error"][$x]
				);
			}
		}
		return $images;
	}
    /**
     * This method returns an array of paramaters
     *
     * @return array
     */
	public function getParams()
	{
		return $_GET;
    }
    
	/**
     * This method returns true or false based on whether
     * the images are uploaded
     * 
     * @return bool
     */
	public function saveImage($tmp_name, $folder, $image_name)
	{
		if(move_uploaded_file($tmp_name, $folder.$image_name))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
    
    /**
     * Images validation method
     * 
     * @return bool
     */
	public function validateImages()
	{
		$images = $this->getImages();
		
		foreach ($images as $image)
		{
			$type = $image["type"];
			$image_type = explode("/", $type);
			$content_type = explode("|", $this->image_type);
			$size = $image["size"];
			
			if (count($images) > $this->max_files)
			{
				$this->error = array("error_type" => "ERROR_MAX_FILES");
				break;
			}
			else if (!array_search($image_type[1], $content_type))
			{
				$this->error = array(
				"error_type" => "ERROR_CONTENT_TYPE", 
				"image_name" => $image["name"], 
				"image_type" => $image["type"]
				);
				break;
			}
			else if ($size < $this->min_size)
			{
				$this->error = array(
				"error_type" => "ERROR_MIN_SIZE", 
				"image_name" => $image["name"], 
				"image_type" => $image["size"]
				);
				break;
			}
			else if ($size > $this->max_size)
			{
				$this->error = array(
				"error_type" => "ERROR_MAX_SIZE", 
				"image_name" => $image["name"], 
				"image_type" => $image["size"]
				);
				break;
			}	
			else
			{
				return true;	
			}			
		}
	}
}