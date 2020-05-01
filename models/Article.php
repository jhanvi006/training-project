<?php

class Article extends database
{
	public function add_article($title, $desc, $img_name)
	{
		$e_title = mysqli_escape_string($this->connect, $title);
		$e_desc = mysqli_escape_string($this->connect, $desc);
		$e_img_name = mysqli_escape_string($this->connect, $img_name);
		$sql = "INSERT INTO article(title, description, image) VALUES('$e_title', '$e_desc', '$e_img_name')";
		$result = $this->execute($sql);
		return $result;
	}

	public function display_article($record_limit, $offset)
	{
		$sql = "SELECT * FROM article LIMIT $offset, $record_limit";
		$result = $this->selectAll($sql);
		return $result;
	}

	public function count_records()
	{
		$sql = "SELECT * FROM article";
		$result = mysqli_query($this->connect, $sql);
		$count = mysqli_num_rows($result);
		return $count;
	}

	public function edit_article($title, $desc, $img_name, $id)
	{
		$e_title = mysqli_escape_string($this->connect, $title);
		$e_desc = mysqli_escape_string($this->connect, $desc);
		$e_img_name = mysqli_escape_string($this->connect, $img_name);
		$sql = "UPDATE article SET title='$e_title', description='$e_desc', image='$e_img_name' WHERE article_id='$id'";
		$result = $this->execute($sql);
		return $result;
	}

	public function delete_article($art_id)
	{
		$sql_select = "SELECT * FROM article WHERE article_id='$art_id'";
		$result_select = $this->selectOne($sql_select);
		$sql = "DELETE FROM article WHERE article_id='$art_id'";
		$result = $this->execute($sql);
		if($result == TRUE)
			unlink($result_select["image"]);
		return $result;
	}

	public function getId()
	{
		$sql = "SELECT article_id FROM article ORDER BY article_id DESC LIMIT 1";
		$result = $this->selectOne($sql);
		//$last_id = mysqli_insert_id($sql);
		//echo $result["article_id"];
		return $result["article_id"];
	}

	//public function createThumbImg($target_folder, $file_name, $thumb_folder)
	public function createThumbImg($sourcePath, $targetPath, $file_type, $thumbWidth, $thumbHeight) 
	{
		
		if($file_type == "image/jpeg" || $file_type == "image/jpg")
		{
			$source = imagecreatefromjpeg($sourcePath);
		
		    $width = imagesx($source);
			$height = imagesy($source);
			
			$tnumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
			
			imagecopyresampled($tnumbImage, $source, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
			if (imagejpeg($tnumbImage, $targetPath, 90)) 
			{
			 //    imagedestroy($tnumbImage);
				// imagedestroy($source);
				return TRUE;
			} 
			else 
			{
				return FALSE;
			}
		}
		else 
		{
			$source = imagecreatefrompng($sourcePath);
		
		    $width = imagesx($source);
			$height = imagesy($source);
			
			$tnumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
			
			imagecopyresampled($tnumbImage, $source, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
			if (imagepng($tnumbImage, $targetPath, 9)) 
			{
				return TRUE;
			} 
			else 
			{
				return FALSE;
			}
		}
	}
}