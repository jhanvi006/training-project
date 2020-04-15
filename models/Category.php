<?php

class Category extends database
{
	public function category_exists($title)
	{
		$sql = "SELECT * FROM category WHERE title = '$title'";

		$result = mysqli_query($this->connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            return true;
		}
	}

	public function add_category($title, $desc)
	{
		$e_title = mysqli_escape_string($this->connect, $title);
		$e_desc = mysqli_escape_string($this->connect, $desc);
		$sql = "INSERT INTO category(title, description) VALUES('$e_title', '$e_desc')";
		$result = $this->execute($sql);
		return $result;
	}

	public function display_category()
	{
		$sql = "SELECT * FROM category";
		$result = $this->selectAll($sql);
		return $result;
	}

	public function edit_category($title, $desc, $title_cond)
	{
		$e_title = mysqli_escape_string($this->connect, $title);
		$e_desc = mysqli_escape_string($this->connect, $desc);
		$sql = "UPDATE category SET title='$e_title', description='$e_desc' WHERE title='$title_cond'";
		$result = $this->execute($sql);
		return $result;
	}

	public function delete_category($cat_id)
	{
		$sql = "DELETE FROM category WHERE cat_id='$cat_id'";
		$result = $this->execute($sql);
		return $result;
	}

	public function count_records()
	{
		$sql = "SELECT * FROM category";
		$result = mysqli_query($this->connect, $sql);
		$count = mysqli_num_rows($result);
		return $count;
	}
}