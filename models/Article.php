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

	public function display_category($id, $record_limit, $offset)
	{
		$sql = "SELECT article_cat_id FROM article_categories WHERE article_id=$id";
		//echo $sql."<br>";
		$art_id = $this->selectAll($sql);
		$count = count($art_id);
		// var_dump($art_id);
		// echo "<br>";
		// while($count != 0)
		// {
		// 	echo "key: ".key($art_id)."<br>";
		// 	echo "count: ".$count."<br>";
				foreach ($art_id as $value) {
					# code...
					$category_id = $value["article_cat_id"];
					//echo "category_id: ".$category_id."<br>";
					$cat_sql = "SELECT title FROM category WHERE cat_id=$category_id";
					$category = $this->selectAll($cat_sql);
					echo "category: ";
					var_dump($category);
					//return $category;
				}
		// 	$count = $count - 1;
		// }
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


	public function delete_article($art_id, $thumb_file)
	{
		$sql_select = "SELECT * FROM article WHERE article_id='$art_id'";
		$result_select = $this->selectOne($sql_select);
		$sql = "DELETE FROM article WHERE article_id='$art_id'";
		$result = $this->execute($sql);
		if($result == TRUE)
		{
			unlink($result_select["image"]);
			unlink($thumb_file);
		}
		return $result;
	}
	
	public function edit_image($id, $target_file, $target_thumb_file)
	{
		$sql = "UPDATE article_image SET org_img_path='$target_file', thumb_img_path='$target_thumb_file' WHERE article_id='$id'";
		$result = $this->execute($sql);
		return $result;
	}

	public function addImage($id, $target_file, $target_thumb_file)
	{
		$sql = "INSERT INTO article_image(article_id, org_img_path, thumb_img_path) VALUES($id, '$target_file', '$target_thumb_file')";
		//echo "1.".$sql;
		$save_img = $this->execute($sql);
		var_dump($save_img);
		return $save_img;
	}

	public function getId()
	{
		$sql = "SELECT article_id FROM article ORDER BY article_id DESC LIMIT 1";
		$result = $this->selectOne($sql);
		//$last_id = mysqli_insert_id($sql);
		//echo $result["article_id"];
		return $result["article_id"];
	}


	public function getCategory()
	{
		$sql = "SELECT * FROM category";
		$result = $this->selectAll($sql);
		return $result;
	}


	public function addCategory($id, $category_id)
	{
		foreach ($category_id as $category_id) 
		{
			// var_dump(mysqli_escape_string($this->connect, $category));	
			// $cat = mysqli_escape_string($this->connect, $category);
			// $get_cat_id = "SELECT cat_id FROM category WHERE title='$cat'";
			// $category_id = $this->selectOne($get_cat_id);
			// $add_cat_id = $category_id["cat_id"];
			// var_dump($add_cat_id);
			$sql = "INSERT INTO article_categories(article_id, article_cat_id) VALUES($id, $category_id)";
			$category = $this->execute($sql);
		}
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