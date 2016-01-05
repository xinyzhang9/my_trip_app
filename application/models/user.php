<?php  
/**
* 
*/
class User extends CI_Model
{
	public function get_all_user(){
		return $this->db->query("SELECT * FROM users ORDER BY created_at ASC")->result_array();
	}

	public function add_user($user){
		$query = "INSERT INTO users (name,alias,email,password,date_of_birth,created_at) VALUES(?,?,?,?,?,NOW())";
		$values = array($user['name'],$user['alias'],$user['email'],$user['password'],$user['date_of_birth']);
		return $this->db->query($query,$values);
	}

	public function remove_user($id){
		$query = "DELETE FROM users where id = $id";
		return $this->db->query($query);
	}

	public function get_user_by_id($id){
        return $this->db->query("SELECT * FROM users WHERE id = ?", array($id))->row_array();
    }

    public function get_user_by_email($email){
    	return $this->db->query("SELECT * FROM users WHERE email = ?", array($email))->row_array();
    }

    public function get_friend($id){
        $query = "SELECT users.id as id,users.name as name, users.alias as alias, 
                    users.email as email, users.date_of_birth as date_of_birth,
                    friends.id as friend_id,
                    friends.name as friend_name, friends.alias as friend_alias,
                    friends.email as friend_email
                    from users
                    left join friendships on friendships.user1_id = users.id
                    left join users as friends on friendships.user2_id = friends.id
                    WHERE users.id = ?";
        $values = array($id);
        return $this->db->query($query,$values)->result_array();

    }

    public function get_non_friend($id){
        $query = "SELECT users.id as non_friend_id,users.name as non_friend_name,
                    users.alias as non_friend_alias
                    from users
                    where users.id not in(select friends.id as friend_id
                    from users
                    left join friendships on friendships.user1_id = users.id
                    left join users as friends on friendships.user2_id = friends.id
                    where users.id = ?) and (users.id !=?)";
        $values = array($id,$id);
        return $this->db->query($query,$values)->result_array();
    }

    public function add_friend($user_id1,$user_id2){
        $query = "INSERT INTO friendships (user1_id,user2_id,created_at) VALUES(?,?,NOW())";
        $values1 = array($user_id1,$user_id2);
        $values2 = array($user_id2,$user_id1);
        return ($this->db->query($query,$values1) && $this->db->query($query,$values2));
    }

    public function remove_as_friend($user_id1,$user_id2){
        $query = "DELETE FROM friendships
                WHERE user1_id = ? and user2_id = ?";
        $values1 = array($user_id1,$user_id2);
        $values2 = array($user_id2,$user_id1);
        return ($this->db->query($query,$values1) && $this->db->query($query,$values2));
    }

    public function get_other_user($id){
        $query = "SELECT id,name,alias,email
                    FROM users
                    WHERE id !=?";
        $values = array($id);
        return $this->db->query($query,$values)->result_array();
    }



   


}
?>