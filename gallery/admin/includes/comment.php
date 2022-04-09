<?php 



class Comment extends Db_object {

	protected static $db_table = "comments";
	protected static $db_table_fields = array('id', 'id', 'author','body');
	public $id;
	public $id;
	public $author;
	public $body;



	public static function create_comment($id, $author="John", $body="") {


		if(!empty($id) && !empty($author) && !empty($body)) {

			$comment = new Comment();

			$comment->id = (int)$id;
			$comment->author   = $author;
			$comment->body     = $body;

			return $comment;


		} else {


			return false;
		}


	}



	public static function find_the_comments($id=0) {

		global $database;

		$sql  = "SELECT * FROM " . self::$db_table;
		$sql .= " WHERE id = " . $database->escape_string($id);
		$sql .= " ORDER  BY id ASC";

		return self::find_by_query($sql);

	} 




} // End of Class User














 ?>


















