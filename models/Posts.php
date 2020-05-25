<?php
class Posts extends database 
{
	public function count_records()
	{
		$sql = "SELECT * FROM article";
		$result = mysqli_query($this->connect, $sql);
		$count = mysqli_num_rows($result);
		return $count;
	}

	public function display_article($record_limit, $offset)
	{
		$sql = "SELECT a.article_id, a.title, a.description, ai.thumb_img_path FROM article a JOIN article_image ai ON a.article_id=ai.article_id ORDER BY a.created_at DESC LIMIT $offset,$record_limit";
		$result = $this->selectAll($sql);
		return $result;
	}

	public function excerpt($record_limit, $offset) {
		$sql = "SELECT a.article_id, a.title, LEFT(a.description,25) AS excerpt, ai.thumb_img_path FROM article a JOIN article_image ai ON a.article_id=ai.article_id ORDER BY a.created_at DESC LIMIT $offset,$record_limit";
		$row = $this->selectAll($sql);
		// var_dump($row);
		// echo "<br>";
		foreach ($row as $key => $value) {
			$lastSpaceIndex = strrpos($value["excerpt"], ' ');
			$value["excerpt"] = substr($value["excerpt"], 0, $lastSpaceIndex);
			$row[$key] = $value;
			//echo "<br>".$value["excerpt"]."<br>";
		}
		//var_dump($row);
		return $row;
	}

	public function content($id){
		$sql = "SELECT a.article_id, a.title, a.description, ai.thumb_img_path FROM article a JOIN article_image ai ON a.article_id=ai.article_id WHERE a.article_id = '$id'";
		$result = $this->selectOne($sql);
		return $result;
	}
}

