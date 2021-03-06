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
		$sql = "SELECT a.article_id, a.title, a.description, GROUP_CONCAT(c.title) AS article_categories, ai.thumb_img_path FROM article a JOIN article_image ai ON a.article_id=ai.article_id JOIN article_categories ac ON a.article_id = ac.article_id JOIN category c ON c.cat_id = ac.article_cat_id GROUP BY a.article_id LIMIT $offset,$record_limit";
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

	public function edit_article_category($id, $sel_cat_id, $cat_id)
	{
		foreach ($cat_id as $category_id) {
			$c_id[] = $category_id["article_cat_id"];
		}
		foreach ($c_id as $category_id) {
			$del_sql = "DELETE FROM article_categories WHERE article_id='$id' AND article_cat_id='$category_id'";
			$result = $this->execute($del_sql);			
		}
		foreach ($sel_cat_id as $category_id) {
			$sql = "INSERT INTO article_categories(article_id, article_cat_id) VALUES($id, $category_id)";
			$category = $this->execute($sql);
		}
	}

	public function delete_article($art_id, $thumb_file)
	{
		$sql_select = "SELECT * FROM article WHERE article_id='$art_id'";
		$result_select = $this->selectOne($sql_select);
		$sql = "DELETE FROM article WHERE article_id='$art_id'";
		$result = $this->execute($sql);
		if($result == TRUE)
		{
			$category_sql = "DELETE FROM article_categories WHERE article_id='$art_id'";
			$this->execute($category_sql);

			$img_sql = "DELETE FROM article_image WHERE article_id='$art_id'";
			$this->execute($img_sql);

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
		//var_dump($save_img);
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

	public function getSelectedCategory($sel_cat_id)
	{
		//foreach ($cat_id as $category_id) {
			$sql = "SELECT title FROM category WHERE cat_id=$sel_cat_id";
			$category = $this->selectOne($sql);
			// echo "category:";
			// var_dump($category["title"]);
		//}
		//var_dump($category);
			return $category["title"];
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
			// var_dump($add_catedit_article_category_id);
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