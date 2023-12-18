<?php 
function create_slug($name,$table)
{
    $ci =& get_instance();
    $count = 0;
    $name = strtolower(url_title($name));
    $slug_name = $name;
    while(true) 
    {
        $ci->db->select($table.'_id');
        $ci->db->where($table.'_slug', $slug_name);   // Test temp name
        $query = $ci->db->get($table);
        if ($query->num_rows() == 0) break;
        $slug_name = $name . '-' . (++$count);  // Recreate new temp name
    }
    return $slug_name;      // Return temp name
}

function update_slug($id, $name, $table)
{
    $ci =& get_instance();
    $count = 0;
    $name = strtolower(url_title($name));
    $slug_name = $name;
    while(true) 
    {
        $ci->db->select($table.'_id');
        $ci->db->where($table.'_id !=', $id);
        $ci->db->where($table.'_slug', $slug_name);   // Test temp name
        $query = $ci->db->get($table);
        if ($query->num_rows() == 0) break;
        $slug_name = $name . '-' . (++$count);  // Recreate new temp name
    }
    return $slug_name;      // Return temp name
}


?>