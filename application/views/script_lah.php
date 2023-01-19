<?php
    $cvb = $this->db->select("
        loc_village.village_id, 
        loc_village.village_name, 
        loc_sub_district.sub_district_name, 
        loc_districts.districts_name, 
        loc_province.province_name")
    ->join("loc_sub_district","loc_village.sub_district_id = loc_sub_district.sub_district_id")
    ->join("loc_districts","loc_sub_district.districts_id = loc_districts.districts_id")
    ->join("loc_province","loc_districts.province_id = loc_province.province_id")
    ->get("loc_village")->result_array();
    
    $result_cvb = [];
    foreach($cvb as $ids=>$row){
        $result_cvb[$row["village_id"]]=str_replace(" ","%20",($row["village_name"]." ".$row["sub_district_name"]." ".$row["districts_name"]." ".$row["province_name"]));
    }
    
    var_dump($result_cvb);
?>
<script>
	
</script>