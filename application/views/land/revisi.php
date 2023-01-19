<?php
//$button = "Update";
$form_labeled_input = function ($label, $id, $extra = null, $prefix = null) use ($button) {
	$prefix = !empty($prefix) ? $prefix . '[' . $id . ']' : $id;
	$result = ($button != "Create") ? form_checkbox($prefix, null, false, ['id' => $id]) : "";
	return '<div class="form-group">' .
		$result .
		form_label($label, $id) .
		form_input($id, null, ['class' => 'form-control', 'aria-describedby' => $id . '_help', 'placeholder' => $extra]) .
		'</div>';
};
$form_labeled_dropdown = function ($label, $name, $table, $field, $key, $selected = null, $extra, $prefix = null) use ($button) {
	$prefix = !empty($prefix) ? $prefix . '[' . $key . ']' : $key;
	$result = ($button != "Create") ? form_checkbox($prefix, null, false, ['id' => $key]) : "";
	return '<div class="form-group">' .
		$result .
		form_label($label, $key) .
		cmb_template($name, $table, $field, $key, $selected, $extra) .
		'</div>';
};
$form_labeled_custom = function ($label, $name, $table, $field, $key, $selected = null, $extra, $prefix = null) use ($button) {
	$prefix = !empty($prefix) ? $prefix . '[' . $key . ']' : $key;
	$result = ($button != "Create") ? form_checkbox($prefix, null, false, ['id' => $key]) : "";
	return '<div class="form-group">' .
		$result .
		form_label($label, $key) .
		'<div class="line-up">' .
		cmb_template($name, $table, $field, $key, $selected, $extra) .
		form_input($key, null, ['id' => 'input_' . $key, 'class' => 'form-control', 'aria-describedby' => $key . '_help']) .
		form_button($name, '+', ['class' => 'btn btn-primary']) .
		'</div></div>';
};
$cmb_box = function ($label, $id, $prefix = null) use ($button) {
	$prefix = !empty($prefix) ? $prefix . '[' . $id . ']' : $id;
	$result = ($button != "Create") ? form_checkbox($prefix, null, false, ['id' => $id]) : "";
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
	$string_all .= form_input('col_' . $id . '_doc[]', null, ['class' => 'form-control', 'aria-describedby' => 'col_' . $id . '_help', 'placeholder' => 'keterangan']);
	$string_all .= '<button data-val=' . $id . ' data-method=2 class="btn btn-success btn-xi" style="overflow: unset; margin-right:5px" disabled>
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


<link rel="stylesheet" href="<?php echo base_url() ?>assets/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap-fileinput/css/fileinput.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
<style>
	.panel-title {
		display: inline-block;
		position: absolute;
		right: 26px;
	}

	.select_size {
		min-width: 300px;
	}

	.line-up {
		display: flex;
	}

	.file-caption-main {
		margin-bottom: 5px;
	}

	.krajee-default .file-thumb-progress .progress,
	.krajee-default .file-thumb-progress .progress-bar {
		height: unset;
	}

	.line-up select,
	.line-up input {
		margin-right: 5px;
	}

	.box-up-success {
		border: 1px solid #d2d6de;
		border-top: 3px solid #00a65a;
	}

	.fa-plus_:before {
		content: "\f067";
	}

	input[type=checkbox] {
		display: none;
	}

	input[type=checkbox]+label {
		font-size: 16px;
	}

	input[type=checkbox]+label:before {
		font-family: FontAwesome;
		display: inline-block;
		color: #3c8dbc;
		font-size: large;
	}

	input[type=checkbox]+label:before {
		content: "\f096";
	}

	input[type=checkbox]+label:before {
		letter-spacing: 10px;
	}

	input[type=checkbox]:checked+label:before {
		content: "\f046";
	}

	input[type=checkbox]:checked+label:before {
		letter-spacing: 8px;
	}

	#map {
		position: absolute;
		top: 0;
		bottom: 0;
		right: 0;
		left: 0;
	}

	.easy-button-button .button-state {
		display: inline;
	}

	.leaflet-touch .leaflet-bar button {
		width: 26px;
		height: 26px;
	}

	.leaflet-bar button,
	.leaflet-bar button:hover {
		color: #5b5b5b;
	}

	.map-power {
		height: 550px;
	}

	.form-group .select2-selection {
		height: 34px !important;
	}

	.zup {
		z-index: 1060
	}

	/*.form-group .select2 {
		width: 100% !important;
	}
	
	.form-group .select2 .select2-selection {
		height: 34px !important;
	}

	.zup { z-index: 1060 }*/

	.design-process-section .text-align-center {
		line-height: 25px;
		margin-bottom: 12px;
	}
	.design-process-content {
		border: 1px solid #e9e9e9;
		position: relative;
		padding: 16px 34% 30px 30px;
	}
	.design-process-content img {
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		z-index: 0;
		max-height: 100%;
	}
	.design-process-content h3 {
		margin-bottom: 16px;
	}
	.design-process-content p {
		line-height: 26px;
		margin-bottom: 12px;
	}
	.process-model {
		list-style: none;
		padding: 0;
		position: relative;
		/*max-width: 600px;
		margin: 20px auto 26px;*/
		border: none;
		z-index: 0;
		margin: 15px 0;
	}
	.process-model li::after {
		background: #e5e5e5 none repeat scroll 0 0;
		bottom: 0;
		content: "";
		display: block;
		height: 4px;
		margin: 0 auto;
		position: absolute;
		right: -72px;
		top: 33px;
		width: 85%;
		z-index: -1;
	}
	.process-model li.visited::after {
		background: #57b87b;
	}
	.process-model li:last-child::after {
		width: 0;
	}
	.process-model li {
		display: inline-block;
		/*width: 18%;*/
		width: calc(100%/5 - 3px);
		text-align: center;
		float: none;
	}
	.nav-tabs.process-model > li.active > a,
	.nav-tabs.process-model > li.active > a:hover,
	.nav-tabs.process-model > li.active > a:focus,
	.process-model li a:hover,
	.process-model li a:focus {
		border: none;
		background: transparent;

	}
	.process-model li a {
		padding: 0;
		border: none;
		color: #606060;
		width: 120px;
		margin: 0 auto;
	}
	.process-model li.active,
	.process-model li.visited {
		color: #57b87b;
	}
	.process-model li.active a,
	.process-model li.active a:hover,
	.process-model li.active a:focus,
	.process-model li.visited a,
	.process-model li.visited a:hover,
	.process-model li.visited a:focus {
		color: #57b87b;
	}
	.process-model li.active p,
	.process-model li.visited p {
		font-weight: 600;
	}
	.process-model li i {
		display: block;
		height: 68px;
		width: 68px;
		text-align: center;
		margin: 0 auto;
		background: #f5f6f7;
		border: 2px solid #e5e5e5;
		line-height: 65px;
		font-size: 30px;
		border-radius: 50%;
	}
	.process-model li.active i,
	.process-model li.visited i  {
		background: #fff;
		border-color: #57b87b;
	}
	.process-model li p {
		font-size: 14px;
		margin-top: 11px;
	}
	.process-model.contact-us-tab li.visited a,
	.process-model.contact-us-tab li.visited p {
		color: #606060!important;
		font-weight: normal
	}
	.process-model.contact-us-tab li::after  {
		display: none; 
	}
	.process-model.contact-us-tab li.visited i {
		border-color: #e5e5e5; 
	}

	@media screen and (max-width: 560px) {
		.more-icon-preocess.process-model li span {
			font-size: 23px;
			height: 50px;
			line-height: 46px;
			width: 50px;
		}
		.more-icon-preocess.process-model li::after {
			top: 24px;
		}
	}
	@media screen and (max-width: 380px) { 
		.process-model.more-icon-preocess li {
			width: 16%;
		}
		.more-icon-preocess.process-model li span {
			font-size: 16px;
			height: 35px;
			line-height: 32px;
			width: 35px;
		}
		.more-icon-preocess.process-model li p {
			font-size: 8px;
		}
		.more-icon-preocess.process-model li::after {
			top: 18px;
		}
		.process-model.more-icon-preocess {
			text-align: center;
		}
	}
	@media (max-width: 1199px){
		.img-wizard {
			display: none;
		}
	}
	.w-100{
		width: 100% !important;
	}
</style>
<div class="content-wrapper">
	<section class="content">
		<div class="box box-warning">
			<div class="box-header">
				<i class="ion ion-clipboard"></i>
				<h3 class="box-title">INPUT DATA PEMBEBASAN TANAH</h3>
			</div>
			<div class="box-body">
				<form action="<?php echo $action; ?>" method="post" id="fompt">
					<section class="design-process-section" id="process-tab">
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-6 col-xs-6 img-wizard">
							<img src="<?=base_url("assets/images/form-wizard.png")?>" class="img-responsive">
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
							<!-- design process steps-->
							<!-- Nav tabs -->
							<ul class="nav nav-tabs process-model more-icon-preocess" role="tablist">
								<li role="presentation" class="active"><a href="#discover" aria-controls="discover" role="tab" data-toggle="tab"><i class="fa fa-search" aria-hidden="true"></i>
										<p>STATUS TANAH</p>
									</a></li>
								<li role="presentation"><a href="#strategy" aria-controls="strategy" role="tab" data-toggle="tab"><i class="fa fa-send-o" aria-hidden="true"></i>
										<p>NAMA PEMILIK</p>
									</a></li>
								<li role="presentation"><a href="#optimization" aria-controls="optimization" role="tab" data-toggle="tab"><i class="fa fa-qrcode" aria-hidden="true"></i>
										<p>BUKTI HAK</p>
									</a></li>
								<li role="presentation"><a href="#content" aria-controls="content" role="tab" data-toggle="tab"><i class="fa fa-newspaper-o" aria-hidden="true"></i>
										<p>LUAS TANAH</p>
									</a></li>
								<li role="presentation"><a href="#sp_row" aria-controls="reporting" role="tab" data-toggle="tab"><i class="fa fa-clipboard" aria-hidden="true"></i>
										<p>LIST DOCUMENTS</p>
									</a></li>
							</ul>
							<!-- end design process steps-->
							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="discover">
									<div class="box box-up-success">
										<div class="box-header with-border text-center">
											<h3 class="box-title">STATUS TANAH</h3>
											<div class="box-tools pull-left" style="right: unset;">
												<button type="button" class="btn btn-box-tool subcollapse" data-widget="collapse"><i class="fa fa-chevron-right"></i></button>
											</div>
										</div>
										<div class="box-body">
											<?= $form_labeled_dropdown('Jenis Proyek', 'land_project_type', 'land_project_type', 'land_project_type_name', 'land_project_type_id', null, ["placeholder" => "-----Pilih Project-----"], "status_tanah") ?>
											<?= $form_labeled_input('Sumber (Mediator)', 'mediator', null, "status_tanah") ?>
											<?= $form_labeled_dropdown('Provinsi', 'loc_province', 'loc_province', 'province_name', 'province_id', null, ["placeholder" => "-----Pilih Provinsi-----"], "status_tanah") ?>
											<div class="form-group">
												<?= ($button != "Create") ? '<input id="districts_id" type="checkbox" name="status_tanah[districts_id]" />' : '' ?>
												<label for="districts_id">Kabupaten</label>
												<select name="loc_districts" class="form-control" readonly>
													<option hidden="" disabled="" selected="">-----Pilih Kabupaten-----</option>
												</select>
											</div>
											<div class="form-group">
												<?= ($button != "Create") ? '<input id="sub_district_id" type="checkbox" name="status_tanah[sub_district_id]" />' : '' ?>
												<label for="sub_district_id">Kecamatan</label>
												<select name="loc_sub_district" class="form-control" readonly>
													<option hidden="" disabled="" selected="">-----Pilih Kecamatan-----</option>
												</select>
											</div>
											<div class="form-group">
												<?= ($button != "Create") ? '<input id="village_id" type="checkbox" name="status_tanah[village_id]" />' : '' ?>
												<label for="village_id">Desa/Kelurahan</label>
												<select name="loc_village" class="form-control" readonly>
													<option hidden="" disabled="" selected="">-----Pilih Desa/Kelurahan-----</option>
												</select>
											</div>
											<div class="form-group">
												<?= ($button != "Create") ? '<input id="vgeolocation" type="checkbox"  name="status_tanah[vgeolocation]" />' : '' ?>
												<label for="vgeolocation">Geolocation</label>
												<div class="line-up">
													<input type="text" name="geolocation" readonly placeholder="geolocation" class="form-control" style="margin-right:5px">
													<span class="btn btn-success btn-map" style="overflow: unset; margin-right:5px">
														<span class="glyphicon glyphicon-map-marker"></span>
													</span>
												</div>
											</div>
											<button class="btn btn-primary w-100 next-tab initial-save" data-href="#strategy">NEXT</button>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="strategy">
									<div class="box box-up-success">
										<div class="box-header with-border text-center">
											<h3 class="box-title">NAMA PEMILIK</h3>
											<div class="box-tools pull-left" style="right: unset;">
												<button type="button" class="btn btn-box-tool subcollapse" data-widget="collapse"><i class="fa fa-chevron-right"></i></button>
											</div>
										</div>
										<div class="box-body">
											<?= $form_labeled_input('Pemilik Asal', 'asal_owner', 'Pemilik Asal', "nama_pemilik") ?>
											<?= $form_labeled_input('Pemilik Baru', 'baru_owner', 'Pemilik Baru', "nama_pemilik") ?>
											<?= $form_labeled_input('PPJB Atas Nama', 'ppjb_owner', 'PPJB Atas Nama', "nama_pemilik") ?>
											<?= $form_labeled_input('Keterangan', 'keterangan_owner', 'Keterangan', "nama_pemilik") ?>
											<button class="btn btn-primary w-100 next-tab" data-href="#optimization">NEXT</button>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="optimization">
									<div class="box box-up-success">
										<div class="box-header with-border text-center">
											<div class="box-tools pull-left" style="right: unset;">
												<button type="button" class="btn btn-box-tool subcollapse" data-widget="collapse"><i class="fa fa-chevron-right"></i></button>
											</div>
											<h3 class="box-title">BUKTI HAK</h3>
											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" id="popover_proof"><i class="fa fa-plus_"></i></button>
											</div>
										</div>
										<div class="box-body" id="proof_body">
											<div class="form-group">
												<?= ($button != "Create") ? '<input id="persil" type="checkbox" name="bukti_hak[persil]" />' : '' ?>
												<label data-val="1" for="persil" class="slax_a">PERSIL</label>
												<div class="line-up">
													<input type="text" name="proof_type_id[1][1]" placeholder="No. PERSIL" class="form-control" style="margin-right:5px">
													<button data-val=1 data-method=0 class="btn btn-success btn-xi" style="overflow: unset; margin-right:5px" disabled>
														<span class="glyphicon glyphicon-folder-open"></span>
													</button>
													<button name="remove_proof" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
												</div>
											</div>
											<button class="btn btn-primary w-100 next-tab" data-href="#content">NEXT</button>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="content">
									<div class="box box-up-success">
										<div class="box-header with-border text-center">
											<div class="box-tools pull-left" style="right: unset;">
												<button type="button" class="btn btn-box-tool subcollapse" data-widget="collapse"><i class="fa fa-chevron-right"></i></button>
											</div>
											<h3 class="box-title">LUAS TANAH</h3>
											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" id="popover_map"><i class="fa fa-plus_"></i></button>
											</div>
										</div>
										<div class="box-body" id="map_body">
											<?= $form_labeled_input('Luas Tanah M<sup>2</sup>', 'surface_area', 'Luas Tanah', 'luas_tanah') ?>
											<?= $form_labeled_input('Harga Per M<sup>2</sup>', 'price_per_cubic_meter', 'Harga Per Meter Kubik', 'luas_tanah') ?>
											<?= $form_labeled_input('Harga Total', 'total_price', 'Harga Tanah', 'luas_tanah') ?>
											<div class="form-group">
												<?= ($button != "Create") ? '<input id="sppt" type="checkbox" name="luas_tanah[sppt]" />' : '' ?>
												<label data-val="2" for="sppt" class="slax_b">SPPT</label>
												<div class="line-up">
													<input type="text" name="map_type_id[2][1]" placeholder="No. SPPT" class="form-control" style="margin-right:5px">
													<button data-val=2 data-method=1 class="btn btn-success btn-xi" style="overflow: unset; margin-right:5px" disabled>
														<span class="glyphicon glyphicon-folder-open"></span>
													</button>
													<button name="remove_map" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
												</div>
											</div>
											<button class="btn btn-primary w-100 next-tab" data-href="#sp_row">NEXT</button>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="sp_row"></div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>

<!-- Modal Pengiriman -->
<div class="modal fade" id="tambahDoc">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">Upload File</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="file-loading">
						<input id="file-1" type="file" name="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="btn btn-default" data-dismiss="modal">
					Done
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Pengiriman -->
<div class="modal fade" id="tambahMap">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">Geolocation</div>
			<div class="modal-body">
				<div class="map-power">
					<div id="map"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="save_mat" class="btn btn-success">Simpan</button>
				<div class="btn btn-default" data-dismiss="modal">
					Tutup
				</div>
			</div>
		</div>
	</div>
</div>
<!-- load the third party plugin assets (jquery-confirm) -->
<link href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css" rel="stylesheet" type="text/css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap-fileinput/js/fileinput.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap-fileinput/themes/fa/theme.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/moment/dist/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/moment/dist/id.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script>
	//validation
	$.validator.setDefaults({
		debug: true,
		success: "valid"
	});
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

	_depends = function(e){return $('[name="is_aktif"]').is(":checked")};
	var validator = $("#fompt").validate({
		"rules": {
			"land_project_type" : {required: true},
			"mediator" : {alpha_space: true, maxlength: 50},
			"loc_province" : {required: true},
			"loc_districts" : {required: true},
			"loc_sub_district" : {required: true},
			"loc_village" : {required: true},
			"geolocation" : {required: true},

			"asal_owner" : {alpha_space: true, required: true, maxlength: 50},
			"baru_owner" : {alpha_space: true, required: true, maxlength: 50},
			"ppjb_owner" : {alpha_space: true, required: true, maxlength: 50},
			//"keterangan_owner" : {alpha_space: true, required: true},

			"proof_type_id[1][1]" : {alphanumeric_slash: true, required: true, maxlength: 30},

			"surface_area" : {rupiah: true, required: true},
			"price_per_cubic_meter" : {rupiah: true, required: true},
			"total_price" : {rupiah: true, required: true},

			"map_type_id[2][1]" : {alphanumeric_slash: true, required: true, maxlength: 30}
		},
		success: function(element) {  
			$(element).parents(".form-group").removeClass('has-error').addClass("has-success").find("label:last").remove();
		},
		errorPlacement: function(error, element) {
			element.parents(".form-group").removeClass('has-success').addClass("has-error").append(error.addClass("help-block"));
		}
	});

	$('#fompt').submit(function(e){
		e.preventDefault();
		if($(this).validate().valid()){
			$data_array = {};
			$.map($(this).serializeArray(),function(v,i){
				$data_array[v.name]=v.value;
			});
			
			$.post("<?=base_url("land/create_land")?>",$data_array,function(data){
				location.reload();
			});
		}
	});

	$('a[data-toggle="tab"]').attr("disabled",true);
	$('a[data-toggle="tab"]').parents("li").addClass("disabled");
	
	$('.nav .disabled > a[data-toggle="tab"]').click(function(e) {
        e.preventDefault();
		if($(this).attr("disabled")=="disabled") return false;
			else return true;
    });
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
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

		if($fourty_one){
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
		}
	});

	<?php
	$cvb = $this->db->get("land_document_type")->result_array();
	$result_cvb = [];
	$length = round(sizeof($cvb) / 2);
	foreach ($cvb as $ids => $row) {
		//$result_cvb[(($ids < $length) ? 0 : 1)][$row["land_document_type_id"]] = $row["land_document_type_name"];
		$result_cvb[0][] = [
			"id"=>$row["land_document_type_id"],
			"text"=>$row["land_document_type_name"],
			"extra"=>$row["land_document_type_extra"],
			"disabled"=>false
		];
	}
	echo 'var $arrays=' . json_encode($result_cvb) . ';';
	?>
	var validators_render = {};
	function sp_render(array){
		vpn = '<div class="form-group"> \
				' + "<?= ($button != "Create") ? "<input id='docky_" . '"+a+"' . "' type='checkbox' name='list_doc[" . '"+a+"' . ']' . "'" . '/>' : '' ?>" + ' \
				<label data-val='+ array.id +' for="docky_' + array.id + '" class="dockies">' + array.text + '</label> \
				<div class="line-up"> \
					<select name="col_doc[' + array.id + '][1]" class="form-control"> \
						<option hidden="" disabled="" selected="">--- Pilih Tipe ---</option> \
						<option value="0">ASLI</option> \
						<option value="1">COPY</option> \
						<option>N/A</option> \
					</select>';
		validators_render['[name="col_doc['+array.id+'][1]"]']={required: true};
		z=1;
		$.each(JSON.parse(array.extra), function(i,v){
			z++;
			vpn += '<input type="text" name="col_doc[' + array.id + ']['+(z)+']" value="" class="form-control" aria-describedby="col_doc_help_' + array.id + '_'+(z)+'" placeholder="'+(v)+'">';			
			valid_f = {required: true};
			if((["No","Luas"]).includes(v)){
				valid_f["alphanumeric_slash"]=true;
				valid_f["maxlength"]=30;
			} else if(v=="Tanggal"){
				valid_f["date"]=true;
			} else {
				valid_f["alpha_space"]=true;
				valid_f["maxlength"]=50;
			}
			validators_render['[name="col_doc['+array.id+']['+(z)+']"]']=valid_f;
		});
		z++;
		vpn += '	<input type="text" name="col_doc[' + array.id + ']['+(z)+']" value="" class="form-control" aria-describedby="col_doc_help_' + array.id + '_'+(z)+'" placeholder="keterangan"> \
					<button data-val="' + array.id + '" data-method="2" class="btn btn-success btn-xi" style="overflow: unset; margin-right:5px" disabled> \
						<span class="glyphicon glyphicon-folder-open"></span> \
					</button> \
					<button data-val='+ array.id +' name="remove_list_doc" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button> \
				</div> \
			</div>';
		return vpn;
	}

	$.each($arrays, function(i, v) {
		//adopt = '<div class="col-md-6 col-sm-12"> \
		adopt = ' \
			<div class="box box-up-success"> \
				<div class="box-header with-border text-center"> \
					<div class="box-tools pull-left" style="right: unset;"> \
						<button type="button" class="btn btn-box-tool subcollapse" data-widget="collapse"> \
							<i class="fa fa-chevron-right"></i> \
						</button> \
					</div> \
					<h3 class="box-title">LIST DOCUMENTS</h3> \
					<div class="box-tools pull-right"> \
						<button type="button" class="btn btn-box-tool popover_select2"><i class="fa fa-plus_"></i></button> \
					</div> \
				</div> \
				<div class="box-body">';
		x=0;
		$.each(v, function(a, b) {
			if(x===5) return false;
			b.disabled=true;
			adopt += sp_render(b);
			x++;
		});
		adopt += '<div class="form-group submit-btn"> \
			<button class="btn btn-primary w-100">SUBMIT</button> \
		</div>';
		adopt += '</div>';
		//adopt += '</div> \
		//	</div>';
		$('#sp_row').append(adopt);
		$.each(validators_render,function(i,v){
			$(i).rules("add",v);
		});
		validators_render = {};
		$('[placeholder="Tanggal"]').datetimepicker({ locale: 'id', Default: 'DD-MM-YYYY'});
		//$('.submit-btn').before(adopt);
		//console.log($arrays);
	});

	$('[data-toggle="popover"]').popover();
	$('[name=loc_province]').change(function() {
		$('[name=loc_districts]').attr("readonly", true);
		$('[name=loc_sub_district]').attr("readonly", true);
		$('[name=loc_village]').attr("readonly", true);
		clear([1, 2, 3]);

		$.post('<?= base_url("land/get_districts") ?>', {
			id: $(this).val()
		}, function(data) {
			$.each(data, function(key, value) {
				$('[name=loc_districts]').append($("<option></option>").attr("value", key).text(value));
			});
			$('[name="loc_districts"]').removeAttr("readonly");
		}, 'json').fail(function() {
			console.log("Please check your code and try again!");
		});
	});
	$('[name=loc_districts]').change(function() {
		$('[name=loc_sub_district]').attr("readonly", true);
		$('[name=loc_village]').attr("readonly", true);
		clear([2, 3]);

		$.post('<?= base_url("land/get_sub_districts") ?>', {
			id: $(this).val()
		}, function(data) {
			$.each(data, function(key, value) {
				$('[name=loc_sub_district]').append($("<option></option>").attr("value", key).text(value));
			});
			$('[name="loc_sub_district"]').removeAttr("readonly");
		}, 'json').fail(function() {
			console.log("Please check your code and try again!");
		});
	});
	$('[name=loc_sub_district]').change(function() {
		$('[name=loc_village]').attr("readonly", true);
		clear([3]);

		$.post('<?= base_url("land/get_village") ?>', {
			id: $(this).val()
		}, function(data) {
			$.each(data, function(key, value) {
				$('[name=loc_village]').append($("<option></option>").attr("value", key).text(value));
			});
			$('[name="loc_village"]').removeAttr("readonly");
		}, 'json').fail(function() {
			console.log("Please check your code and try again!");
		});
	});

	function clear($s) {
		if (Array.isArray($s)) {
			$.each($s, function(i, v) {
				if (v == 1) $('[name=loc_districts]').find('option').remove().end()
					.append('<option hidden="" disabled="" selected="">-----Pilih Kabupaten-----</option>');
				if (v == 2) $('[name=loc_sub_district]').find('option').remove().end()
					.append('<option hidden="" disabled="" selected="">-----Pilih Kecamatan-----</option>');
				if (v == 3) $('[name=loc_village]').find('option').remove().end()
					.append('<option hidden="" disabled="" selected="">-----Pilih Desa/Kelurahan-----</option>');
			});
		}
	}
	$("#popover_map, #popover_proof, .popover_select2").click(function() {
		if ($(this).children("i").hasClass("fa-plus_"))
			$(this).children("i").removeClass("fa-plus_").addClass("fa-close");
		else $(this).children("i").removeClass("fa-close").addClass("fa-plus_");
	});

	$(".subcollapse").click(function() {
		if ($(this).children("i").hasClass("fa-chevron-right"))
			$(this).children("i").removeClass("fa-chevron-right").addClass("fa-chevron-down");
		else $(this).children("i").removeClass("fa-chevron-down").addClass("fa-chevron-right");
	});
	$(".popover_select2").popover({
		html: true,
		content: '<div class="form-group" style="display: flex; margin-bottom: 0">' +
			'<select name="input_doc" style="width: 100%; height:34px" class="form-control">' +
			'<option hidden="" disabled="" selected="">-----Pilih Documents-----</option>' +
			'</select>' +
			'<button name="button_doc" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span></button>' +
			'</div>',
		template: '<div class="popover select_size" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
		placement: "bottom",
		trigger: "click",
		//container : 'body'
	});
	$('.popover_select2').on('shown.bs.popover', function() {
		$('[name="input_doc"]').select2({data:$arrays[0]}).on('select2:open', function(e) {
			$('.select2-container:last').addClass("zup");
		}).on("select2:selecting", function(evt, f, g) {
			var selId = evt.params.args.data.id;
   			//var group = $("option[value='" + selId + "']").attr("groupid");
			console.log(selId);
			//$("$dockies").each()
      		//disableSel2Group(evt, this, true);
    	}).on("select2:unselecting", function(evt) {
			//disableSel2Group(evt, this, false);
		});
		$('[name="button_doc"]').click(function(e){
			e.preventDefault();
			if($('[name="input_doc"]').val()){
				$dopt = $arrays[0][$('[name="input_doc"]').val()-1];
				$dopt.disabled = true;
				$rowp = sp_render($dopt);
				//$('#sp_row .box-body').append($rowp);
				$('.submit-btn').before($rowp);
				$.each(validators_render,function(i,v){
					$(i).rules("add",v);
				});
				validators_render = {};
				$('[placeholder="Tanggal"]').datetimepicker({ locale: 'id', Default: 'DD-MM-YYYY'});
			}
		});

		$(".select2-container:first").addClass("wcup");
		$('.select2-selection--single').addClass("hcup");
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
			'<?= cmb_template('input_map', 'map_proof_type', 'map_proof_type_name', 'map_proof_type_id', null, ['placeholder' => '-----Pilih Jenis Dokumen-----']) ?>' +
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

		$row_t = "<?= ($button != "Create") ? "<input id='" . '"+l_text+"' . "' type='checkbox' name='" . '"+$pvr_id[$(this).attr("name")][4]+"["+l_text+' . '"]' . "'" . '/>' : '' ?>";

		if (value && v_true) {
			$($pvr_id[$(this).attr("name")][5]).find(".next-tab").before('<div class="form-group"> \
				' + $row_t + ' \
				<label for=' + l_text + ' data-val=' + value + ' class="' + $pvr_id[$(this).attr("name")][0] + '">' + v_text + '</label> \
				<div class="line-up"> \
					<input type="text" name="' + $pvr_id[$(this).attr("name")][2] + '[' + value + '][1]" placeholder="No. ' + v_text + '" class="form-control" style="margin-right:5px"> \
					<span data-method='+ $pvr_id[$(this).attr("name")][6] +' data-val=' + value + ' class="btn btn-success btn-xi" style="overflow: unset; margin-right:5px" disabled> \
						<span class="glyphicon glyphicon-folder-open"></span> \
					</span> \
					<button name="' + $pvr_id[$(this).attr("name")][3] + '" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button> \
				</div> \
			</div>');
		}
		$($pvr_id[$(this).attr("name")][1] + " option:selected").attr("disabled", "disabled").attr("hidden", "hidden");
		$($pvr_id[$(this).attr("name")][1]).val($($pvr_id[$(this).attr("name")][1] + " option:first").text());
		$($pvr_id[$(this).attr("name")][1] + " option:first").removeAttr("disabled").removeAttr("hidden").attr("selected", "selected");
		$($pvr_id[$(this).attr("name")][1] + " option:first").attr("disabled", "disabled").attr("hidden", "hidden");
		$('[name="' + $pvr_id[$(this).attr("name")][2] + '[' + value + '][1]"]').rules( "add", {alphanumeric_slash: true, required: true, maxlength: 30});
	});

	var was_create = false;
	$(document).delegate('.btn-xi', 'click', function(e) {
		e.preventDefault();

		xc_box = String($(this).siblings("input").attr("name")).slice(0, -3);
		//console.log(xc_box);

		$id = $(this).attr("data-val");
		var $urle = $(this).attr("data-method");
		$node_id = ['#proof_body','#map_body','#sp_row'];
		$method_id = ['proof_type_id','map_type_id','col_file'];
		
		if($urle == 2) xc_box = xc_box.replace(new RegExp("[a-zA-Z_]+","g"),"col_file");
		
		file_option = {
			theme: 'fa',
			uploadUrl: "<?= base_url('land/upload_image/') ?>" + $urle,
			deleteUrl: "<?= base_url('land/upload_delete/') ?>",
			uploadExtraData: {
				id: $id,
				urle: $urle
			},
			allowedFileTypes: ["image","pdf"],
			//enableResumableUpload: true,
			allowedFileExtensions: ["jpg", "jpeg", "gif", "png", "pdf"],
			overwriteInitial: false,
			maxFileSize: 10000,
			maxFilesNum: 10,
			layoutTemplates: {
				main1: "<div class=\'input-group {class}\'>\n" +
					"   <div class=\'input-group-btn\ input-group-prepend'>\n" +
					"       {browse}\n" +
					"   </div>\n" +
					"   {caption}\n" +
					"   <div class=\'input-group-btn\ input-group-prepend'>\n" +
					"       {remove}\n" +
					"       {upload}\n" +
					"   </div>\n" +
					"</div>" + "{preview}\n"
			},
			slugCallback: function(filename) {
				return filename.replace('(', '_').replace(']', '_');
			}
		};

		if($('[name^="'+$method_id[$urle]+'['+$id+']"][type="hidden"]').length){
			array_image = [];
			array_option = [];
			$('[name^="'+$method_id[$urle]+'['+$id+']"][type="hidden"]').each(function(i,v){
				array_image.push('<?=base_url("land/show_file/")?>'+v.value);
				$.ajax({
					async: false,
					type: 'GET',
					dataType: "JSON",
					url: '<?=base_url("land/info_file/")?>'+v.value,
					success: function(raw_data) {
						array_option.push({filetype:raw_data.mime, type:raw_data.type, size:raw_data.size, key: v.value, extra: {method:"-1",urle:$urle,id:$id}});
					}
				});
				//array_option.push({key: v.value, extra: {method:"-1",urle:$urle,id:$id}});
			});
			file_option["initialPreview"]=array_image;
			file_option["initialPreviewConfig"]=array_option;
			file_option["initialPreviewAsData"]=true;
		}

		$("#file-1").fileinput('destroy').fileinput(file_option);

		if(was_create==false){
			$("#file-1").on('fileuploaded', function(event, previewId, index, fileId) {
				key = previewId.response.key;
				filename = previewId.response.filename;
				urle = previewId.response.urle;
				id = previewId.response.id;
				method = previewId.response.method;
				ele = $(document.getElementById(index));
				ele.find(".file-footer-caption").attr("title", filename);
				ele.find(".file-caption-info").text(filename);
				ele.find(".kv-file-remove").click(function(e) {
					//e.preventDefault();
					$.post("<?= base_url('land/upload_delete') ?>", {
						filename: filename,
						method: method,
						urle: urle,
						key: key,
						id: id,
					}, function(data) {
						$method_id = ['proof_type_id','map_type_id','col_file'];
						$('[name^="'+$method_id[data.urle]+'['+data.id+']"][value="'+data.key+'"]').remove();
					},"JSON");
				});
				$node_length = $('[name^="'+xc_box+'"]').length + 1;
				//console.log(method);
				//console.log($('[name="'+xc_box+'['+($node_length-1)+']]').val()!=key);
				//console.log($node_id[method]);
				if($('[name="'+xc_box+'['+($node_length-1)+']]').val()!=key){
					$($node_id[method]).append('<input type="hidden" value="'+key+'" name="'+xc_box+'['+$node_length+']">');
				}
			});
			$("#file-1").on('filedeleted', function(event, key, jqXHR, data) {
				$method_id = ['proof_type_id','map_type_id','col_file'];
				$('[name^="'+$method_id[data.urle]+'['+data.id+']"][value="'+key+'"]').remove();
			});
			was_create=true;
		}
		$("#tambahDoc").modal('show');

		var canvasElement = $(".file-preview-thumbnails")[0];
		obs.observe(canvasElement, {
			childList: true,
			subtree: true
		});
	});

	MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

	var obs = new MutationObserver(function(mutations, observer) {
		$.each(mutations, function(i, mutation) {
			var addedNodes = $(mutation.addedNodes);
			var removedNodes = $(mutation.removedNodes);
			var selector = ".kv-file-upload"
			var selector2 = ".file-preview-frame"
			var filteredEls = addedNodes.find(selector).addBack(selector);
			var filteredElse = removedNodes.find(selector2).addBack(selector2);
			filteredEls.each(function() {
				$(this).click();
				//console.log('Insertion detected: ' + $(this).html());
			});
			filteredElse.each(function() {
				//$(this).preventDefault();
				//console.log($(this));
				//$(this).click();
				//console.log('Insertion detected: ' + $(this).html());
			});
		});
	});


	//testing
	$datalah = {
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
	}
	//$('input[name="geolocation"]').val(JSON.stringify($datalah));

	$(".btn-map").click(function(e) {
		$("#tambahMap").modal("show");
	});

	var $raw_data = ""; var map_query;
	$('#tambahMap').on('shown.bs.modal', function() {
		try {
			$current_data = JSON.parse($('input[name="geolocation"]').val());
		} catch (e) {
			$current_data = {};
		}

		const code = 'pk.eyJ1IjoiZ2VyeWYzZjMiLCJhIjoiY2thaXAzbHBlMDJibDJxcGZnMXlhaGNzMyJ9.hEUths9qWrjH_TkaHQ2eng';
		map_args = {
			container: 'map', // container id
			style: 'mapbox://styles/mapbox/satellite-streets-v11'
		}
		if($current_data.view != undefined){
			map_args["center"]=$current_data.view.center;
			map_args["zoom"]=$current_data.view.zoom;
		}
		mapboxgl.accessToken = code;
		var map = new mapboxgl.Map(map_args);

		var LotsOfPointsMode = {};
		LotsOfPointsMode.onDrag = function(state, e) {
			e.preventDefault();
		};
		var draw = new MapboxDraw({
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
		map_query = $('[name="loc_village"] option:selected').text()+" "+$('[name="loc_sub_district"] option:selected').text();
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

		map.addControl(draw);

		var $temp_coor;

		function label_render() {
			if (map.getLayer("points") != undefined) {
				map.removeLayer("points").removeSource("points");
			}
			var data = draw.getAll();
			if (data.features.length > 0) {
				$(".mapbox-gl-draw_polygon").attr("disabled", true);

				features = [];
				//$(".mapbox-gl-draw_trash").attr("disabled",true);
				$.each(data.features[0].geometry.coordinates[0], function(i, v) {
					length_coordinates = data.features[0].geometry.coordinates[0].length - 1;
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
				});

				area = turf.area(data);
				centroid = turf.centroid(data);

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

				map.addLayer(generate_layer("points", "points"));

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
				//console.log(JSON.stringify($raw_data));
			}
		}

		$(".mapbox-gl-draw_trash").click((e) => {
			e.preventDefault();
			draw.deleteAll();
			if (map.getLayer("points") != undefined) {
				map.removeLayer("points").removeSource("points");
			}
			$(".mapbox-gl-draw_polygon").attr("disabled", false);
		});

		geocoder.on('results', function(results) {
			console.log(results);
		});

		map.on('load', function() {
			if($current_data.draw!=undefined){
				var featureIds = draw.add($current_data.draw);
			}
			label_render();
		});

		map.on('draw.create', function(e) {
			label_render();
		});

		map.on('draw.update', function(e) {
			console.log(e.action);
			if (e.action === 'move') {
				draw.deleteAll();
				draw.add($temp_coor);
			}
			label_render();
		});
		/*map.on('draw.delete', function(e) {
			if(map.getLayer("points") != undefined){
				map.removeLayer("points").removeSource("points");
			}
		});
		map.on('draw.selectionchange', (e) => {
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
		console.log(JSON.stringify($raw_data));
		$('input[name="geolocation"]').val(JSON.stringify($raw_data));
		$('#tambahMap').modal("hide");
	});

	//.fileinput-upload
	//.kv-file-remove
	//$("#input-40").fileinput("disable").fileinput("refresh", {showUpload: false});
</script>