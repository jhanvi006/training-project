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
		$sql = "INSERT INTO category(title, description) VALUES('$title', '$desc')";
		$result = $this->execute($sql);
		return $result;
	}

	public function edit_category($title, $title_cond)
	{
		$sql = "UPDATE category SET title='$title' WHERE title='$title_cond'";
		$result = $this->execute($sql);
		return $result;
	}

	public function delete_category($cat_id)
	{
		$sql = "DELETE FROM category WHERE cat_id='$cat_id'";
		$result = $this->execute($sql);
		return $result;
	}
}