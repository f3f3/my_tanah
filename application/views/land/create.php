<?php
$comments = (!empty($comments))?$comments:["none"=>null];
//var_dump(array_keys($comments));
//$button = "Update";
$land = (!empty($land))?$land:[
	"land_project_type_id"=>null,
	"land_status_type"=>null,
	"province_id"=>null,
	"districts_id"=>null,
	"sub_district_id"=>null,
	"village_id"=>null,
	"geolocation"=>null,
	"owner_initial_name"=>null,
	"owner_final_name"=>null,
	"owner_ppjb"=>null,
	"owner_annotation"=>null,
	"surface_area"=>null,
	"price_per_cubic_meter"=>null,
	"total_price"=>null,
	"land_id"=>null,
	"land_documents_code"=>null,
	"land_project_id"=>null,
	"land_mediator"=>null,
	"owner_id"=>null,
	"surface_area_id"=>null,
	"land_status_id"=>null,
	"map_id"=>null,
	"land_date"=>null,
	"land_physics_id"=>null
];

$upload = function($dataval) use ($button) {
	return [
		"type"=>"append",
		"value"=>[
			'<button data-val="'.$dataval.'" data-method="2" data-operate="2" class="btn btn-primary btn-xi" '.($button!='Update'?"disabled":"").'><i class="anticon anticon-folder-open anticon-lg"></i></button>'
		]
	];
};

$multi_form_labeled_input = function ($label, $id, $hide_label = false, $value = [["id"=>"","label"=>"","value"=>"","placeholder"=>"","title"=>"","extra"=>[]]]) use ($button,$comments) {
	$result = ($button!="Create" && in_array($label, array_keys($comments))) ?
		'<span class="comment" rel="comments" data-placement="right" data-name="'.$label.'" data-content="'.$comments[$label].'"></span>' : "";
	//$append = '<div class="form-group">';
	$append = $result.form_label($label, $id);
	$append .= '<div class="line-up mbm-5">';
	foreach($value as $row){
		$append .= '<div class="form-group w-100 r-5"><div class="input-group">';
		$append .= $hide_label?'':'<span class="input-group-addon" id="'.$row["id"].'" data-toggle="tooltip" data-placement="top" title="'.$row["title"].'">'.$row["label"].'</span>';
		//$append .= form_label($row["label"], $row["id"], ["class"=>($hide_label?"sr-only":"")]);
		$extra = array_merge($row["extra"], ['class' => 'form-control', 'placeholder' => $row["placeholder"]]);
		$append .= form_input($row["id"], $row["value"], $extra);
		$append .= '<span class="input-group-addon"><span style="font-family: fantasy;">M<sup>2</sup></span></span>';
		$append .= '</div></div>';
	}
	$append .= '</div>';

	return $append;
};
$form_labeled_input = function ($label, $id, $extra = null, $prefix = null, $value = null) use ($button,$comments) {
	$prefix = !empty($prefix) ? $prefix . '[' . $id . ']' : $id;
	//$result = ($button != "Create") ? form_checkbox($prefix, null, false, ['id' => $id]) : "";
	$result = ($button!="Create" && in_array($label, array_keys($comments))) ? '<span class="comment" rel="comments" data-placement="right" data-name="'.$label.'" data-content="'.$comments[$label].'"></span>' : "";
	$append = '<div class="form-group">' . $result . form_label($label, $id);

	if(!empty($extra["button"])){
		$append .= '<div class="input-group mb-3">';
		if($extra["button"]["type"]=="prepend")
			$append .= '<div class="input-group-prepend">'.implode("", $extra["button"]["value"]).'</div>';
	}

	$placeholder = !empty($extra["placeholder"])?$extra["placeholder"]:"";
	$append .= form_input($id, $value, ['class' => 'form-control', 'placeholder' => $placeholder, "autocomplete"=>"off"]);

	if(!empty($extra["button"])){
		if($extra["button"]["type"]=="append")
			$append .= '<div class="input-group-append">'.implode("", $extra["button"]["value"]).'</div>';
		$append .= '</div>';
	}

	$append .= '</div>';

	return $append;
};

$form_labeled_dropdown = function ($label, $name, $table, $field, $key, $selected = null, $extra, $prefix = null) use ($button,$comments) {
	$prefix = !empty($prefix) ? $prefix . '[' . $key . ']' : $key;
	//$result = ($button != "Create") ? form_checkbox($prefix, null, false, ['id' => $key]) : "";
	$result = ($button!="Create" && in_array($label, array_keys($comments))) ? '<span class="comment" rel="comments" data-placement="right" data-name="'.$label.'" data-content="'.$comments[$label].'"></span>' : "";

	$append = '<div class="form-group">' . $result . form_label($label, $name);

	if(!empty($extra["button"])){
		$append .= '<div class="input-group mb-3">';
		if($extra["button"]["type"]=="prepend")
			$append .= '<div class="input-group-prepend">'.implode("", $extra["button"]["value"]).'</div>';
	}
	
	if(!empty($extra["must_selected"])){
		if(($extra["must_selected"]==true) && !empty($selected))
			$append .= cmb_template($name, $table, $field, $key, $selected, $extra);
		else $append .= '<select name="'.$name.'" class="form-control" readonly>
					<option hidden="" disabled="" selected="">'.$extra["placeholder"].'</option>
				</select>';
	} else $append .= cmb_template($name, $table, $field, $key, $selected, $extra);
	
	if(!empty($extra["button"])){
		if($extra["button"]["type"]=="append")
			$append .= '<div class="input-group-append">'.implode("", $extra["button"]["value"]).'</div>';
		$append .= '</div>';
	}

	$append .= '</div>';

	return $append;
};
$form_labeled_custom = function ($label, $name, $table, $field, $key, $selected = null, $extra=[], $prefix = null) use ($button,$comments) {
	$prefix = !empty($prefix) ? $prefix . '[' . $key . ']' : $key;
	//$result = ($button != "Create") ? form_checkbox($prefix, null, false, ['id' => $key]) : "";
	$result = ($button!="Create" && in_array($label, array_keys($comments))) ? '<span class="comment" rel="comments" data-placement="right" data-name="'.$label.'" data-content="'.$comments[$label].'"></span>' : "";
	$append = '<div class="form-group">' . $result . form_label($label, $name) . '<div class="line-up">'; 
	
	if(!empty($extra["must_selected"]) && ($extra["must_selected"]==true) && !empty($selected)){
		//$append .= cmb_template($name, $table, $field, $key, $selected, $extra);
	} else {
		$append .= '<select name="'.$name.'" class="form-control" readonly>
					<option hidden="" disabled="" selected="">'.$extra["placeholder"].'</option>
				</select>';
	}

	$append .= form_input($key, null, ['id' => 'input_' . $key, 'class' => 'form-control']) .
				form_button($name, '+', ['class' => 'btn btn-primary']) .
				'</div></div>';

	return $append;
};
$cmb_box = function ($label, $id, $prefix = null) use ($button,$comments) {
	$prefix = !empty($prefix) ? $prefix . '[' . $id . ']' : $id;
	//$result = ($button != "Create") ? form_checkbox($prefix, null, false, ['id' => $id]) : "";
	$result = ($button!="Create" && in_array($label, array_keys($comments))) ? '<span class="comment" rel="comments" data-placement="right" data-name="'.$label.'" data-content="'.$comments[$label].'"></span>' : "";
	$array_row = [
		["ASLI", "COPY", "N/A"],
		["ADA", "TIDAK", "N/A"],
		["PERLU", "TIDAK PERLU", "N/A"]
	];
	$string_all = '<div class="form-group">';
	$string_all .= $result;
	$string_all .= '<label>' . $label . '</label>';
	$string_all .= '<div class="line-up">';
	foreach ($array_row as $row) {
		$string_all .= '<select name="col_' . $id . '_doc[]" class="form-control">';
		$string_all .= '<option hidden disabled selected>- - -</option>';
		foreach ($row as $ids => $col) {
			$string_all .= '<option value="' . $ids . '">' . $col . '</option>';
		}
		$string_all .= "</select>";
	}
	$string_all .= form_input('col_' . $id . '_doc[]', null, ['class' => 'form-control', 'placeholder' => 'keterangan']);
	$string_all .= '<button data-val=' . $id . ' data-method=2 class="btn btn-success btn-xi" data-operate="1" style="overflow: unset; margin-right:5px" '.($button!='Update'?"disabled":"").'>
			<span class="glyphicon glyphicon-folder-open"></span>
		</button>';
	$string_all .= "</div></div>";
	return $string_all;
};
?>

<?php /*
<script src='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.js'></script>
<link href='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.css' rel='stylesheet' />

<link href='<?php echo base_url() ?>assets/leaflet-easybutton/src/easy-button.css' rel='stylesheet' />
<script src="<?php echo base_url() ?>assets/leaflet-easybutton/src/easy-button.js"></script>

<link href='<?php echo base_url() ?>assets/leaflet-measure-path/leaflet-measure-path.css' rel='stylesheet' />
<script src="<?php echo base_url() ?>assets/leaflet-measure-path/leaflet-measure-path.js"></script>

<link href="<?php echo base_url() ?>assets/leaflet-draw/leaflet.draw.css" rel='stylesheet' />
<script src="<?php echo base_url() ?>assets/leaflet-draw/leaflet.draw.js"></script> */ ?>


<script src="https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.css" rel="stylesheet" />
<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v3.0.11/turf.min.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.css" type="text/css" />

<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css" type="text/css" />

<link href="<?=base_url("assets/enlink")?>/vendors/select2/select2.min.css" rel="stylesheet">
<link href="<?=base_url("assets/enlink")?>/vendors/select2/select2-bootstrap4.min.css" rel="stylesheet">

<link rel="stylesheet" href="<?=base_url()?>assets/bootstrap-fileinput/css/fileinput.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/year-picker/dist/yearpicker.min.css">

<link href="<?=base_url()?>assets/jquery-confirm/dist/jquery-confirm.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/toastr/css/toastr.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css" />

<style>
	.input-group.nowrap {
		flex-wrap: nowrap !important;
	}
	.h-100 {
		height: 100%;
	}
	.w-unset {
		width: unset !important;
	}
	.f-auto {
		flex: auto !important;
	}
	.fy {
		font-family: monospace;
	}
	.flexy, .nixsy {
		position: relative;
		display: flex;
		align-items: stretch;
		width: 100%;
	}
	.flexy .input-affix:first-child {
		width: unset;
		flex: 0 0 50%;
	}
	.yearpicker-header {
		height: unset;
	}
	.yearpicker-container {
		left: calc(100% - 200px);
		bottom: 42px;
		font-size: 14px;
		width: 200px;
		z-index: 991;
	}
	.yearpicker-prev, .yearpicker-current, .yearpicker-next {
		font-size: 2rem;
	}
	.yearpicker-current {
		font-size: 1rem;
	}
	.yearpicker-items {
		padding: .5rem;
	}
	.push-push.add-line, .push-push.add-coordinate {
		position: absolute;
		right: 5px;
		cursor: pointer;
		font-size: 2rem;
	}
	.bg-gradient-primary {
		background: linear-gradient(to left, #be5fca 0%, #5fa6ca 100%);
		color: #fff !important;
	}
	.bg-gradient-success {
		background: linear-gradient(to left, #be5fca 0%, #56b6b6 100%);
		color: #fff !important;
	}
	.bg-gradient-info {
		background: linear-gradient(to left, #be5fca 0%, #72b891 100%);
		color: #fff !important;
	}
	.s_btn, .p_btn, .t_btn {
		position: absolute;
		top: 0;
		right: 11px;
		cursor: pointer;
	}
	.t_btn {
		right: 132px;
	}
	.mat25 {
		margin-top: 2.5px;
	}
	.p_btn {
		font-size: 34.5px;
		color: #fff;
		background: none;
		border: none;
	}
	.p_btn:disabled{
		color: #666;
		cursor: not-allowed;
	}
	.p_btn:not(:disabled):hover, .p_btn:not(:disabled):active, .p_btn:not(:disabled):focus {
		color: #5ec87c;
		outline: none;
	}
	.select2-container--bootstrap4 .select2-selection--single {
		height: calc(1.5em + .75rem + 7px)!important;
	}
	.custom_size, .select_size {
		max-width: unset;
	}
	.zup {
		z-index: 1060;
	}
	.acc-lock:after{
		content: "\e06c" !important;
		font-family: "anticon" !important;
		transform: none !important;
	}
	#map {
		position: absolute;
		top: 0;
		bottom: 0;
		right: 0;
		left: 0;
		height: 500px;
	}
	.map-power {
		height: 450px;
	}
	.file-caption-main > .wfile {
		position: relative;
		flex: 1 1 auto;
		width: 1%;
		margin-bottom: 0;
		border-bottom-right-radius: unset;
    	border-top-right-radius: unset;
	}
	.anticon-lg {
		font-size: 1.33333em;
		vertical-align: -0.31em;
	}
	.file-zoom-dialog .anticon,
	.theme-anticon .anticon {
		line-height: unset;
	}
	.cshow {
		overflow: visible !important;
	}
	.remSin {
		border: none !important;
		box-shadow: none !important;
		background-color: unset !important;
		width: calc(100% - 35px);
		margin-left: 20px;
		margin-right: -20px;
	}

	span.comment {
        font-family: "anticon" !important;
        display: inline-block;
		color: #bc3c3c;
        font-size: large;
    }
    span.comment:hover {
    	color: #3c8dbc;
       	cursor: pointer;
    }
    span.comment:before {
        content: "\e078";
        letter-spacing: 10px;
    }
    span.comment.ed:after {
        content: "\e06a";
		-webkit-animation: 1s linear infinite loadingCircle;
		animation: 1s linear infinite loadingCircle;
		position: absolute;
		left: 11px;
		/* top: 80px; */
		font-size: 26px;
		line-height: 27px;
    }
	span.comment.ed.et:after {
        left: 71px;
    }
	span.comment.ed.at:after {
        left: -4px;
    }
	.top_right {
		position: absolute;
		right: -13px;
		top: -13px;
		z-index: 3;
	}
	.top_right span.comment.ed:after {
		left: -3px;
	}
	.check-button {
		padding: 4px;
		margin-left: 10px;
	}
	.input-group-a {
		position: relative;
		display: flex;
		align-items: stretch;
		width: 100%;
	}
</style>
<div class="page-header">
    <h2 class="header-title">CREATE</h2>
    <div class="header-sub-title">
        <nav class="breadcrumb breadcrumb-dash">
            <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>HOME</a>
            <a class="breadcrumb-item" href="#">LAND</a>
            <span class="breadcrumb-item active"><?=$button!="Update"?"CREATE":"UPDATE"?></span>
        </nav>
    </div>
</div>

<form action="<?php echo $action; ?>" method="post" id="fompt">
<div class="accordion show" id="accordion-tanah">
    <div class="card cshow">
        <div class="card-header ">
            <h5 class="card-title">
                <a class="bg-gradient-primary dust <?=$button!='Update'?"acc-lock":""?>" data-toggle="collapse" href="#dataTanah" aria-expanded="true">
                    <span>Data Tanah</span>
				</a>
            </h5>
			<?php if($button=='Update') { ?>
				<button id="setToUpdate" class="s_btn btn btn-primary m-r-5 m-t-5">
					<i class="anticon anticon-loading m-r-5"></i>
					<i class="anticon anticon-login m-r-5"></i>
					<span>Update</span>
				</button>
			<?php } ?>
        </div>
        <div id="dataTanah" class="collapse show" data-parent="#accordion-tanah">
            <div class="card-body">
				<div class="row display-flex">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
						<fieldset class="border p-2 h-100">
							<legend  class="w-auto">Detail Tanah</legend>
							<div class="row display-flex">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<?= $form_labeled_input('Document Code', 'land_documents_code', null, "land", $land["land_documents_code"]) ?>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<?= $form_labeled_dropdown('Jenis Proyek', 'land_project_id', 'land_project_type', 'land_project_type_name', 'land_project_type_id', $land["land_project_type_id"], ["placeholder" => "-----Pilih Project-----", "button"=>$upload(71)], "status_tanah") ?>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<?= $form_labeled_dropdown('Status Fisik Tanah', 'land_physics_id', 'land_physics', 'land_physics_name', 'land_physics_id', $land["land_physics_id"], ["placeholder" => "-----Pilih Status Fisik-----", "button"=>$upload(72)], "status_tanah") ?>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<?= $form_labeled_input('Sumber (Mediator)', 'land_mediator', ["button"=>$upload(73)], "status_tanah", $land["land_mediator"]) ?>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 checklah">
									<div class="form-group d-flex align-items-center">
										<div class="switch m-r-10" style="position: relative;">
											<input type="checkbox" id="switch-1" name="land_di_patok">
											<label for="switch-1"></label>
										</div for="land_di_patok">
										<label>Tanah Sudah Dipatok</label>
										<button data-val="74" data-method="2" data-operate="2" class="btn btn-primary btn-xi check-button" <?=$button!='Update'?"disabled":""?>>
											<i class="anticon anticon-upload anticon-lg"></i>
										</button>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 checklah">
									<div class="form-group d-flex align-items-center">
										<div class="switch m-r-10" style="position: relative;">
											<input type="checkbox" id="switch-2" name="land_di_ptsl">
											<label for="switch-2"></label>
										</div>
										<label for="land_di_ptsl">Sudah Dalam PTSL</label>
										<button data-val="75" data-method="2" data-operate="2" class="btn btn-primary btn-xi check-button" <?=$button!='Update'?"disabled":""?>>
											<i class="anticon anticon-upload anticon-lg"></i>
										</button>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
						<fieldset class="border p-2 h-100">
							<legend  class="w-auto">
								Alamat
								<button data-val="76" data-method="2" data-operate="2" class="btn btn-primary btn-xi check-button" <?=$button!='Update'?"disabled":""?>>
									<i class="anticon anticon-upload anticon-lg"></i>
								</button>
							</legend>
							<div class="row display-flex">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<?= $form_labeled_dropdown('Provinsi', 'map_province_id', 'loc_province', 'province_name', 'province_id', $land["province_id"], ["placeholder" => "-----Pilih Provinsi-----"], "status_tanah"); ?>
								</div>
								<?php
									echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">';
									echo $form_labeled_dropdown('Kabupaten/Kota','map_districts_id','loc_districts','districts_name','districts_id',$land["districts_id"],
										[
											"placeholder" => "-----Pilih Kabupaten/Kota-----",
											"must_selected" => true,
											"where" =>[
												"id"=>"where",
												"key"=>"province_id",
												"values"=>$land["province_id"],
											]
										], "status_tanah"
									);
									echo '</div>';

									echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">';
									echo $form_labeled_dropdown('Kecamatan','map_sub_district_id','loc_sub_district','sub_district_name','sub_district_id',$land["sub_district_id"],
										[
											"placeholder" => "-----Pilih Kecamatan-----",
											"must_selected" => true,
											"where" =>[
												"id"=>"where",
												"key"=>"districts_id",
												"values"=>$land["districts_id"],
											]
										], "status_tanah"
									);
									echo '</div>';

									echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">';
									echo $form_labeled_dropdown('Desa/Kelurahan','map_village_id','loc_village','village_name','village_id',$land["village_id"],
										[
											"placeholder" => "-----Pilih Desa/Kelurahan-----",
											"must_selected" => true,
											"where" =>[
												"id"=>"where",
												"key"=>"sub_district_id",
												"values"=>$land["sub_district_id"],
											]
										], "status_tanah"
									);
									echo '</div>';
								?>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
										<?=($button!="Create" && in_array("vgeolocation", array_keys($comments))) ? '<span class="comment" rel="comments" data-placement="right" data-name="vgeolocation" data-content="'.$comments["vgeolocation"].'"></span>' : "";?>
										<label for="map_geolocation">Geolocation</label>
										<div class="input-group mb-3">
										<input type="text" name="map_geolocation" readonly placeholder="geolocation" class="form-control" value='<?=$land["geolocation"]?>' >
											<div class="input-group-append">
												<button class="btn btn-success btn-map" <?=$button!='Update'?"disabled":""?>>
													<i class="anticon anticon-environment anticon-lg"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mt-1">
						<fieldset class="border p-2 h-100">
							<legend  class="w-auto">Pemilik Tanah</legend>
							<div class="row display-flex">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<?= $form_labeled_input('Pemilik Asal', 'owner_initial_name', ["placeholder" => 'Pemilik Asal', "button"=>$upload(77)], "nama_pemilik", $land["owner_initial_name"]) ?>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<?= $form_labeled_input('Pemilik Baru', 'owner_final_name', ["placeholder" => 'Pemilik Baru', "button"=>$upload(78)], "nama_pemilik", $land["owner_final_name"]) ?>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<?= $form_labeled_input('PPJB Atas Nama', 'owner_ppjb', ["placeholder" => 'PPJB Atas Nama', "button"=>$upload(79)], "nama_pemilik", $land["owner_ppjb"]) ?>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<?= $form_labeled_input('Keterangan', 'owner_annotation', ["placeholder" => 'Keterangan'], "nama_pemilik", $land["owner_annotation"]) ?>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mt-1">
						<fieldset class="border p-2 h-100">
							<legend  class="w-auto">Luas Tanah</legend>
							<div class="row display-flex">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
										<label for="by_doc">Berdasarkan Surat</label>
										<div class="input-group nowrap mb-3">
											<div class="input-affix w-unset">
												<input type="text" name="surface_area_by_doc" value="" data-mask="000.000.000.000.000" data-mask-reverse="true" class="form-control x_surface" placeholder="Luas Tanah" autocomplete="off" maxlength="19">
												<span class="suffix-icon fy">M<sup>2</sup></span>
											</div>
											<div class="input-group-append">
												<button data-val="80" data-method="2" data-operate="2" class="btn btn-primary btn-xi" <?=$button!='Update'?"disabled":""?>>
													<i class="anticon anticon-folder-open anticon-lg"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
										<label for="by_doc">Berdasarkan Pengukuran Ulang</label>
										<div class="input-group nowrap mb-3">
											<div class="input-affix">
												<input type="text" name="surface_area_by_remeas" value="" data-mask="000.000.000.000.000" data-mask-reverse="true" class="form-control x_surface" placeholder="Luas Tanah" autocomplete="off" maxlength="19">
												<span class="suffix-icon fy">M<sup>2</sup></span>
											</div>
											<div class="input-group-append">
												<button data-val="81" data-method="2" data-operate="2" class="btn btn-primary btn-xi" <?=$button!='Update'?"disabled":""?>>
													<i class="anticon anticon-folder-open anticon-lg"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
										<label for="by_doc">Berdasarkan GPS</label>
										<div class="input-group nowrap mb-3">
											<div class="input-affix">
												<input type="text" name="surface_area_by_geo" value="" data-mask="000.000.000.000.000" data-mask-reverse="true" class="form-control x_surface" placeholder="Luas Tanah" autocomplete="off" maxlength="19">
												<span class="suffix-icon fy">M<sup>2</sup></span>
											</div>
											<div class="input-group-append">
												<button data-val="82" data-method="2" data-operate="2" class="btn btn-primary btn-xi" <?=$button!='Update'?"disabled":""?>>
													<i class="anticon anticon-folder-open anticon-lg"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
						<div style="float:right">
						<?php
							if($button=="Create"){
								echo '<button class="btn btn-primary next-tab" data-toggle="collapse" href="#dataKeuangan">NEXT</button>';
							}
						?>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
	<div class="card cshow">
        <div class="card-header">
            <h5 class="card-title">
                <a class="collapsed bg-gradient-success dust <?=$button!='Update'?"acc-lock":""?>" data-toggle="collapse" href="#dataKeuangan" aria-expanded="false">
                    <span>Data Keuangan</span>
				</a>
			</h5>
        </div>
        <div id="dataKeuangan" class="collapse" data-parent="#accordion-tanah">
            <div class="card-body">
				<div class="row display-flex">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mt-1">
						<fieldset class="border p-2 h-100">
							<legend class="w-auto">Initial Price
								<button data-val="85" data-method="2" data-operate="2" class="btn btn-primary btn-xi check-button" <?=$button!='Update'?"disabled":""?>>
									<i class="anticon anticon-upload anticon-lg"></i>
								</button>
							</legend>
							<div class="row display-flex by_market">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 purchases">
									<div class="line-up mbm-5">
										<div class="form-group w-100">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px;">
												<div class="form-group by_purchase">
													<div class="flexy">
														<div class="input-affix w-unset f-auto">
															<input type="text" name="surface_area_by_purchase" value="" data-mask="000.000.000.000.000" data-mask-reverse="true" class="form-control x_surface" placeholder="Luas Tanah" autocomplete="off" maxlength="19">
															<span class="suffix-icon fy">M<sup>2</sup></span>
														</div>
														<div class="input-affix w-unset f-auto">
															<span class="prefix-icon fy">RP</span>
															<input type="text" data-id="surface_data[1]" name="surface_data[1][1][1]" value="" class="form-control" placeholder="Harga" data-mask="000.000.000.000.000" data-mask-reverse="true" autocomplete="off" maxlength="19">
														</div>
														<div class="input-affix w-unset f-auto">
															<input type="text" data-id="surface_data[1]" name="surface_data[1][1][2]" value="" class="form-control valid" placeholder="Tahun" data-toggle="yearpicker" aria-invalid="false">
															<i class="suffix-icon anticon anticon-calendar"></i>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mt-1">
						<fieldset class="border p-2 h-100">
							<legend class="w-auto">Luas Pembelian
								<button data-val="85" data-method="2" data-operate="2" class="btn btn-primary btn-xi check-button" <?=$button!='Update'?"disabled":""?>>
									<i class="anticon anticon-upload anticon-lg"></i>
								</button>
							</legend>
							<div class="row display-flex">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 line-child">
									<div class="line-up mbm-5">
										<div class="form-group w-100">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px;">
												<div class="form-group">
													<div class="flexy">
														<div class="input-affix w-unset f-auto">
															<input type="text" name="surface_area_by_purchase_doc" value="" data-mask="000.000.000.000.000" data-mask-reverse="true" class="form-control x_surface" placeholder="Luas Ukur Pembelian" autocomplete="off" maxlength="19">
															<span class="suffix-icon fy">M<sup>2</sup></span>
														</div>
														<div class="input-affix w-unset f-auto">
															<input type="text" name="surface_area_by_purchase_ukur" value="" data-mask="000.000.000.000.000" data-mask-reverse="true" class="form-control x_surface" placeholder="Luas Surat Pembelian" autocomplete="off" maxlength="19">
															<span class="suffix-icon fy">M<sup>2</sup></span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
				<div class="row display-flex">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mt-1">
						<fieldset class="border p-2 h-100">
							<legend class="w-auto">Market Price<span class="push-push add-line add-market" data-id="2"><i class="anticon anticon-plus-circle"></i></span></legend>
							<div class="row display-flex by_market">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 line-child">
									<div class="line-up mbm-5">
										<div class="form-group w-100">
											<div class="input-group nowrap">
												<div class="input-affix w-unset f-auto">
													<span class="prefix-icon fy">RP</span>
													<input type="text" data-id="surface_data[2]" name="surface_data[2][1][1]" value="" class="form-control" placeholder="Harga" data-mask="000.000.000.000.000" data-mask-reverse="true">
													<span class="suffix-icon fy">M<sup>2</sup></span>
												</div>
												<div class="input-affix w-unset f-auto">
													<input type="text" data-id="surface_data[2]" name="surface_data[2][1][2]" data-unequal="market" value="" placeholder="Tahun" class="form-control" data-toggle="yearpicker">
													<i class="suffix-icon anticon anticon-calendar"></i>
												</div>
												<div class="input-group-append">
													<button type="button" class="btn btn-success calculate" data-toggle="tooltip" data-placement="top" title="" data-original-title="Kalkulasi Harga Total"><i class="anticon anticon-calculator anticon-lg"></i></button>
													<button type="button" class="btn btn-danger remover"><i class="anticon anticon-delete anticon-lg"></i></span></button>
													<button data-val="83" data-year="0000" data-method="2" data-operate="2" class="btn btn-primary btn-xi harga" <?=$button!='Update'?"disabled":""?>><i class="anticon anticon-folder-open anticon-lg"></i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mt-1">
						<fieldset class="border p-2 h-100">
							<legend class="w-auto">NJOP<span class="push-push add-line add-njop" data-id="3"><i class="anticon anticon-plus-circle"></i></span></legend>
							<div class="row display-flex by_njop">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 line-child">
									<div class="line-up mbm-5">
										<div class="form-group w-100">
											<div class="input-group nowrap">
												<div class="input-affix w-unset f-auto">
													<span class="prefix-icon fy">RP</span>
													<input type="text" data-id="surface_data[3]" name="surface_data[3][1][1]" value="" class="form-control" placeholder="Harga" data-mask="000.000.000.000.000" data-mask-reverse="true">
													<span class="suffix-icon fy">M<sup>2</sup></span>
												</div>
												<div class="input-affix w-unset f-auto">
													<input type="text" data-id="surface_data[3]" data-unequal="njop" name="surface_data[3][1][2]" value="" class="form-control" placeholder="Tahun" data-toggle="yearpicker">
													<i class="suffix-icon anticon anticon-calendar"></i>
												</div>
												<div class="input-group-append">
													<button type="button" class="btn btn-success calculate" data-toggle="tooltip" data-placement="top" title="" data-original-title="Kalkulasi Harga Total"><i class="anticon anticon-calculator anticon-lg"></i></button>
													<button type="button" class="btn btn-danger remover"><i class="anticon anticon-delete anticon-lg"></i></span></button>
													<button data-val="84" data-year="0000" data-method="2" data-operate="2" class="btn btn-primary btn-xi harga" <?=$button!='Update'?"disabled":""?>><i class="anticon anticon-folder-open anticon-lg"></i></button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
						<div style="float:right">
						<?php
							if($button=="Create"){
								echo '<button class="btn btn-primary" data-toggle="collapse" href="#dataTanah">BACK</button>';
								echo '<button class="btn btn-success initial-save mr-3">SAVE</button>';
							}
						?>
						</div>
					</div>
				</div>
        	</div>
        </div>
    </div>
    <div class="card cshow">
        <div class="card-header">
            <h5 class="card-title">
                <a class="collapsed bg-gradient-info dust <?=$button!='Update'?"acc-lock":""?>" data-toggle="collapse" href="#dokumentTanah" aria-expanded="false">
                    <span>Dokumen Tanah</span>
				</a>
				<button class="p_btn popover_select2"><i class="anticon anticon-appstore" <?=$button!='Update'?"disabled":""?>></i></button>
			</h5>
        </div>
        <div id="dokumentTanah" class="collapse" data-parent="#accordion-tanah">
            <div class="card-body">
				<div class="row" id="sp_row">
				</div>
			</div>
        </div>
    </div>
</div>
<?php
	if(!empty($initial))
	foreach($initial as $row){
		echo "<input type='hidden' name='$row' value='$land[$row]'>";
	}
?>
</form>

<!-- Modal -->
<div class="modal fade" id="tambahDoc" tabindex="-1" role="dialog" aria-labelledby="tambahDocTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahDocTitle">Upload File</h5>
      </div>
      <div class="modal-body">
	  	<div class="form-group">
			<div id="file-wrap">
				<div class="file-loading">
					<input name="x_file" type="file" multiple class="file">
				</div>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Done</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tambahMap" tabindex="-1" role="dialog" aria-labelledby="tambahMapTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahMapTitle">Geolocation</h5>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 mt-1">
	  			<div class="map-power"><div id="map"></div></div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mt-1">
				<fieldset id="f_coordinate" class="border p-2">
					<legend class="w-auto">Coordinates
						<label for="file-input" class="btn btn-primary ml-3 p-1">
							<i class="anticon anticon-upload anticon-lg"></i>
						</label>
						<input id="file-input" name="kml-file" type="file" style="display:none"/>

						<span class="push-push add-coordinate">
							<i class="anticon anticon-plus-circle"></i>
						</span>
					</legend>
					<div class="row display-flex by_market" style="overflow-y: scroll; height: 440px; align-content: flex-start;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 line-child">
							<div class="line-up mbm-5">
								<div class="form-group w-100">
									<div class="input-group nowrap">
										<div class="input-affix w-unset f-auto">
											<span class="prefix-icon fy">C1</span>
											<input type="text" data-num=1 data-id="coordinates" name="coordinates[]" value="" class="form-control" placeholder="Coordinate 1">
										</div>
										<div class="input-group-append">
											<button type="button" data-num=1 class="btn btn-danger remover-coordinate"><i class="anticon anticon-delete anticon-lg"></i></span></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="save_mat" class="btn btn-success">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- load the third party plugin assets (jquery-confirm) -->
<script type="text/javascript" src="<?=base_url()?>assets/jquery-confirm/dist/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-fileinput/js/fileinput.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-fileinput/themes/anticon/theme.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-fileinput/js/plugins/piexif.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-fileinput/js/plugins/purify.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-fileinput/js/plugins/sortable.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/moment/dist/moment.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/moment/dist/id.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/year-picker/dist/yearpicker.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/toastr/js/toastr.min.js"></script>
<script type="text/javascript" src="<?=base_url("assets/enlink")?>/vendors/select2/select2.min.js"></script>
<script type="text/javascript" src="<?=base_url("assets/togeojson")?>/togeojson.js"></script>
<script>
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": true,
		"progressBar": true,
		"positionClass": "toast-bottom-right",
		"preventDuplicates": true,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut",
		"tapToDismiss": false
	}
	$.fn.datetimepicker.defaults.icons = {
		time: 'anticon anticon-clock-circle',
		date: 'anticon anticon-calendar',
		up: 'anticon anticon-up',
		down: 'anticon anticon-down',
		previous: 'anticon anticon-left',
		next: 'anticon anticon-right',
		today: 'anticon anticon-pushpin',
		clear: 'anticon anticon-delete',
		close: 'anticon anticon-close'
	};

	var asimetris = true;
	$('#accordion-tanah').on('show.bs.collapse', function (e,v) {
		if(asimetris){
			$(".popover_select2").attr("disabled", ($(e.target).attr("id") != "dokumentTanah"));
			<?php if($button!='Update') { ?>
				$("#setToUpdate").attr("disabled", ($(e.target).attr("id") != "dataTanah"));
			<?php } ?>
		}
	});

	var escalate = true; var comments = {};
    comment_ele = (name, commented)=>{
        return comments[name]!==undefined?$("<span>",{
        //return escalate?$("<span>",{
            class:"comment ed",
            rel:"comments",
            "data-placement":"right",
            "data-comment":name
        }):false;
	}

	$(document).delegate('[rel="comments"]', "click", (e)=>{
        var selfis = $(e.target);
        var summernote = "";
        var summernote_toolbar = [];
        $.confirm({
            title: 'Comment',
            columnClass: 'xlarge',
            content: '<textarea id="summernote" name="editordata"></textarea>',
            onOpenBefore: function(){
                summernote = this.$content.find('#summernote');
                summernote.summernote({
                    height: 300,
                    toolbar: summernote_toolbar
                });
                summernote.summernote('foreColor', 'black');
                summernote.summernote('fontName', 'Poppins');
				summernote.summernote("code", comments[selfis.data("comment")]);
				summernote.summernote("disable");
            },
            buttons: {later: function(){}}
        });
    });

	var $arrays=[];
	$.getJSON('<?=base_url("land/select2_data/".(!empty($land_id)?$land_id:""))?>', function(data){
		$doc_file = [];
		Object.keys(data[0]).forEach(function(key) {
			$doc_file[data[0][key]["id"]] = data[0][key];
		});
		$arrays = data;
		<?php if($button=='Update'){ ?>
			//Initial
			$.post('<?=base_url("land/land_data")?>', {id:<?=$land_id?>}, function(data){
				comments = data.comments;
				$als = ["map_province_id","map_districts_id","map_sub_district_id","map_village_id","land_id"];
				$axs = ["",".by_purchase",".by_market",".by_njop"];
				$.each(data["land"], function(i,v){
					if(!$als.includes(i)){
						elmentz = $('[name="'+i+'"]');
						elmentz.val(v); plholdz = elmentz.attr('placeholder');
						if(plholdz=="Luas Tanah") elmentz.trigger("input");
						if($(elmentz).attr("type")=="checkbox") elmentz.attr("checked", v==1);
					}
					if(i.includes("land_di_")||i.includes("surface_")) {
						var comters = comment_ele(i);
						comters = $("<div>",{class:"top_right"}).append(comters);
						//if(i.includes("land_di_") && comters!==false) comters.addClass("et");
						$('[name="'+i+'"]').parent().append(comters);						
					}
					else if(i=="map_geolocation")
						$('[name="'+i+'"]').parents(".input-group.mb-3").siblings().prepend(comment_ele(i));
					else $('label[for="'+i+'"]').prepend(comment_ele(i));
					//console.log(i);
				});
				$('[name="'+$als[0]+'"]').val(data["land"][$als[0]]);
				dom_location($als[0], data["land"][$als[0]], function(){
					$('[name="'+$als[1]+'"]').val(data["land"][$als[1]]);
					dom_location($als[1], data["land"][$als[1]], function(){
						$('[name="'+$als[2]+'"]').val(data["land"][$als[2]]);
						dom_location($als[2], data["land"][$als[2]], function(){
							$('[name="'+$als[3]+'"]').val(data["land"][$als[3]]);
						});
					});
				});
				$("#sp_row").append("<input type='hidden' name='"+$als[4]+"' value='"+data["land"][$als[4]]+"'>");
				$.each(data["surface_area"], function(i,v){
					$.each(v, function(x,z){
						if(["2","3"].includes(i)){
							if(x) add_line(i==2?$(".add-market"):$(".add-njop"));
						}
						$.each(z, function(a,b){
							if([0,1].includes(a)){
								var sf_name = 'surface_data['+(i)+']['+(1+x)+']['+(1+a)+']';
								elment = $('[name="'+sf_name+'"]');
								elment.val(b); plhold = $(elment).attr('placeholder');
								if(plhold=="Harga") {
									elment.trigger("input");
								} else {
									elment.parents(".nowrap").find(".btn-xi").attr("data-year",b).removeAttr("disabled");
								}
								//$(elment).after($("<span>",{class:"suffix-icon mr-3"}).append(comment_ele(sf_name).addClass("at")));
							} else {
								elment.parents(".nowrap").find(".btn-xi").attr("data-hid",b);
								elements = $($axs[i]+" .line-child").eq(x);
								if($axs[i]==".by_purchase") elements = $(".purchases");
								elements.append("<input type='hidden' \
									name='surface_id["+(i)+"]["+(1+x)+"]' data-id='surface_id["+(i)+"]' \
									value='"+b+"'>");
							}
						});
					});
				});
				$('[name^=surface_data]').each(function(i,v){
					var atemper = comment_ele(v.name);
					$(v).after($("<div>",{class:"top_right"}).append(atemper));
				});
				$.each(data["documents"], function(i,v){
					if($doc_file[i])
						$('#sp_row').append(sp_render($doc_file[i],v));
					else {
						$('[data-val="'+i+'"]').not(".harga").attr("data-id",v["document_id"]);
						if(Array.isArray(v)){
							$.each(v, function(c,a){
								$('[data-val="'+i+'"][data-hid="'+a["file_extra"][0]+'"]').attr("data-id",a["document_id"]);
							});
						}
					}
				});
				var htId = data.history.land_user_history_type_id;
				var stId = data.land.land_status_type_id;
				if(parseInt(htId)==1 || parseInt(stId)==1)
					$("#accordion-tanah .card-header:first").append(' \
						<button id="setToPosting" class="t_btn btn btn-warning m-r-5 m-t-5"> \
							<i class="anticon anticon-loading m-r-5"></i> \
							<i class="anticon anticon-upload m-r-5"></i> \
							<span>Posting</span> \
						</button> \
					');
				else if(parseInt(htId)!=3 || parseInt(stId)!=3) {
					$("#accordion-tanah").find("input, select, button").prop("disabled", true);
					$(".push-push").remove();
					asimetris = false;
				}

				set_validator();
				$('[placeholder="Tanggal"]').datetimepicker({ locale: 'id', Default: 'DD-MM-YYYY'});
			}, "JSON");
		<?php } ?>

		$(document).delegate('input:not([type="hidden"]), select',"change",function(e){
			if(!$(this).hasClass("changed"))
				$(this).addClass("changed");
		});
		$(".loading-wrap").fadeTo('slow', 0, function(){ $(".loading-wrap").remove(); });
	});

	function dom_clear($s){
		if (Array.isArray($s)) {
			$als_clear = [
				['[name=map_districts_id]',"Kabupaten/Kota"],
				['[name=map_sub_district_id]',"Kecamatan"],
				['[name=map_village_id]',"Desa/Kelurahan"],
			]
			$.each($s, function(i, v) {
				$($als_clear[v][0]).find('option').remove().end()
					.append('<option hidden="" disabled="" selected="">-----Pilih '+$als_clear[v][1]+'-----</option>');
			});
		}
	}
	function dom_location($name, $val, callback){
		d_n = $name; d_v = $val;
		dc = callback?callback:function(){};
		$url = {
			"map_province_id":["get_districts",'[name="map_districts_id"]'],
			"map_districts_id":["get_sub_districts",'[name="map_sub_district_id"]'],
			"map_sub_district_id":["get_village",'[name="map_village_id"]'],
		}
		$clr = [2];
		if(d_n=="map_province_id"){
			$('[name=map_districts_id]').attr("readonly", true);
			$clr.push(0);
		}
		if(["map_province_id","map_districts_id"].includes(d_n)){
			$('[name=map_sub_district_id]').attr("readonly", true);
			$clr.push(1);
		}
		$('[name=map_village_id]').attr("readonly", true);
		dom_clear($clr);

		$.post('<?= base_url("land") ?>/'+$url[d_n][0], {id: d_v}, function(data) {
			$.each(data, function(key, value) {
				$($url[d_n][1]).append($("<option></option>").attr("value", key).text(value));
			});
			$($url[d_n][1]).removeAttr("readonly");
			dc();
		}, 'json').fail(function() {
			console.log("Please check your code and try again!");
		});
	}
	function add_line(app){
		id_name = $(app).data("id");
		ele = $(app).parents("fieldset").find(".line-child");
		set = ele.length + 1;

		$(app).parents("fieldset").find(".row").append(
			$("<div>",{class:"col-xs-12 col-sm-12 col-md-12 col-lg-12 line-child"}).append(
				$("<div>",{class:"line-up mbm-5"}).append(
					$("<div>",{class:"form-group w-100"}).append(
						$("<div>",{class:"input-group nowrap"}).append(
							$("<div>",{class:"input-affix w-unset f-auto"}).append(
								$("<span>",{class:"prefix-icon fy"}).text("RP")
							).append(
								$("<input>",{
									type:"text",
									"data-id":"surface_data["+id_name+"]",
									name:"surface_data["+id_name+"]["+set+"][1]",
									value:"",
									class:"form-control",
									placeholder:"Harga"
								})
								.mask('000.000.000.000.000', {reverse: true})
							).append(
								$("<span>",{class:"suffix-icon fy"}).append("M<sup>2</sup>")
							)
						).append(
							$("<div>",{class:"input-affix w-unset f-auto"}).append(
								$("<input>",{
									type:"text",
									"data-id":"surface_data["+id_name+"]",
									name:"surface_data["+id_name+"]["+set+"][2]",
									value:"",
									class:"form-control",
									"data-unequal":(id_name==2?"market":"njop"),
									placeholder:"Tahun",
									"data-toggle":"yearpicker"
								})
								.datetimepicker({ locale: 'id', format: 'YYYY'})								
							).append(
								$("<i>",{class:"suffix-icon anticon anticon-calendar"})
							)
						).append(
							$("<div>",{class:"input-group-append"}).append(
								$("<button>",{
									type:"button",
									class:"btn btn-success calculate",
									"data-toggle":"tooltip",
									"data-placement":"top",
									"title":"",
									"data-original-title":"Kalkulasi Harga Total"
								}).append($("<i>",{class:"anticon anticon-calculator anticon-lg"})).tooltip()
							).append(
								$("<button>",{
									type:"button",
									class:"btn btn-danger remover harga"
								})
								.append($("<i>",{class:"anticon anticon-loading anticon-lg"}))
								.append($("<i>",{class:"anticon anticon-delete anticon-lg"}))
							).append(
								$("<button>",{
									type:"button",
									class:"btn btn-primary btn-xi harga",
									"disabled":true,
									"data-val":(id_name==2?"83":"84"),
									"data-year":"0000",
									"data-method":2,
									"data-operate":2,
								}).append($("<i>",{class:"anticon anticon-folder-open anticon-lg"}))
							)
						)
					)
				)
			)
		);

		$('[name="'+"surface_data["+id_name+"]["+set+"][1]"+'"]').rules("add", {rupiah: true, required: false})
		$('[name="'+"surface_data["+id_name+"]["+set+"][2]"+'"]').rules("add", {year: true, required: false, notEqual: '[data-unequal="'+(id_name==2?"market":"njop")+'"]'})

		/*ele = $(app).parents("fieldset").find(".line-child");
		set = ele.length + 1;
		bow = ele.first().clone();
		bow.find(".harga").attr("disabled",true);
		bow.find(".top_right").remove();
		unequal = "";
		the_name = [];
		bow.find("input").val("").removeClass("changed is-valid").each(function(i,v){
			if($(v).attr('type')=="hidden") {
				$(v).remove();
				return;
			}
			id_name = $(v).attr("data-id");
			
			$(v).attr('name',id_name+'['+set+']['+(i+1)+']');
			if(i==0) $(v).mask('000.000.000.000.000', {reverse: true});
			the_name.push(id_name+'['+set+']['+(i+1)+']');
			if(i) {
				//nobule();
				unequal=$(v).attr("data-unequal");
				$(v).datetimepicker({ locale: 'id', format: 'YYYY'});
				/-$(v).yearpicker({
					onHide:function(){ 
						$('[data-unequal="'+unequal+'"]').each(function(i, v){
							validator.element('[name="'+$(v).attr("name")+'"]');
						});
					},
					onChange:function(){
						$('[data-unequal="'+unequal+'"]').each(function(i, v){
							validator.element('[name="'+$(v).attr("name")+'"]');
						});
					}
				});-/
			}
		});
		bow.find('[data-toggle="tooltip"]').tooltip();
		$(app).parents("fieldset").find(".row").append(bow);
		$('[name="'+the_name[0]+'"]').rules("add", {rupiah: true, required: false});
		$('[name="'+the_name[1]+'"]').rules("add", {year: true, required: false, notEqual: '[data-unequal="'+unequal+'"]'});*/
	}
	$('[data-toggle="popover"]').popover();
	$('[name=map_province_id]').change(function() {
		dom_location(this.name, this.value);
	});
	$('[name=map_districts_id]').change(function() {
		dom_location(this.name, this.value);
	});
	$('[name=map_sub_district_id]').change(function() {
		dom_location(this.name, this.value);
	});
	$('[name=map_village_id]').change(function() {
		$(".btn-map").attr('disabled',false);
	});

	//SELEC2
	$(".popover_select2").click(function(e){
		e.preventDefault();
	});
	$(".popover_select2").popover({
		animation: false,
		html: true,
		sanitize: false,
		content: '<div class="d-flex align-items-center">'+
					'<div class="input-group">'+
						'<select name="input_doc" class="form-control w-100">'+
							'<option hidden="" disabled="" selected="">-----Pilih Documents-----</option>'+
						'</select>'+
						'<div class="input-group-append">'+
							'<button class="btn btn-success" id="button_doc"><i class="anticon anticon-plus-circle"></i></button>'+
						'</div>'+
					'</div>'+
				'</div>',
		template: '<div class="popover select_size" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
		placement: "left",
		trigger: "click",
		//container : 'body'
	});
	//$(".popover_select2").popover('disable');
	$('.popover_select2').on('shown.bs.popover', function() {
		$('a[href="#dataTanah"]').addClass('acc-lock');
		$('[name="input_doc"]').select2({theme:'bootstrap4',data:$arrays[0]}).on('select2:open', function(e) {
			$('.select2-container:last').addClass("zup");
		}).on("select2:selecting", function(evt, f, g) {
			var selId = evt.params.args.data.id;
    	}).on("select2:unselecting", function(evt) {
			//disableSel2Group(evt, this, false);
		});
		$('#button_doc').click(function(e){
			e.preventDefault();
			if($('[name="input_doc"]').val()){
				$opt = $('[name="input_doc"]').val()-1;
				$dopt = $arrays[0][$opt];
				$dopt.disabled = true;
				$('#sp_row').append(sp_render($dopt));
				set_validator();
				$('.popover_select2').popover("hide");
			}
		});

		$(".select2-container:first").addClass("wcup");
		$('.select2-selection--single').addClass("hcup");
	});
	$('.popover_select2').on('hide.bs.popover', function() {
		$('a[href="#dataTanah"]').removeClass('acc-lock');
	});

	$(".btn-map").click(function(e){
		e.preventDefault();
	});
	$(".dust").click(function(e){
		if($(this).hasClass("acc-lock")){
			e.preventDefault();
			e.stopPropagation();
		}
	});
	$(".dust+.popover_select2").click(function(e){
		if($(this).siblings(".dust").hasClass("acc-lock")){
			e.preventDefault();
			e.stopPropagation();
		}
	});
	
	var initialSave = <?=$button!='Update'?'true':'false'?>;
	$(".initial-save").click(function(e){
		e.preventDefault();
		if(initialSave){
			$args = ["",".by_purchase",".by_market",".by_njop"];
			$fourty_one = true;
			$form_data = {};
			$.each($('#dataTanah,#dataKeuangan').find("input, select"),function(i,v){
				$fourty_one &= validator.element('[name="'+$(v).attr("name")+'"]');
				if($(v).attr("type")=="checkbox") $form_data[v.name]=(v.checked?1:0)
				else if(["Luas Tanah","Harga"].includes($(v).attr('placeholder'))) $form_data[v.name]=$(v).cleanVal();
				else $form_data[v.name]=v.value;
			});

			if($fourty_one){
				$.post('<?=base_url("land/initial_land")?>', $form_data, function(data){
					if(data.status==true){
						$.each(data.log_data, function(i,v){
							$("#sp_row").append("<input type='hidden' name='"+i+"' value='"+v+"'>");
						});
						$.each(data.surface_id, function(i,v){
							$.each(v, function(a,b){
								$($args[i]+" .line-child").eq(a).append("<input type='hidden' \
									name='surface_id["+(i)+"]["+(1+a)+"]' data-id='surface_id["+(i)+"]' \
									value='"+b+"'>");
							});
						});
						$(".dust").removeClass("acc-lock");
						//$(".initial-save").parent().remove();
						$(".initial-save").remove();
						$("#accordion-tanah .card-header:first").append(' \
							<button id="setToPosting" class="t_btn btn btn-warning m-r-5 m-t-5"> \
								<i class="anticon anticon-loading m-r-5"></i> \
								<i class="anticon anticon-upload m-r-5"></i> \
								<span>Posting</span> \
							</button> \
							<button id="setToUpdate" class="s_btn btn btn-primary m-r-5 m-t-5"> \
								<i class="anticon anticon-loading m-r-5"></i> \
								<i class="anticon anticon-login m-r-5"></i> \
								<span>Update</span> \
							</button> \
						');
						var newurl = "<?=base_url("land/update/")?>"+data.log_data.land_id+".aspx";
						window.history.pushState({path:newurl},'',newurl);
						$(".breadcrumb-item.active").text("UPDATE");
						initialSave = false;
						$("next-tab").attr("disabled", false);
						$(".btn-xi:not(.harga)").attr("disabled", false);
						
						$(".by_market").find(".line-child").each(function(i,v){
							if(validator.element($(v).find("input"))){
								$(v).find(".harga").attr("disabled", false);
							}
						});
						$(".by_njop").find(".line-child").each(function(i,v){
							if(validator.element($(v).find("input"))){
								$(v).find(".harga").attr("disabled", false);
							}
						});
					}
				},"JSON");
			}
		}
	});
	
	$(document).delegate("#setToPosting","click",function(e){
		e.preventDefault();
		$this = $(this);
		$this.addClass("is-loading");
		e.preventDefault();
		$fourty_two = true;
		$form_data = {"land_id": $('[name="land_id"]').val()};
		$.confirm({
            title: 'Posting?',
			content: '<div class="text-center">Are you sure to posting this data?</div> \
				<div class="text-center"><b style="color:red">This document will cannot be edited</b></div>',
            buttons: {
                yes: {
                    btnClass: 'btn-orange',
                    action: function(){
                        $.post('<?=base_url("land/posting")?>', $form_data, function(data){
							if(data.success) {
								$('#setToPosting').remove();
								$("#accordion-tanah").find("input, select, button").prop("disabled", true);
								$(".push-push").remove();
								asimetris = false;
								toastr.success('Posting data was successful!', 'Data Posted');
							} else {
								toastr.error('Please check your connection', 'Error!');
							}
							$this.removeClass("is-loading");
						},"JSON");
                    }
                },
                no: ()=>{}
            }
        });
	});
	
	$(document).delegate("#setToUpdate","click",function(e){
		e.preventDefault();
		$this = $(this);
		$this.addClass("is-loading");
		$fourty_two = true;
		$form_data = {"land_id": $('[name="land_id"]').val()};

		$('#dataTanah, #dataKeuangan').find('input[type="hidden"], input.changed, select.changed').each(function(i,v){
			$fourty_two &= validator.element('[name="'+$(v).attr("name")+'"]');
			if($(v).attr("type")=="checkbox") $form_data[v.name]=(v.checked?1:0)
			else if(["Luas Tanah","Harga"].includes($(v).attr('placeholder'))) $form_data[v.name]=$(v).cleanVal();
			else $form_data[v.name]=v.value;
		});
		$form_data["documents"] = [];
		$('#dokumentTanah').find('.colDoc.changed').each(function(i,v){
			if($(v).find('input[type="hidden"]').length){
				$form_temp = {};
				$form_temp = {
					"id" : $(v).find('input[type="hidden"]').val(),
					"type" : $(v).find('label').attr("data-val"),
					"data" : []
				};
				$(v).find('input:not([type="hidden"]), select').each(function(i,v){
					$form_temp.data.push(v.value);
				});
				$form_data["documents"].push($form_temp);
			}		
		});
		console.log($form_data["documents"]);
		if($fourty_two){
			$.post('<?=base_url("land/update_land")?>', $form_data, function(data){
				if(data.success) toastr.success('Update data was successful!', 'Data Updated');
				$('#dataTanah, #dataKeuangan').find(".changed").removeClass("changed");
				$this.removeClass("is-loading");
			},"JSON");
		}
	});

	

	/*$('#fompt').submit(function(e){
		e.preventDefault();
		if(!initialSave){
			if($(this).validate().valid()){
				$data_array = {};
				$.map($(this).serializeArray(),function(v,i){
					$data_array[v.name]=v.value;
				});
				$(this).find('["type"="checkbox"]:checked').each(function(i,v){
					$data_array[v.name]=v.checked;
				});				
				//console.log(JSON.stringify($data_array));
				$.post("<?=$action?>",$data_array,function(data){
					console.log(data);
					//location.reload();
				});
			}
		}
	});*/
	$(document).delegate(".calculate","click",function(e){
		sCe = $(this).parents(".input-group").find("input:first").cleanVal();
		//console.log(sCe);
		if ((!$(this).data("bs.popover") || !$(this).attr('data-popoverAttached')) && sCe) {
			$(".calculate").popover({
				html: true,
				sanitize: false,
				content: '<div class="d-flex align-items-center"> \
						<div class="input-group mr-3"> \
							<div class="input-group-prepend"> \
								<span class="input-group-text" data-toggle="tooltip" data-placement="top" title="" data-original-title="Harga Total dengan Luas Tanah Berdasarkan Surat"> \
									<i class="anticon anticon-audit"></i> \
								</span> \
							</div> \
							<div class="input-affix form-control"> \
								<span class="prefix-icon fy">RP</span> \
								<input type="text" class="form-control-xs remSin" readonly> \
								<span class="suffix-icon fy">M<sup>2</sup></span> \
							</div> \
						</div> \
						<div class="input-group mr-3"> \
							<div class="input-group-prepend"> \
								<span class="input-group-text" data-toggle="tooltip" data-placement="top" title="" data-original-title="Harga Total dengan Luas Tanah Berdasarkan Pengukuran Ulang"> \
									<i class="anticon anticon-area-chart"></i> \
								</span> \
							</div> \
							<div class="input-affix form-control"> \
								<span class="prefix-icon fy">RP</span> \
								<input type="text" class="form-control-xs remSin" readonly> \
								<span class="suffix-icon fy">M<sup>2</sup></span> \
							</div> \
						</div> \
						<div class="input-group"> \
							<div class="input-group-prepend"> \
								<span class="input-group-text" data-toggle="tooltip" data-placement="top" title="" data-original-title="Harga Total dengan Luas Tanah Berdasarkan GPS"> \
									<i class="anticon anticon-compass"></i> \
								</span> \
							</div> \
							<div class="input-affix form-control"> \
								<span class="prefix-icon fy">RP</span> \
								<input type="text" class="form-control-xs remSin" readonly> \
								<span class="suffix-icon fy">M<sup>2</sup></span> \
							</div> \
						</div> \
					</div>',
				template: '<div class="popover custom_size total_harga" role="tooltip"><div class="arrow"></div><div class="popover-body"></div></div>',
				placement: "bottom",
				trigger: "focus",
			});
			$(this).popover('show');
		}
	});
	$(document).delegate(".calculate","inserted.bs.popover",function(e){
		sW = $(this).parents(".input-group-append").width();
		sW -= $(this).width();
		$(".total_harga").data("bs.popover").config.offset = (-($(".total_harga").width()/2))+sW+"px";
	});
	$(document).delegate(".calculate","shown.bs.popover",function(e){
		sC = $(this).parents(".input-group").find("input:first").cleanVal();
		$(".total_harga input").each(function(i,v){
			$(v).val($(".x_surface").eq(i).cleanVal()*sC).unmask().mask('000.000.000.000.000', {reverse: true});
			//$(v).mask('000.000.000.000.000', {reverse: true});
		});
		$('[data-toggle="tooltip"]').tooltip();		
	});

	$('[data-toggle="tooltip"]').tooltip();
	$(".add-line").click(function(e){
		e.preventDefault();
		add_line(this);
	});
	
	$remover = function(target){
		ele = target.parents("fieldset");
		if(ele.find(".line-child").length > 1){
			target.parents(".line-child").remove();
			ele.find(".line-child").each(function(i,v){
				$(v).find("input").each(function(a,b){
					id_name = $(b).attr("data-id");
					if($(b).attr("data-id")=="surface_id"){
						$(b).attr('name',id_name+'['+(i+1)+']['+(a+1)+']');
					} else $(b).attr('name',id_name+'['+(i+1)+']');
				});
			});
		}
	}

	$(document).delegate(".remover","click",function(e){
		$this = $(this);
		ehid = $this.next(".btn-xi").attr("data-hid");
		eid = $this.next(".btn-xi").attr("data-id");
		if(!$this.hasClass("is-loading")){
			$this.addClass("is-loading");
			$this.parents(".line-child").find("input,button").not(this).attr("disabled",true);
			if($this.hasClass("harga")){
				if(ehid){
					$.post("<?=base_url("land/surface_clear")?>",{id:eid,hid:ehid},function(data){
						if(data.success) {
							toastr.success('File deletion was successful!', 'File Deleted');
							$remover($this);
							$this.removeClass("is-loading");
						}
					},"JSON");
				} else {
				 	$this.parents(".line-child").find("input,button").attr("disabled",false);
				 	$this.removeClass("is-loading");
				}
			} else {
				$remover($this);
				$this.removeClass("is-loading");
			}
		}
		//console.log(ele.find(".form-group"));
	});

	$('[rel="comments"]').each(function(){
		$parents = $('a[href="#'+$(this).parents(".tab-pane").attr("id")+'"]').parent();
		$parents.addClass("error");
	});
	/*$('.comment').popover({
        trigger: "manual",
        html: true,
        container: "body",
        //placement: "right",
        template: '<div class="popover"><div class="arrow"></div>'+
              '<h3 class="popover-title"></h3><div class="popover-content w-content">'+
              '</div></div>',
        content: function(){
			return '<textarea class="popover-textarea" placeholder="Comment" readonly></textarea>';
        }
    });
    
    $('.comment').on({
        "shown.bs.popover": function(){
            $("[rel=comments]").not(this).popover('hide');
            iputName = $(this).attr("data-name");
            var $this = $(this);
            //attach link text
            $('.popover-textarea').val($('[name="comments['+iputName+']"]').val());
            //close on cancel
            $('.popover-cancel').click(function() {
                $this.popover('hide');
            });
            //update link text on submit
            $('.popover-submit').click(function() {
                $('[name="comments['+iputName+']"]').val($('.popover-textarea').val());
                if($('[name="comments['+iputName+']"]').val()){
                    if(!$this.hasClass("ed")) $this.addClass("ed");
                } else $this.removeClass("ed");
                $this.popover('hide');
            });
        },
        "hide.bs.popover": function(){
            $(this).blur();    
        },
        "click": function(){
            $(this).popover("toggle");    
        }
    });*/
	//validation
	$.validator.setDefaults({
		debug: true,
		success: "valid"
	});
	$.validator.addMethod("json", function(value, element) {
		opt = false;
		$.ajax({
			url: '<?=base_url("land/get_code")?>',
			async: false,
			data: {"code":value},
			dataType: "json",
			success: function(data) {
				return opt = data.valid;
			}
		});
		return this.optional(element) || opt;
	}, "Document Code Already Exist!");
	$.validator.addMethod("alpha_dash", function(value, element) {
		return this.optional(element) || /^([-a-zA-Z_])+$/i.test(value); 
	}, "Alpha, spaces, underscores & dashes only.");
	$.validator.addMethod("alpha_space", function(value, element) {
		return this.optional(element) || /^([a-zA-Z ])+$/i.test(value); 
	}, "Alpha & spaces only.");
	$.validator.addMethod("alphanumeric_slash", function(value, element) {
		return this.optional(element) || /^([0-9a-zA-Z/])+$/i.test(value); 
	}, "Alphanumeric & Slash only.");
	$.validator.addMethod("rupiah", function(value, element) {
		return this.optional(element) || /^([0-9.])+$/i.test(value); 
	}, "Valid Rupiah Format only.");
	$.validator.addMethod("phoneNumber", function(value, element) {
		return this.optional(element) || /^(^8)(\d{3,4}-?){2}\d{1,4}$/i.test(value); 
	}, "Valid Indonesian Phone Number Format only.");
	$.validator.addMethod("year", function(value, element) {
		return this.optional(element) || (value > 1950) && /^(\d{4})$/i.test(value);
	}, "Valid Year Only");
	$.validator.addMethod("notEqual", function(value, element, param) {
		validsy = true; $thisy = this;
		$(param).not(element).each(function(i,v){
			validsy = validsy && !$.validator.methods.equalTo.call($thisy, value, element, $(v));
		});
		return this.optional(element) || validsy;
	}, "This elements are the same with other, please change it.");

	_depends = function(e){return $('[name="is_aktif"]').is(":checked")};
	var validator = $("#fompt").validate({
		ignore: ':hidden:not(:checkbox)',
		errorElement: 'div',
		errorClass: 'is-invalid',
		validClass: 'is-valid',
		errorPlacement: function(error, element) {
			element.parents(".form-group").append(error);
			//error.insertAfter(".form-group");
		},
		rules: {
			"land_documents_code" : {required: true, minlength: 6, maxlength: 50, json: true},
			"land_project_id" : {required: true},
			"land_physics_id" : {required: true},
			"land_mediator" : {alpha_space: true, maxlength: 50},
			"land_status_type_id" : {required: true},

			"map_province_id" : {required: true},
			"map_districts_id" : {required: true},
			"map_sub_district_id" : {required: true},
			"map_village_id" : {required: true},
			"map_geolocation" : {required: false},

			"owner_initial_name" : {alpha_space: true, required: true, maxlength: 50},
			"owner_final_name" : {alpha_space: true, required: true, maxlength: 50},
			"owner_ppjb" : {alpha_space: true, maxlength: 50},
			"owner_annotation" : {alpha_space: true},
			
			"surface_area_by_purchase" : {rupiah: true, required: true},
			"surface_area_by_doc" : {rupiah: true, required: true},
			"surface_area_by_remeas" : {rupiah: true, required: false},
			"surface_area_by_geo" : {rupiah: true, required: false},

			"surface_data[1][1][1]" : {rupiah: true, required: true},
			"surface_data[1][1][2]" : {year: true, required: true},

			"surface_data[2][1][1]" : {rupiah: true, required: false},
			"surface_data[2][1][2]" : {year: true, required: false, notEqual: '[data-unequal="market"]'},
			
			"surface_data[3][1][1]" : {rupiah: true, required: false},
			"surface_data[3][1][2]" : {year: true, required: false, notEqual: '[data-unequal="njop"]'},
		},
		/*success: function(element) {  
			$(element).parents(".form-group").removeClass('has-error').addClass("has-success").find("label:last").remove();
		},
		errorPlacement: function(error, element) {
			element.parents(".form-group").removeClass('has-success').addClass("has-error").append(error.addClass("help-block"));
		}*/
	});
	
	/*$('[data-toggle="yearpicker"]').each(function(i, v){
		unequal=$(v).attr("data-unequal");
		$(v).yearpicker({
			onHide:function(){
				$('[data-unequal="'+unequal+'"]').each(function(i, v){
					validator.element('[name="'+$(v).attr("name")+'"]');
				});
			},
			onChange:function(){ 
				$('[data-unequal="'+unequal+'"]').each(function(i, v){
					validator.element('[name="'+$(v).attr("name")+'"]');
				});
			}
		});
	});*/
	set_yearpicker = ()=>{
		yearpicker_ele = $('[data-toggle="yearpicker"]');
		yearpicker_dts = yearpicker_ele.data("DateTimePicker");
		if(yearpicker_dts) yearpicker_dts.destroy();

		yearpicker_ele.datetimepicker({ locale: 'id', format: 'YYYY'});
		/*.on("dp.change",(e)=>{
			satate = true;
			unequal = $(e.target).attr("data-unequal");
			if(unequal)
				$('[data-unequal="'+unequal+'"]').each(function(i, v){
					satate &= validator.element('[name="'+$(v).attr("name")+'"]');
				});
			if($(e.target).is(':not([data-id="surface_data[1]"])')){
				$disabled = true;
				if($(e.target).val() && !initialSave) $disabled = false;
				$(e.target).parent().siblings().find(".harga").attr({
					'disabled': $disabled,
					'data-year': $(e.target).val()
				});
			}
			//console.log($(e.target).attr("data-unequal"));
		});*/
		//validator.resetForm();
	};
	//set_yearpicker();
	$('[data-toggle="yearpicker"]').datetimepicker({ locale: 'id', format: 'YYYY'});

	$(document).delegate('[data-toggle="yearpicker"]',"dp.change",function(e){
		unequal = $(e.target).attr("data-unequal");
		if(unequal)
			$('[data-unequal="'+unequal+'"]').each(function(i, v){
				validator.element('[name="'+$(v).attr("name")+'"]');
			});
		if($(e.target).is(':not([data-id="surface_data[1]"])')){
			$disabled = true;				
			if($(e.target).val() && !initialSave) $disabled = false;
			$(e.target).parent().siblings().find(".harga").attr({
				'disabled': $disabled,
				'data-year': $(e.target).val()
			});
		}

		if(!$(this).hasClass("changed")) $(this).addClass("changed");
	});

	<?php if($button=="Create"){ ?>
		$('a[data-toggle="tab"]').attr("disabled",true);
		$('a[data-toggle="tab"]').parents("li").addClass("disabled");
		$('.nav .disabled > a[data-toggle="tab"]').click(function(e) {
			e.preventDefault();
			if($(this).attr("disabled")=="disabled") return false;
				else return true;
		});
	<?php } ?>
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		$('.popover').popover('hide');
		var href = $(e.target).attr('href');
		var $curr = $(".process-model a[href='" + href + "']").parent();
		//$('.process-model li[class="active"]').addClass("visited");
		$('.process-model li').removeClass("active");
		$curr.addClass("active");
		$curr.prevAll().filter(':not([class="active"])').addClass("visited");
	});
	$(document).delegate(".next-tab","click",function(e){
		e.preventDefault();
		$href_next = $(e.target).attr('data-href');
		$href_id = $(e.target).parents('.tab-pane').attr("id");
		$('.nav-tabs a[href="'+$href_next+'"]').parents("li").removeClass("disabled");
		$('.nav-tabs a[href="'+$href_next+'"]').attr("disabled",false);
		$('.nav-tabs a[href="#'+$href_id+'"]').parents("li").removeClass("disabled");
		$('.nav-tabs a[href="#'+$href_id+'"]').attr("disabled",false);
		$fourty_one = true;
		$form_data = {};
		$.each($(e.target).parents('.tab-pane').find("input, select"),function(i,v){
			$fourty_one &= validator.element('[name="'+$(v).attr("name")+'"]');
			$form_data[v.name]=v.value;
			//console.log($(v).valid());
		});
		//console.log($form_data);
		$('.nav-tabs a[href="'+$href_next+'"]').tab('show');

		/*if($fourty_one){
			if($(this).hasClass("initial-save")){
				$.post('<?=base_url("land/initial_land")?>', $form_data, function(data){
					if(data.status==true){
						$.each(data.log_data, function(i,v){
							$("#"+$href_id).append("<input type='hidden' name='"+i+"' value='"+v+"'>");
						});
					}
					//console.log(data);
					$('.nav-tabs a[href="'+$href_next+'"]').tab('show');
				},"JSON")
			} else $('.nav-tabs a[href="'+$href_next+'"]').tab('show');
		}*/
	});

	var validators_render = {};
	function set_validator(){
		$.each(validators_render,function(i,v){
			$(i).rules("add",v);
		});
		validators_render = {};
	}
	function sp_noela(elemt, name){
		return $("<div>",{class:"input-group"}).append(
			elemt,
			$("<div>",{class:"top_right"}).append(
				comment_ele(name)
			)
		)
	}
	function sp_render(array, rData){
		if(!rData){
			rData = {
				"document_id":undefined,
				"file_type":"-",
				"file_annoations":"",
				"file_extra":[]
			};
		}
		ar_pn = ["ASLI","COPY","N/A"];
		$select_oName = "col_doc[" + array.id + "][1]";
		$select_o = $("<select>",{"name":$select_oName,"class":"form-control mr-1"});
		$select_o.append($("<option>",{"hidden":true,"selected":true,"disabled":true}).text("Choose Type"));
		$.each(ar_pn, function(i,v){ 
			$select_o.append($("<option>",{"value":i,"selected":(i==rData["file_type"])}).text(v));
		});
		$dFlex = $("<div>",{"class":"d-flex align-items-center"}).append(sp_noela($select_o, $select_oName));
		

		z=1; validators_render['[name="col_doc['+array.id+'][1]"]']={required: true};
		$.each(array.extra, function(i,v){
			z++;
			$inputField = $("<input>",{
				"type":"text",
				"name":"col_doc[" + array.id + "]["+(z)+"]",
				"class":"form-control mr-1",
				"placeholder":v,
				"value":rData["file_extra"][i]
			});
			valid_f = {required: true};
			if((["No","Luas"]).includes(v)){
				$inputField.mask('000.000.000.000.000', {reverse: true});
				valid_f["alphanumeric_slash"]=true;
				valid_f["maxlength"]=30;
			} else if(v=="Tanggal"){
				valid_f["date"]=true;
				$inputField.datetimepicker({ locale: 'id', format: 'YYYY-MM-DD'});
			} else if(v=="Tahun"){
				valid_f["year"]=true;
				$inputField.datetimepicker({ locale: 'id', format: 'YYYY'});
			} else {
				valid_f["alpha_space"]=true;
				valid_f["maxlength"]=50;
			}
			$dFlex.append(sp_noela($inputField, "col_doc[" + array.id + "]["+(z)+"]"));
			validators_render['[name="col_doc['+array.id+']['+(z)+']"]']=valid_f;
		});
		z++;
		
		$dFlex.append(
			sp_noela($("<input>",{
				"type":"text",
				"name":"col_doc[" + array.id + "]["+(z)+"]",
				"class":"form-control mr-1",
				"placeholder":"keterangan",
				"value":rData["file_annoations"]
			}), "col_doc[" + array.id + "]["+(z)+"]")
		).append(
			$("<button>", {"data-val":array.id, "data-method":2, "data-operate":1, "class":"btn btn-success mr-1 btn-xi", "disabled":rData["document_id"]===undefined})
				.append($("<i>",{"class":"anticon anticon-folder-open anticon-lg"}))
		).append(
			$("<button>", {"data-val":rData["document_id"], "class":"btn btn-danger btn-xremove"})
				.append($("<i>",{"class":"anticon anticon-loading anticon-lg"}))
				.append($("<i>",{"class":"anticon anticon-delete anticon-lg"}))
		);

		$formGroup = $("<div>",{class:"form-group colDoc"})
			.append($("<label>",{"data-val":array.id, "for":"docky_"+array.id, "class":"dockies"}).text(array.text))
			.append($dFlex)

		if(rData["document_id"]) $formGroup.append($("<input>",{"type":"hidden", "name":"col_doc[" + array.id + "][id]","value":rData["document_id"]}));
		return $("<div>",{class:"col-xs-12 col-sm-12 col-md-12 col-lg-6"}).append($formGroup);
	}

	$(document).delegate('.btn-xremove', 'click', function(e) {
		e.preventDefault();
		$this = $(this);
		if(!$this.hasClass("is-loading")){
			$this.addClass("is-loading");
			$cola_id = $this.data("val");
			$cola_el = $this.parents(".col-xs-12");
			if($cola_id){
				$.post("<?=base_url("land/upload_clear")?>",{id:$cola_id},function(data){
					if(data.success) {
						toastr.success('File deletion was successful!', 'File Deleted');
						$cola_el.remove();
						$this.removeClass("is-loading");
					}
				},"JSON");
			} else {
				$cola_el.remove();
				$this.removeClass("is-loading");
			}
		}
	});
	
	/*$("#popover_map, #popover_proof, .popover_select2").click(function() {
		if ($(this).children("i").hasClass("fa-plus_"))
			$(this).children("i").removeClass("fa-plus_").addClass("fa-close");
		else $(this).children("i").removeClass("fa-close").addClass("fa-plus_");
	});*/

	/*$(".subcollapse").click(function() {
		if ($(this).children("i").hasClass("fa-chevron-right"))
			$(this).children("i").removeClass("fa-chevron-right").addClass("fa-chevron-down");
		else $(this).children("i").removeClass("fa-chevron-down").addClass("fa-chevron-right");
	});

	

	$("#popover_proof").popover({
		html: true,
		content: '<div class="form-group" style="display: flex; margin-bottom: 0">' +
			'<?= cmb_template('input_proof', 'proof_type', 'proof_type_name', 'proof_type_id', null, ['placeholder' => '-----Pilih Jenis Dokumen-----']) ?>' +
			'<button name="button_proof" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span></button>' +
			'</div>',
		template: '<div class="popover select_size" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
		placement: "bottom",
		trigger: "click",
		//container : 'body'
	});

	$("#popover_map").popover({
		html: true,
		content: '<div class="form-group" style="display: flex; margin-bottom: 0">' +
			'<?php /*cmb_template('input_map', 'map_proof_type', 'map_proof_type_name', 'map_proof_type_id', null, ['placeholder' => '-----Pilih Jenis Dokumen-----']) */?>' +
			'<button name="button_map" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span></button>' +
			'</div>',
		template: '<div class="popover select_size" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
		placement: "bottom",
		trigger: "click",
		//container : 'body'
	});

	$(document).delegate('[name=remove_map],[name=remove_proof],[name=remove_list_doc]', 'click', function(e) {
		//$(this).siblings("input").rules("remove");
		$(this).parents(".form-group").remove();
		if($(this).attr("name") === "remove_list_doc"){
			$arrays[0][$(this).attr("data-val")-1].disabled = false;
		}
	});

	$('#popover_proof, #popover_map').on('shown.bs.popover', function() {
		$id_p = $(this).attr("id");
		$popover_id = {
			"popover_proof": [".slax_a", "[name=input_proof]"],
			"popover_map": [".slax_b", "[name=input_map]"]
		};
		$($popover_id[$id_p][1] + " option:not(:first)").removeAttr("disabled").removeAttr("hidden");
		$($popover_id[$id_p][0]).map(function(i, v) {
			console.log($($popover_id[$id_p][1] + " option:not(:first)[value=" + $(v).attr("data-val") + "]").text());
			$($popover_id[$id_p][1] + " option:not(:first)[value=" + $(v).attr("data-val") + "]")
				.attr("disabled", "disabled").attr("hidden", "hidden");
		});
	});

	//[name^=col_doc]
	$(document).delegate('[name^=proof_type_id], [name^=map_type_id]', 'change', function(e) {
		if($(this).val() && validator.element(e.target)){
			$(this).siblings(".btn-xi").attr("disabled",false);
		} else $(this).siblings(".btn-xi").attr("disabled",true);
	});
	$(document).delegate('[name^=col_doc]', 'change', function(e) {
		cfb = true;
		$(this).siblings("input, select").each(function(i,v){
			cfb &= validator.element(v);
		});
		if(cfb) $(this).siblings(".btn-xi").attr("disabled",false);
			else $(this).siblings(".btn-xi").attr("disabled",true);
	});
	$(document).delegate('[name=button_proof], [name=button_map]', 'click', function(e) {
		e.preventDefault();
		$pvr_id = {
			"button_proof": ["slax_a", "[name=input_proof]", "proof_type_id", "remove_proof", "bukti_hak", "#proof_body", 0],
			"button_map": ["slax_b", "[name=input_map]", "map_type_id", "remove_map", "luas_tanah", "#map_body", 1]
		};
		value = $($pvr_id[$(this).attr("name")][1]).val();
		v_text = $($pvr_id[$(this).attr("name")][1] + " option:selected").html();
		l_text = ((v_text.trim()).toLowerCase()).replace(/ /g, "_");
		v_true = true;
		$($pvr_id[$(this).attr("name")][0]).each(function(i, v) {
			if ($(v).attr("data-val") == value) {
				v_true = false;
			}
		});

		//$row_t = "<?= ($button != "Create") ? "<input id='" . '"+l_text+"' . "' type='checkbox' name='" . '"+$pvr_id[$(this).attr("name")][4]+"["+l_text+' . '"]' . "'" . '/>' : '' ?>";

		if (value && v_true) {
			$append = '<div class="form-group"> \
				<label for=' + l_text + ' data-val=' + value + ' class="' + $pvr_id[$(this).attr("name")][0] + '">' + v_text + '</label> \
				<div class="line-up"> \
					<input type="text" name="' + $pvr_id[$(this).attr("name")][2] + '[' + value + '][1]" placeholder="No. ' + v_text + '" class="form-control" style="margin-right:5px"> \
					<span data-method='+ $pvr_id[$(this).attr("name")][6] +' data-val=' + value + ' class="btn btn-success btn-xi" style="overflow: unset; margin-right:5px" disabled> \
						<span class="glyphicon glyphicon-folder-open"></span> \
					</span> \
					<button name="' + $pvr_id[$(this).attr("name")][3] + '" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button> \
				</div> \
			</div>';

			if($($pvr_id[$(this).attr("name")][5]).find(".next-tab").length){
				$($pvr_id[$(this).attr("name")][5]).find(".next-tab").before($append);
			} else $($pvr_id[$(this).attr("name")][5]).append($append);
		}
		$($pvr_id[$(this).attr("name")][1] + " option:selected").attr("disabled", "disabled").attr("hidden", "hidden");
		$($pvr_id[$(this).attr("name")][1]).val($($pvr_id[$(this).attr("name")][1] + " option:first").text());
		$($pvr_id[$(this).attr("name")][1] + " option:first").removeAttr("disabled").removeAttr("hidden").attr("selected", "selected");
		$($pvr_id[$(this).attr("name")][1] + " option:first").attr("disabled", "disabled").attr("hidden", "hidden");
		$('[name="' + $pvr_id[$(this).attr("name")][2] + '[' + value + '][1]"]').rules( "add", {alphanumeric_slash: true, required: true, maxlength: 30});
	});*/

	//FILE UPLOAD
	$(document).delegate('[name^=col_doc]', 'change', function(e) {
		cfb = true;
		parv = $(this).parents(".colDoc");
		if(!parv.hasClass("changed")){
			parv.addClass("changed");
		}
		cele = $(this).parent();
		cele.siblings(".input-group").each(function(i,v){
			cfb &= validator.element($(v).find("input,select").first());
		});
		if(cfb) cele.siblings(".btn-xi").attr("disabled",false);
			else cele.siblings(".btn-xi").attr("disabled",true);
	});

	var was_create = false, ele_btnxi, btnxi_option;
	$(document).delegate('.btn-xi', 'click', function(e) {
		e.preventDefault();
		ele_btnxi = this;
		$di = $('[name="land_id"]').val();
		$vf = $(ele_btnxi);
		$id = $vf.attr("data-val");
		$mt = $vf.attr("data-method");
		$yr = $vf.attr("data-year");
		$op = $vf.attr("data-operate");
		btnxi_option = {};
		
		//$('[name="x_file"]').fileinput("destroy");
		//$('[name="x_file"]').hide();

		var footerTemplate = '<div class="file-thumbnail-footer" style ="height:94px">\
				<input class="mt-2 kv-input kv-new form-control input-sm form-control-sm text-center" value="{caption}" data-caption="{caption}" placeholder="Enter caption...">\
			   <div class="small mb-2">{size}</div>\
			   {progress}\
			   {indicator}\
			   {actions}\
			</div>';
		
		file_option = {
			theme: 'anticon',
			uploadUrl: "<?= base_url('land/upload_data/') ?>" + $mt,
			deleteUrl: "<?= base_url('land/upload_delete/') ?>",
			allowedFileTypes: ["image","pdf"],
			allowedFileExtensions: ["jpg", "jpeg", "gif", "png", "pdf"],
			maxFileSize: 10000,
			maxFilesNum: 10,
			browseClass: "btn btn-primary wfile",
			showCaption: false,
			fileActionSettings: {showDrag: false},
			//uploadAsync: false,
			//showRemove: false,
			//showUpload: false,
			overwriteInitial: false,
			layoutTemplates: {
				main2: "<div class='input-group {class}'>\
					{browse} \
					<div class='input-group-btn input-group-prepend'>{remove}</div>\
					<div class='input-group-btn input-group-prepend'>{upload}</div>\
				</div> \
				{preview}",
				footer: footerTemplate
			}
		};

		if($op==1) colDock = $('[name="col_doc['+$id+'][id]"]');
		if($op==2) colDock = $vf.parents(".line-child").find('input[type="hidden"]');

		if(!colDock.length){
			$sd = {id:$id, land:$di}; tmp=[]; xyz=[];
			$vf_x = $vf.parents(".form-group").find("select, input");
			$vf_x.each(function(i,v){
				if($op==1){
					if([0,$vf_x.length-1].includes(i)) tmp.push(v.value);
					else xyz.push(v.value);
				} else {
					tmp.push(v.value);
				}
			});
			$sd["initial"] = JSON.stringify(tmp);
			if($op==1) $sd["optional"] = JSON.stringify(xyz);

			btnxi_option = {
				"data": $sd,
				"operate": $op,
				"parent": $vf,
				"url": ($op==1)?"pre_upload":"add_surface",
			};
		}
		
		$pre_upload = false;
		if($op==1)
			file_option['uploadExtraData'] = function(previewId, index){
				var extraData = {id:$id, land:$di, operate:$op};
				if($yr && $yr!="0000") extraData["year"] = $yr;
				colDock = $('[name="col_doc['+$id+'][id]"]');
				if(colDock.length==0 && index==0){
					// $sd = {id:$id, land:$di}; tmp=[]; xyz=[];
					// $vf_x = $vf.parents(".form-group").find("select, input");
					// $vf_x.each(function(i,v){
					// 	if([0,$vf_x.length-1].includes(i)) tmp.push(v.value);
					// 	else xyz.push(v.value);
					// });
					// $sd["initial"] = JSON.stringify(tmp);
					// $sd["optional"] = JSON.stringify(xyz);

					// btnxi_option = {
					// 	"data":$sd,
					// 	"operate":$op,
					// 	"parent": $vf
					// };

					// $.ajax({
					// 	url: "<?=base_url("land/pre_upload")?>",
					// 	method: "POST",
					// 	async: false, 
					// 	dataType: 'json',
					// 	data: $sd,
					// 	success: function (data) {
					// 		if(data["status"] || data["key"]!=-1){
					// 			$vf.parents(".form-group").append(
					// 				'<input type="hidden" value="'+data.key+'" name="col_doc['+$id+'][id]">'
					// 			);
					// 		}
					// 	}
					// });
				} else {
					extraData["file-id"] = colDock.val();
				}
				$fileDrop = $(".file-drop-zone .file-preview-initial.kv-preview-thumb").length;
				$vf_y = $(".kv-input").eq(index+$fileDrop);
				extraData["name"] = $vf_y.val();
				extraData["extension"] = String($vf_y.data("caption")).match(/\.[^.\s]{3,4}$/g);
				return extraData;
			};
		else if($op==2)
			file_option['uploadExtraData'] = function(previewId, index){
				var extraData = {id:$id, land:$di, operate:$op};
				if($yr && $yr!="0000") extraData["year"] = $yr;
				if($vf.attr("data-hid")) extraData["hid"] = $vf.attr("data-hid");
				return extraData;
			}

		$file_id = $('[name="col_doc['+$id+'][id]"]');
		if($file_id.length || $vf.attr("data-id")){
			$dat_id = ($file_id.length)?$file_id.val():$vf.attr("data-id");
			$.ajax({
				async: false,
				type: 'POST',
				dataType: "JSON",
				data: {id:$dat_id},
				url: '<?=base_url("land/file_list")?>',
				success: function(rd) {
					//console.log(rd);
					file_option["initialPreview"]=rd.initialPreview;
					file_option["initialPreviewConfig"]=rd.initialPreviewConfig;
					file_option["initialPreviewAsData"]=true;
				}
			});
		}

		var x_file = $('[name="x_file"]').fileinput("destroy").fileinput(file_option);
		$("#tambahDoc").modal('show');
	});
	
	$(document).find('[name="x_file"]').on('fileloaded', function(event, file, previewId, fileId, index, reader) {
		$(".kv-input:visible").each(function(i,v) {
			$cap = $(v).data("caption").replace(/\.[^.\s]{3,4}$/g,'');
			$(v).attr("data-caption",$cap).val($cap);
		});
	}).on('filepreajax', function(event, previewId, index) {
		console.log(this);
		console.log(event);
		console.log(previewId);
		console.log(index);
		console.log(btnxi_option);

		if(Object.keys(btnxi_option).length)
			$.ajax({
				url: "<?=base_url("land/")?>"+btnxi_option["url"],
				method: "POST",
				async: false, 
				dataType: 'json',
				data: btnxi_option["data"],
				success: function (data) {
					if(data["status"] || data["key"]!=-1){
						if(btnxi_option["operate"]==1){
							btnxi_option["parent"].parents(".form-group").append(
								'<input type="hidden" name="col_doc['+btnxi_option["data"]["id"]+'][id]" value="'+data.key+'">'
							);
						} else {
							btnxi_option["parent"].attr("data-hid",data.key);
							btnxi_option["parent"].parents(".line-child").append(
								$("input",{
									type:"hidden",
									name:"surface_id["+(btnxi_option["data"]["id"]==83?2:3)+"][1]",
									"data-id":"surface_id["+(btnxi_option["data"]["id"]==83?2:3)+"]",
									value:data.key
								})
							);
						}						
					}
				}
			});
	}).on('filebeforedelete', function() {
		return new Promise(function(resolve, reject) {
			$.confirm({
				title: 'Confirmation!',
				content: 'Are you sure you want to delete this file?',
				type: 'red',
				buttons: {   
					delete: {
						btnClass: 'btn-danger text-white',
						keys: ['enter'],
						action: function(){
							resolve();
						}
					},
					cancel: ()=>{}
				}
			});
		});
	}).on('filedeleted', function() {
		toastr.success('File deletion was successful!', 'File Deleted')
	}).on('fileuploaded', function(event, data, previewId, index, fielddID) {
		hid = data.extra.hid;
		elementID = data.extra.id;
		fielddID = data.response.uploadExtraData.id;
		if(fielddID!=0){
			if(hid){
				$('button[data-hid="'+hid+'"]').attr("data-id",fielddID);
			} else {
				$('button[data-val="'+elementID+'"]').attr("data-id",fielddID);
			}
		}
	});
	$(document).delegate('.kv-input', 'keyup', function(e) {
		$cVal = $(this).val();
		$cBtn = $(this).siblings(".file-actions").find(".file-footer-buttons");
		$cKey = $cBtn.find(".kv-file-remove").data("key");
		$cloneF = $("<button>",{
			class:"kv-file-edit btn btn-sm btn-kv btn-default btn-outline-secondary",
			title:"Edit file",
			"data-name":$cVal,
			"data-key":$cKey
		}).append($("<i>",{class:"anticon anticon-save"}));
		
		$cBtn.find(".kv-file-edit").remove();
		if($(this).val()!=$(this).data("caption")){
			$cBtn.prepend($cloneF);
			$(this).not('.kv-changed').addClass('kv-changed');
		} else {
			$(this).removeClass('kv-changed');
		}
	});

	$(document).delegate('.kv-file-edit', 'click', function(e) {
		var $bvt = $(this);
		$.post("<?=base_url("land/edit_upload")?>",
			{key:$bvt.data("key"),name:$bvt.data("name")},function(data){
				$bvt.remove();
				toastr.success('Rename file was successful!', 'File Renamed')
		});
	});

	//testing
	/*$datalah = {
		"draw": {
			"type": "Feature",
			"geometry": {
				"coordinates": [
					[
						[
							-95.27286241574141,
							38.95251871103957
						],
						[
							-95.27231610174829,
							38.952529201174116
						],
						[
							-95.27234645252557,
							38.95168474037246
						],
						[
							-95.27287253266717,
							38.95170309832292
						],
						[
							-95.27286241574141,
							38.95251871103957
						]
					]
				],
				"type": "Polygon"
			},
			"properties": {}
		},
		"view": {
			"center": [
				-95.2728303788092,
				38.95230366293896
			],
			"zoom": 17.669685102536143
		}
	}*/
	//$('input[name="geolocation"]').val(JSON.stringify($datalah));

	function add_coordinate_field(value="", clear=false){
		parent = $("#f_coordinate");
		ele = parent.find(".line-child");
		set = ele.length + 1;
		bow = ele.first().clone();
		if(clear) {
			ele.remove();
			set = 1;
		}
		bow.find(".prefix-icon").text("C"+set);
		bow.find("input").val(value).attr({
			'placeholder': 'Coordinate '+set,
			"data-num": set
		});
		bow.find("button").attr("data-num",set);
		parent.find(".row").append(bow);
	}

	$(".add-coordinate").click(function(e){
		add_coordinate_field();
	});


	$(".btn-map").click(function(e) {
		$("#tambahMap").modal("show");
	});

	var $raw_data = ""; var map_query, map, draw, $current_data;
	$('#tambahMap').on('shown.bs.modal', function() {
		try {
			$current_data = JSON.parse($('input[name="map_geolocation"]').val());
		} catch (e) {
			$current_data = {};
		}

		const code = 'pk.eyJ1IjoiZ2VyeWYzZjMiLCJhIjoiY2thaXAzbHBlMDJibDJxcGZnMXlhaGNzMyJ9.hEUths9qWrjH_TkaHQ2eng';
		map_args = {
			minZoom: 0,
			maxZoom: 24,
			container: 'map', // container id
			style: 'mapbox://styles/mapbox/satellite-streets-v11'
		}
		if($current_data.view != undefined){
			map_args["center"]=$current_data.view.center;
			map_args["zoom"]=$current_data.view.zoom;
		}
		mapboxgl.accessToken = code;
		map = new mapboxgl.Map(map_args);
		//console.log(map_args);
		var LotsOfPointsMode = {};
		LotsOfPointsMode.onDrag = function(state, e) {
			e.preventDefault();
		};
		draw = new MapboxDraw({
			displayControlsDefault: false,
			controls: {
				polygon: true,
				trash: true
			}
		});
		var geocoder = new MapboxGeocoder({
			accessToken: code,
			mapboxgl: mapboxgl,
			marker: false
		});

		map.addControl(geocoder);
		map_query = $('[name="map_village_id"] option:selected').text()+" "+$('[name="map_sub_district_id"] option:selected').text();
		geocoder.query(map_query);

		function generate_layer(id, source) {
			return {
				'id': id,
				'type': 'symbol',
				'source': source,
				'layout': {
					'text-field': ['get', 'title'],
					'text-font': ['Open Sans Semibold', 'Arial Unicode MS Bold'],
					'text-offset': [0, 0.6],
					'text-anchor': 'center',
					'text-rotation-alignment': 'viewport',
					'text-size': 12,
					'text-rotate': {
						'type': 'identity',
						'property': 'rotation'
					}
				},
				'paint': {
					'text-color': '#202',
					'text-halo-color': '#fff',
					'text-halo-width': 2
				}
			}
		}

		function generate_node(title, coordinate) {
			return {
				'type': 'Feature',
				'properties': {
					'title': title
				},
				'geometry': {
					'type': 'Point',
					'coordinates': coordinate
				}
			}
		}

		map.addControl(draw);

		var $temp_coor;

		function label_render(centered) {
			if (map.getLayer("points") != undefined) {
				map.removeLayer("points").removeSource("points");
			}
			if (map.getLayer("nodes") != undefined) {
				map.removeLayer("nodes").removeSource("nodes");
			}
			var map_data = draw.getAll();
			if (map_data.features.length > 0) {
				$(".mapbox-gl-draw_polygon").attr("disabled", true);

				features = []; nodes = [];
				//$(".mapbox-gl-draw_trash").attr("disabled",true);
				$.each(map_data.features[0].geometry.coordinates[0], function(i, v) {
					length_coordinates = map_data.features[0].geometry.coordinates[0].length - 1;
					if (i) {
						turfie = turf.point(templah);
						turfi = turf.point(v);
						templah = v;
						temper_distance = turf.distance(turfie, turfi);
						temper_feature = turf.midpoint(turfie, turfi);

						var dLon = temper_feature.geometry.coordinates[0] - v[0];
						var dLat = temper_feature.geometry.coordinates[1] - v[1];
						var angle = 90 + (Math.atan2(dLon, dLat) * 180 / Math.PI);

						temper_bearing = angle;
						if (temper_distance >= 1) {
							temper_feature.properties.title = (Math.round(temper_distance * 100) / 100) + " km";
							temper_feature.properties.rotation = temper_bearing;
						} else {
							temper_feature.properties.title = (Math.round((temper_distance * 1000) * 100) / 100) + " m";
							temper_feature.properties.rotation = temper_bearing;
						}

						//temper_feature.properties.mode = "labeled";
						features.push(temper_feature);

					} else templah = v;
					nodes.push(generate_node("C"+(1+i),v));
				});

				area = turf.area(map_data);
				centroid = turf.centroid(map_data);

				if (area < 1) {
					centroid.properties.title = (Math.round((area * 1000000) * 100) / 100) + " km²";
					centroid.properties.rotation = 0;
				} else {
					centroid.properties.title = (Math.round(area * 100) / 100) + " m²";
					centroid.properties.rotation = 0;
				}

				//centroid.properties.mode = "labeled";
				features.push(centroid);

				map.addSource('points', {
					'type': 'geojson',
					'data': {
						'type': 'FeatureCollection',
						'features': features
					}
				});

				map.addSource('nodes', {
					'type': 'geojson',
					'data': {
						'type': 'FeatureCollection',
						'features': nodes
					}
				});

				map.addLayer(generate_layer("points", "points"));
				map.addLayer(generate_layer("nodes", "nodes"));

				$draw_data = (draw.getAll()).features[0];
				delete $draw_data.id;

				$raw_data = {
					"draw": $draw_data,
					"view": {
						"center": [map.getCenter().lng, map.getCenter().lat],
						"zoom": map.getZoom(),
					}
				}

				$temp_coor = $draw_data;
				if(centered)
					map.flyTo({
						center: centroid.geometry.coordinates,
						zoom: 19
					});
				//console.log(JSON.stringify($raw_data));
			}
		}

		$(".mapbox-gl-draw_trash").click((e) => {
			e.preventDefault();
			draw.deleteAll();
		});

		geocoder.on('results', function(results) {
			//console.log(results);
		});

		map.on('load', function() {
			if($current_data.draw!=undefined){
				//var featureIds = draw.add($current_data.draw);
				draw.set($current_data.draw);
				$coordinates = $current_data.draw.geometry.coordinates[0];
				$.each($coordinates, function(i,v){
					if(i!=$coordinates.length-1)
						add_coordinate_field(v, i==0);
				});
			}
			label_render();
			//console.log($current_data.draw);
		});

		map.on('draw.create', function(e) {
			label_render();
			$coordinates = (draw.getAll()).features[0].geometry.coordinates[0];
			$.each($coordinates, function(i,v){
				if(i!=$coordinates.length-1)
					add_coordinate_field(v, i==0);
			});
			//map.getSource('trace').setData(data);
		});

		map.on('draw.update', function(e) {
			if (e.action === 'move') {
				if(map.getLayer("points") !== undefined){
					map.removeLayer("points").removeSource("points");
				}
				if(map.getLayer("nodes") !== undefined){
					map.removeLayer("nodes").removeSource("nodes");
				}
			}
			label_render();
		});

		map.on('draw.delete', function(e) {
			if(map.getLayer("points") !== undefined){
				map.removeLayer("points").removeSource("points");
			}
			if(map.getLayer("nodes") !== undefined){
				map.removeLayer("nodes").removeSource("nodes");
			}
			$(".mapbox-gl-draw_polygon").attr("disabled", false);
			$("#f_coordinate .line-child:not(:first-child())").remove();
			$("#f_coordinate .line-child:first-child() input").val("");
		});

		$(document).delegate('[data-id="coordinates"]', "change", function(e){
			dataNum = parseInt($(this).attr("data-num"));
			drawD = draw.getAll();
			drawV = ($(this).val()).split(",");
			$.each(drawV, function(i,v){
				drawV[i] = parseFloat(v);
			});
			drawD.features[0].geometry.coordinates[0][dataNum-1] = drawV;
			if(dataNum==1){
				lengthD = drawD.features[0].geometry.coordinates[0].length;
				drawD.features[0].geometry.coordinates[0][lengthD-1] = drawV;
			}
			draw.set(drawD);
			map.removeLayer("points").removeSource("points");
			map.removeLayer("nodes").removeSource("nodes");
			label_render();
		});
		$(document).delegate(".remover-coordinate","click",function(e){
			dataNum = parseInt($(this).attr("data-num"));
			drawD = draw.getAll();
			
			ele = $("#f_coordinate");
			if(ele.find(".line-child").length > 1){
				$(this).parents(".line-child").remove();
				ele.find(".line-child").each(function(i,v){
					$(v).find(".prefix-icon").text("C"+(i+1));
					$(v).find("input").attr({
						'placeholder': 'Coordinate '+(i+1),
						"data-num": (i+1)
					});
					$(v).find("button").attr("data-num",(i+1));
				});
			}

			drawD.features[0].geometry.coordinates[0].splice(dataNum-1,1);
			if(dataNum==1){
				lengthD = drawD.features[0].geometry.coordinates[0].length;
				dataZero = drawD.features[0].geometry.coordinates[0][0];
				drawD.features[0].geometry.coordinates[0][lengthD-1] = dataZero;
			}
			draw.set(drawD);
			map.removeLayer("points").removeSource("points");
			map.removeLayer("nodes").removeSource("nodes");
			label_render();
		});
		
		$(document).delegate('[name="kml-file"]',"change",function(e){
			const reader = new FileReader();
			reader.onload = event => {
				$out = toGeoJSON["kml"]((new DOMParser()).parseFromString(event.target.result, 'text/xml'));
				$out.features.splice(1);
				draw.set($out);
				$coordinates = $out.features[0].geometry.coordinates[0];
				$.each($coordinates, function(i,v){
					if(i!=$coordinates.length-1)
						add_coordinate_field(v, i==0);
				});
				label_render(true);
			} // desired file content
			reader.onerror = error => reject(error);
			reader.readAsText(this.files[0]);
		});
		/*map.on('draw.selectionchange', (e) => {
			console.log(draw.getMode()+"B");
			
			const { features, points } = e;
			const hasLine = (features && (features.length > 0));
			const hasPoints = (points && (points.length > 0));
			if (hasLine && ! hasPoints) {
				// line clicked
				if (draw.getMode() !== 'direct_select') {
					draw.changeMode('direct_select', { featureId: features[0].id });
				}
			} else if (hasLine && hasPoints) {
				// line vertex clicked
			} else if (! hasLine && ! hasPoints) {
				// deselected
			}
		});*/
		/*L.mapbox.accessToken = code;

		var geocoder = L.mapbox.geocoder('mapbox.places');

		var map = L.mapbox.map('map', null, {
			styleLayer: {
				maxZoom: 23,
				minZoom: 0
			}
		}).setView([-2.483454, 117.964729], 6)
			.addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'))
			.addControl(L.mapbox.geocoderControl('mapbox.places', {
				autocomplete: true,
				countries: "indonesia"
			}));
		
		geocoder.query('Karawang', showMap);

		function showMap(err, data) {
			if (data.lbounds) {
				map.fitBounds(data.lbounds);
			} else if (data.latlng) {
				map.setView([data.latlng[0], data.latlng[1]], 13);
			}
		}

		//Draw
		var featureGroup = L.featureGroup().addTo(map);
		L.EditToolbar.Delete.include({ removeAllLayers: false });
		var drawControlFull = new L.Control.Draw({
			position: 'topright',
			draw: {
				polygon: true,
				polyline: false,
				circle: false,
				rectangle: false,
				circlemarker: false,
				marker: false
			},
			edit: {
				featureGroup: featureGroup,
				remove: true
			}
		}).addTo(map);
		var drawControlEditOnly = new L.Control.Draw({
			position: 'topright',
			draw: {
				polygon: true,
				polyline: false,
				circle: false,
				rectangle: false,
				circlemarker: false,
				marker: false
			},
			edit: {
				featureGroup: featureGroup,
				remove: true
			},
			draw: false
		});

		map.on('draw:created', function(e) {
			featureGroup.addLayer(e.layer);
			$.each(featureGroup._layers, function(i,v){
				v.showMeasurements();
				console.log(
					JSON.stringify(v.toGeoJSON())
				);
			});
			drawControlFull.remove(map);
    		drawControlEditOnly.addTo(map);
		});

		map.on('draw:edited', function(e) {
			$.each(featureGroup._layers, function(i,v){
				v.updateMeasurements()
			});
		});

		map.on('draw:deleted', function(e) {
			if (featureGroup.getLayers().length === 0){
				drawControlEditOnly.remove(map);
				drawControlFull.addTo(map);
			};
		});
		
		// Custom Button
		var stateChangingButton = L.easyButton({
			states: [{
				stateName: 'satellite-layer',
				icon:      'fa-map',
				title:     'Satellite Layer',
				onClick: function(btn, mp) {
					L.mapbox.tileLayer('mapbox.satellite').addTo(map);
					btn.state('streets-layer');
				}
			}, {
				stateName: 'streets-layer',
				icon:      'fa-map-o',
				title:     'Streets Layer',
				onClick: function(btn, mp) {
					L.mapbox.tileLayer('mapbox.streets').addTo(map);
					btn.state('satellite-layer');
				}
			}]
		});

		stateChangingButton.addTo(map);
		
		map.on('pm:create', function (e) {
			var type = e.shape, layer = e.layer._latlngs[0];
			coordinates = [];
			for (var i = 0; i < layer.length; i++) {
				coordinates.push([layer[i].lng, layer[i].lat])
			}
			console.log(coordinates);
		});
		
		map.on('pm:globaleditmodetoggled', e => {
			if(!e.enabled) map.pm.Draw.getShapes();
		});*/
	});

	$(document).delegate('#save_mat', 'click', function(e) {
		$save_mat = (draw.getAll()).features[0];
		delete $save_mat.id;

		$save_data = {
			"draw": $save_mat,
			"view": {
				"center": [map.getCenter().lng, map.getCenter().lat],
				"zoom": map.getZoom(),
			}
		}

		$('input[name="map_geolocation"]').val(JSON.stringify($save_data));
		$('#tambahMap').modal("hide");
	});

	//.fileinput-upload
	//.kv-file-remove
	//$("#input-40").fileinput("disable").fileinput("refresh", {showUpload: false});
</script>