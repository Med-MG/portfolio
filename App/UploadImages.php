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
    public static  $image_type = "jpg|jpeg|png|gif";
    /**
     * Image max size
     * @var string
     */
    public static  $min_size = 24;
    /**
     * Image minimum size
     * @var string
     */
    public static $max_size = (1024*1024*3);
    /**
     * max number of files
     * @var integer
     */
    public static  $max_files = 10;
    /**
     * Folder path
     * @var string
     */
    public static  $folder;
    /**
     * errors array
     * @var array
     */
	public static  $error = array();
	/**
     * Class constructor
     *
     * @return void
     */
	// function __construct(){
	// 	// static::$image_type = "jpg|jpeg|png|gif";
	// 	// static::$min_size = 24;
	// 	// static::$max_size = (1024*1024*3);
	// 	// static::$max_files = 10;
	// 	// static::$error = array();
	// }
	/**
     * Counting the number of images method
     *
     * @return int return an integer
     */
	public static function countImages()
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
	public static function getImages()
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
     * This method returns an array of images data
     *
     * @return array returns an array or images
     */
	public static function getImage()
	{
		$images = array();
		foreach ($_FILES as $file)
		{
				$images[] = array(
				"name" => $file["name"], 
				"size"=> $file["size"],
				"tmp_name" => $file["tmp_name"],
				"type" => $file["type"],
				"error" => $file["error"]
				);
		}
		
		return $images;
	}
    /**
     * This method returns an array of paramaters
     *
     * @return array
     */
	public static function getParams()
	{
		return $_GET;
    }
    
	/**
     * This method returns true or false based on whether
     * the images are uploaded
     * 
     * @return bool
     */
	public static function saveImage($tmp_name, $folder, $image_name)
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
	public static function validateImages($multiple=true)
	{
		if($multiple == true){
			$images = static::getImages();

		}else {
			$images = static::getImage();
		}
        
		
		foreach ($images as $image)
		{
			$type = $image["type"];
			$image_type = explode("/", $type);
			$content_type = explode("|", self::$image_type);
			$size = $image["size"];
			if (count($images) > self::$max_files)
			{
				self::$error = array("error_type" => "ERROR_MAX_FILES");
				break;
			}
			else if (!array_search($image_type[1], $content_type))
			{
				self::$error = array(
				"error_type" => "ERROR_CONTENT_TYPE", 
				"image_name" => $image["name"], 
				"image_type" => $image["type"]
				);
				break;
			}
			else if ($size < self::$min_size)
			{
				self::$error = array(
				"error_type" => "ERROR_MIN_SIZE", 
				"image_name" => $image["name"], 
				"image_type" => $image["size"]
				);
				break;
			}
			else if ($size > self::$max_size)
			{
				self::$error = array(
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