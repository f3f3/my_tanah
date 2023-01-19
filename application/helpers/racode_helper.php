<?php
function checked($val){
    return $val=="0"?"":"checked";
}
function akronim($s){
    $word = ["dan ","dengan ","atau ","serta "];
    foreach($word as $w){
        $s = str_replace($w,"",strtolower($s));
    }
    if(preg_match_all('/\b\w/',strtoupper($s),$m)) {
        return implode('',$m[0]);
    }
}

function cmb_dinamis($name,$table,$field,$pk,$selected=null,$order=null,$p=null){
    $ci = get_instance();
    $cmb = "<select name='$name' class='form-control'>";
    if($order){
        $ci->db->order_by($field,$order);
    }
    if($p){
        $ci->db->join('tbl_pengampu', 'tbl_pengampu.'.$pk.' = '.$table.'.'.$pk);
		$ci->db->where('tbl_pengampu.id_pengajar = '.$p);
    }
    $data = $ci->db->get($table)->result();
    foreach ($data as $d){
        $cmb .="<option value='".$d->$pk."'";
        $cmb .= $selected==$d->$pk?" selected='selected'":'';
        $cmb .=">".  strtoupper($d->$field)."</option>";
    }
    $cmb .="</select>";
    return $cmb;  
}

function cmb_template($name,$table,$field,$key,$selected=null,$data=[]){
    $ci = get_instance();
    $cmb = '<select name="'.$name.'" class="form-control" >';
    
    if(!empty($data["order"])){
        $ci->db->order_by($field,$data["order"]);
    }
    if(!empty($data["join"]) && is_array($data["where"])){
        $ci->db->join($data["join"]["table"], $data["join"]["table"].'.'.$data["join"]["key"].' = '.$table.'.'.$data["join"]["key"]);            
    }
    if(!empty($data["where"]) && is_array($data["where"])){
        if(empty($data["where"]["id"])) $data["where"]["id"] = "where";
        if(!empty($data["where"]["values"])){
            if(!empty($data["where"]["key"]))
                $ci->db->{$data["where"]["id"]}($data["where"]["key"],$data["where"]["values"]);
            else    
                $ci->db->{$data["where"]["id"]}($data["where"]["values"]);
        }                            
    }
    if(!empty($data["placeholder"]) && empty($selected)){
        $cmb .="<option hidden disabled selected>".$data["placeholder"]."</option>";
    }

    $datax = $ci->db->select($table.".".$field.",".$table.".".$key)->get($table)->result();
    foreach ($datax as $d){
        $cmb .='<option value="'.$d->$key.'"';
        $cmb .= $selected==$d->$key?' selected="selected"':'';
        $cmb .=">".strtoupper($d->$field)."</option>";
    }

    $cmb .="</select>";
    return $cmb;
}

function select2_dinamis($name,$table,$field,$pk,$selected=[],$placeholder){
    $ci = get_instance();
    $select2 = '<select name="'.$name.'" class="form-control select2 select2-hidden-accessible" multiple="" 
               data-placeholder="'.$placeholder.'" style="width: 100%;" tabindex="-1" aria-hidden="true">';
    $data = $ci->db->get($table)->result();
    foreach ($data as $row){
        $select2 .= ' <option value="'.$row->$pk.'"';
        $pls = "";
        if(is_array($selected)){
            $pls = in_array($row->$pk,$selected)?" selected='selected'":'';
            $pls = in_array($row->$field,$selected)?" selected='selected'":'';
        }
        $select2 .= $pls;
        $select2 .= '>'.$row->$field.'</option>';
    }
    $select2 .='</select>';
    return $select2;
}

function select2_teplate($name,$data,$field,$pk,$selected=[],$placeholder,$pls){
    $ci = get_instance();
    $select2 = '<select name="'.$name.'" class="form-control select2 select2-hidden-accessible" multiple="" 
               data-placeholder="'.$placeholder.'" style="width: 100%;" tabindex="-1" aria-hidden="true">';
    
    foreach ($data as $row){
        $select2 .= ' <option value="'.$row[$pk].'"';
        if(is_array($selected)){
            $select2 .= in_array($row[$pk],$selected)?" selected='selected'":'';
        }
        $select2 .= $pls;
        $select2 .= '>'.$row->$field.'</option>';
    }
    $select2 .='</select>';
    return $select2;
}

function datalist_dinamis($name,$table,$field,$value=null){
    $ci = get_instance();
    $string = '<input value="'.$value.'" name="'.$name.'" list="'.$name.'" class="form-control">
    <datalist id="'.$name.'">';
    $data = $ci->db->get($table)->result();
    foreach ($data as $row){
        $string.='<option value="'.$row->$field.'">';
    }
    $string .='</datalist>';
    return $string;
}

function rename_string_is_aktif($string){
    return $string=='y'?'Aktif':'Tidak Aktif';
}

function rename_string_is_online($string){
    return $string==1?'Online':'Offline';
}

function rename_string_is_approved($string){
    return $string==1?
    '<span class="fs-14 badge badge-pill badge-success" data-name="land_status_approved">Approved</span>':
    '<span class="fs-14 badge badge-pill badge-blue" data-name="land_status_approved">Pending</span>';    
}
function rename_string_to_url($string, $bc){
    return ($bc==0|$bc==3)?anchor(site_url('land/update/'.$string),'<i class="anticon anticon-edit" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-icon btn-sm btn-rounded')):"";
}

function is_login(){
    $ci = get_instance();
    if( !$ci->session->userdata('id_user_level')){
        redirect('auth');
    }else{
        $modul = $ci->uri->segment(1);
        if($ci->uri->segment(2)!="")
            $modul .= "/".$ci->uri->segment(2);
        //$modul = $ci->uri->uri_string();
        
        $id_user_level = $ci->session->userdata('id_user_level');
        // dapatkan id menu berdasarkan nama controller
        $ci->db->select("url");
        $ci->db->like('url', $modul, 'after');
        $ci->db->where("id_menu not in(select id_menu from tbl_hak_akses where id_user_level=$id_user_level)");
        $hak_akses = $ci->db->get_where('tbl_menu',"is_aktif='y'");
        //$id_menu = $menu['id_menu'];
        // chek apakah user ini boleh mengakses modul ini
        //$hak_akses = $ci->db->get_where('tbl_hak_akses',array('id_menu'=>$id_menu,'id_user_level'=>$id_user_level));
        $blocked = false;
        if($hak_akses->num_rows()>1){
            foreach($hak_akses->result_array() as $hk){
                if(preg_match("/^".preg_quote($hk["url"], '/')."/i", $ci->uri->uri_string())) {
                    if (strpos($hk["url"], '/') === false) {
                        var_dump($hk["url"]);
                        $blocked = true;
                    }
                }
            }
            if($blocked){
                //redirect('blokir');
                exit;
            }
        }
    }
}

function alert($class,$title,$description){
    return '<div class="alert '.$class.' alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> '.$title.'</h4>
                '.$description.'
              </div>';
}

// untuk chek akses level pada modul pemberian akses
function checked_akses($id_user_level,$id_menu){
    $ci = get_instance();
    $ci->db->where('id_user_level',$id_user_level);
    $ci->db->where('id_menu',$id_menu);
    $data = $ci->db->get('tbl_hak_akses');
    if($data->num_rows()>0){
        return "checked='checked'";
    }
}


function autocomplate_json($table,$field){
    $ci = get_instance();
    $ci->db->like($field, $_GET['term']);
    $ci->db->select($field);
    $collections = $ci->db->get($table)->result();
    foreach ($collections as $collection) {
        $return_arr[] = $collection->$field;
    }
    echo json_encode($return_arr);
}
