<?php

class Article extends database
{
	public function article_exists($title)
	{
		$sql = "SELECT * FROM article WHERE title = '$title'";

		$result = mysqli_query($this->connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            return true;
		}
	}

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

	public function edit_article($title, $desc, $img_name, $title_cond)
	{
		$e_title = mysqli_escape_string($this->connect, $title);
		$e_desc = mysqli_escape_string($this->connect, $desc);
		$e_img_name = mysqli_escape_string($this->connect, $img_name);
		$sql = "UPDATE article SET title='$e_title', description='$e_desc', image='$e_img_name' WHERE title='$title_cond'";
		$result = $this->execute($sql);
		return $result;
	}

	public function delete_article($art_id)
	{
		$sql = "DELETE FROM article WHERE article_id='$art_id'";
		$result = $this->execute($sql);
		return $result;
	}
}