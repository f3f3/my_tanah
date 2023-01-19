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
<link href="<?=base_url()?>assets/jquery-confirm/dist/jquery-confirm.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css" />

<style>
    .map-power {
        position: relative;
        height: 400px;
    }
    #map {
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
    }
    .hRem {
        height: calc(100% - 1.25rem);
    }
    /*tbody tr td:nth-child(2){
        text-align: center !important;
    }*/
    tr td:last-child {
        width: 21%;
        white-space: nowrap;
    }
    span.comment {
        font-family: "anticon" !important;
        display: inline-block;
        color: #3c8dbc;
        font-size: large;
    }
    span.comment:hover {
       color: #bc3c3c;
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
		left: 24px;
		/* top: 80px; */
		font-size: 28px;
		line-height: 27px;
    }
    .fs-14 {
        font-size: 14px;
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
    .left_c {
        position: relative;
    }
    .left_c span.comment:after {
		left: -5px;
	}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="media align-items-center">
                            <div class="avatar avatar-image rounded" style="background:none">
                                <img src="<?=base_url("assets")?>/enlink/images/logo/favicon.png" alt="">
                            </div>
                            <div class="m-l-10">
                                <h4 class="m-b-0" data-name="land_documents_code">\</h4>
                            </div>
                        </div>
                        <div>
                            <span class="fs-14 badge badge-pill" data-name="land_status_approved"></span>
                            <span class="fs-14 badge badge-pill badge-blue" data-name="land_status_type_name">In Progress</span>
                        </div>
                    </div>
                    <div class="m-t-40">
                        <h5 data-name="map_geolocation">Map</h5>
                        <div class="map-power">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
                <div class="m-t-30">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#project-details-tasks">Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#project-details-attachment">Attachment</a>
                        </li>
                        <li class="nav-item ml-auto mr-3">
                            <button id="save_land" class="btn btn-success btn-block"><i class="anticon anticon-save"></i> SAVE</button>
                        </li>
                    </ul>
                    <div class="tab-content m-t-15 p-25">
                        <div class="tab-pane fade show active" id="project-details-tasks">
                            <div class="row row-eq-height">
                            <?php if(in_array($this->session->userdata('id_user_level'),[6,8,2,1])): ?>
                                <div class="col-md-6">
                                    <div class="card hRem">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">Basic Info</h4>
                                            <div class="table-responsive">
                                                <table class="table-hover product-info-table table-sm m-t-20">
                                                    <tbody>
                                                        <tr>
                                                            <td>Document Code</td>
                                                            <td data-id="land_documents_code" data-name="land_documents_code"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jenis Proyek</td>
                                                            <td data-id="land_project_id" data-name="land_project_type_name"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Staus Fisik Tanah</td>
                                                            <td data-id="land_physics_id" data-name="land_physics_name"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sumber (Mediator)</td>
                                                            <td data-id="land_mediator" data-name="land_mediator"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tanah Sudah Dipatok</td>
                                                            <td>
                                                                <span data-id="land_di_patok" data-name="land_di_patok" class="badge badge-pill"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sudah Dalam PTSL</td>
                                                            <td>
                                                                <span data-id="land_di_ptsl" data-name="land_di_ptsl" class="badge badge-pill"></span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card hRem">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">Address</h4>
                                            <div class="table-responsive">
                                                <table class="table-hover product-info-table table-sm m-t-20">
                                                    <tbody>
                                                        <tr>
                                                            <td>Provinsi</td>
                                                            <td data-id="map_province_id" data-name="province_name"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Kabupaten</td>
                                                            <td data-id="map_districts_id" data-name="districts_name"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Kecamatan</td>
                                                            <td data-id="map_sub_district_id" data-name="sub_district_name"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Desa/Kelurahan</td>
                                                            <td data-id="map_village_id" data-name="village_name"></td>
                                                        </tr>
                                                    </tbody>
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card hRem">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">Owner Info</h4>
                                            <div class="table-responsive">
                                                <table class="table-hover product-info-table table-sm m-t-20">
                                                    <tbody>
                                                        <tr>
                                                            <td>Pemilik Asal</td>
                                                            <td data-id="owner_initial_name" data-name="owner_initial_name"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pemilik Baru</td>
                                                            <td data-id="owner_final_name" data-name="owner_final_name"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>PPJB Atas Nama</td>
                                                            <td data-id="owner_ppjb" data-name="owner_ppjb"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Keterangan</td>
                                                            <td data-id="owner_annotation" data-name="owner_annotation"></td>
                                                        </tr>
                                                    </tbody>
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card hRem">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">Surface Area</h4>
                                            <div class="table-responsive">
                                                <table class="table-hover product-info-table table-sm m-t-20">
                                                    <tbody>
                                                        <tr>
                                                            <td>By Document</td>
                                                            <td><span data-id="surface_area_by_doc" data-name="surface_area_by_doc"></span> M<sup>2</sup></td>
                                                        </tr>
                                                        <tr>
                                                            <td>By Remeasurement</td>
                                                            <td><span data-id="surface_area_by_remeas" data-name="surface_area_by_remeas"></span> M<sup>2</sup></td>
                                                        </tr>
                                                        <tr>
                                                            <td>By GPS</td>
                                                            <td><span data-id="surface_area_by_geo" data-name="surface_area_by_geo"></span> M<sup>2</sup></td>
                                                        </tr>
                                                    </tbody>
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if(in_array($this->session->userdata('id_user_level'),[6,7,2,1])): ?>
                                <div class="col-md-6">
                                    <div class="card hRem">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">Initial Price</h4>
                                            <div class="table-responsive">
                                                <table class="table table-hover product-info-table table-sm m-t-20">
                                                    <tbody>
                                                        <tr>
                                                            <td>Luas Beli</td>
                                                            <td><span data-id="surface_area_by_purchase" data-name="surface_area_by_purchase"></span> M<sup>2</sup></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Harga Beli</td>
                                                            <td><span data-id="surface_data[1][1][1]" data-name="surface_data[1][1][1]"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tahun Beli</td>
                                                            <td><span data-id="surface_data[1][1][2]" data-name="surface_data[1][1][2]"></td>
                                                        </tr>
                                                    </tbody>
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card hRem">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">Market Price</h4>
                                            <div class="table-responsive">
                                                <table class="table table-hover product-info-table table-sm m-t-20">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th scope="col">Harga M<sup>2</sup></th>
                                                            <th scope="col">Tahun</th>
                                                            <th scope="col">#</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="by_market">
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card hRem">
                                        <div class="card-body">
                                            <h4 class="card-title text-center">NJOP Price</h4>
                                            <div class="table-responsive">
                                                <table class="table table-hover product-info-table table-sm m-t-20">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th scope="col">Harga M<sup>2</sup></th>
                                                            <th scope="col">Tahun</th>
                                                            <th scope="col">#</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="by_njop">
                                                    </tbody>
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="project-details-attachment">
                            <div class="row">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Activities</h4>
                </div>
                <div class="card-body">
                    <ul class="timeline timeline-sm">
                        <li class="timeline-item">
                            <div class="timeline-item-head">
                                <div class="avatar avatar-icon avatar-sm avatar-cyan">
                                    <i class="anticon anticon-check"></i>
                                </div>
                            </div>
                            <div class="timeline-item-content">
                                <div class="m-l-10">
                                    <div class="media align-items-center">
                                        <div class="avatar avatar-image">
                                            <img src="assets/images/avatars/thumb-4.jpg" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <h6 class="m-b-0">Virgil Gonzales</h6>
                                            <span class="text-muted font-size-13">
                                                <i class="anticon anticon-clock-circle"></i>
                                                <span class="m-l-5">10:44 PM</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="m-t-20">
                                        <p class="m-l-20">
                                            <span class="text-dark font-weight-semibold">Complete task </span> 
                                            <span class="m-l-5"> Prototype Design</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-item">
                            <div class="timeline-item-head">
                                <div class="avatar avatar-icon avatar-sm avatar-blue">
                                    <i class="anticon anticon-link"></i>
                                </div>
                            </div>
                            <div class="timeline-item-content">
                                <div class="m-l-10">
                                    <div class="media align-items-center">
                                        <div class="avatar avatar-image">
                                            <img src="assets/images/avatars/thumb-8.jpg" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <h6 class="m-b-0">Lilian Stone</h6>
                                            <span class="text-muted font-size-13">
                                                <i class="anticon anticon-clock-circle"></i>
                                                <span class="m-l-5">8:34 PM</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="m-t-20">
                                        <p class="m-l-20">
                                            <span class="text-dark font-weight-semibold">Attached file </span> 
                                            <span class="m-l-5"> Mockup Zip</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-item">
                            <div class="timeline-item-head">
                                <div class="avatar avatar-icon avatar-sm avatar-purple">
                                    <i class="anticon anticon-message"></i>
                                </div>
                            </div>
                            <div class="timeline-item-content">
                                <div class="m-l-10">
                                    <div class="media align-items-center">
                                        <div class="avatar avatar-image">
                                            <img src="assets/images/avatars/thumb-1.jpg" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <h6 class="m-b-0">Erin Gonzales</h6>
                                            <span class="text-muted font-size-13">
                                                <i class="anticon anticon-clock-circle"></i>
                                                <span class="m-l-5">8:34 PM</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="m-t-20">
                                        <p class="m-l-20">
                                            <span class="text-dark font-weight-semibold">Commented  </span> 
                                            <span class="m-l-5"> 'This is not our work!'</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-item">
                            <div class="timeline-item-head">
                                <div class="avatar avatar-icon avatar-sm avatar-purple">
                                    <i class="anticon anticon-message"></i>
                                </div>
                            </div>
                            <div class="timeline-item-content">
                                <div class="m-l-10">
                                    <div class="media align-items-center">
                                        <div class="avatar avatar-image">
                                            <img src="assets/images/avatars/thumb-6.jpg" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <h6 class="m-b-0">Riley Newman</h6>
                                            <span class="text-muted font-size-13">
                                                <i class="anticon anticon-clock-circle"></i>
                                                <span class="m-l-5">8:34 PM</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="m-t-20">
                                        <p class="m-l-20">
                                            <span class="text-dark font-weight-semibold">Commented  </span> 
                                            <span class="m-l-5"> 'Hi, please done this before tommorow'</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

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

<script type="text/javascript" src="<?=base_url()?>assets/jquery-confirm/dist/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-fileinput/js/fileinput.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-fileinput/themes/anticon/theme.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-fileinput/js/plugins/piexif.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-fileinput/js/plugins/purify.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/bootstrap-fileinput/js/plugins/sortable.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/moment/dist/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/moment/dist/id.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script>
    /*var fileHeader = function(arrays){
        fileAS = $("<div>",{"class":"file","style":"min-width: 200px;"});

        $("<div>",{"class":"media align-items-center"}).append(
            $("<div>",{"class":"avatar avatar-icon avatar-cyan rounded m-r-15"}).append(
                $("<i>",{"class":"anticon anticon-file-exclamation font-size-20"})
            ),
            $("<div>").append(
                $("<h6>",{"class":"mb-0"}).text(arrays),
                $("<span>",{"class":"font-size-13 text-muted"}).text(arrays),
            )
        )
        $("<div>",{"class":"file-manager-content-files"}).append(
            $("<div>",{"class":"d-flex justify-content-between"}).append(
                $("<div>",{"class":"media align-items-center"}).append(
                    $("<div>",{"class":"m-l-10"}).append(
                        $("<h4>",{"class":"m-b-0"}).text(arrays)
                    )
                    $("<div>").append(
                        $("<span>",{"class":"fs-14 badge badge-pill"}).text(arrays),
                        $("<span>",{"class":"fs-14 badge badge-pill badge-blue"}).text(arrays)
                    )
                )
            ),
            $("<h5>",{"class":"relative"}).text(arrays),
            $("<div>",{"class":"file-wrapper m-t-20"}).append(
                
            )
        )
    }*/

    var escalate = true;
    var comments = {};
    comment_ele = (name, commented)=>{
        cmtd = comments[name]!==undefined;
        c_ele = (commented===true||cmtd)?" ed":"";
        return escalate||cmtd?$("<span>",{
            class:"comment"+c_ele,
            rel:"comments",
            "data-placement":"right",
            "data-comment":name
        }):false;
    }
    var $arrays=[];
    $.getJSON('<?=base_url("land/select2_data/".(!empty($land_id)?$land_id:"")."/0")?>', function(data){
		Object.keys(data[0]).forEach(function(key) {
			$arrays[data[0][key]["id"]] = data[0][key];
		});
        console.log($arrays);
        $.post('<?=base_url("land/land_data")?>', {id:<?=$land_id?>, "show_data":true}, function(data){
            escalate = data.land.land_status_type_id=="2";
            if(!Array.isArray(data.comments) && data.land.land_status_type_id=="3") comments = data.comments;

            $current_data = [];
            if(data.land.map_geolocation){
                $current_data = JSON.parse(data.land.map_geolocation);
                $center = $current_data.view.center;
                $zoom = $current_data.view.zoom;
            } else {
                $center = [107.29436403524119,-6.068124458562423];
                $zoom = 19.260128546697988;
                $current_data.draw = 0;
            }

            const code = 'pk.eyJ1IjoiZ2VyeWYzZjMiLCJhIjoiY2thaXAzbHBlMDJibDJxcGZnMXlhaGNzMyJ9.hEUths9qWrjH_TkaHQ2eng';
            mapboxgl.accessToken = code;
            var map = new mapboxgl.Map({
                container: 'map', // container id
                style: 'mapbox://styles/mapbox/satellite-streets-v11',
                center: $center,
                zoom: $zoom
            });
            map.on('load', function() {
                if($current_data.draw!=0){
                    map.addSource('maine', {
                        'type': 'geojson',
                        'data': $current_data.draw
                    });
                    map.addLayer({
                        'id': 'lines',
                        'type': 'line',
                        'source': 'maine',
                        'paint': {
                            'line-width': 3,
                            'line-color': '#088'
                        }
                    });

                
                    features = [];
                    $.each($current_data.draw.geometry.coordinates[0], function(i, v) {
                        length_coordinates = $current_data.draw.geometry.coordinates[0].length - 1;
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

                    area = turf.area($current_data.draw);
                    centroid = turf.centroid($current_data.draw);

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
                

                    map.addLayer({
                        'id': "points",
                        'type': 'symbol',
                        'source': "points",
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
                    });
                }
            });
            //console.log(data);
            $.each(data.land, (i,v)=>{
                v = v!=""?v:"-";
                var element = $('[data-name="'+i+'"]');
                var element_id = element.last().data("id");

                if(i.includes("land_di_")) {
                    element.addClass(parseInt(v)?"badge-success":"badge-danger");
                    v=parseInt(v)?"Sudah":"Belum";
                }
                if(i.includes("land_status_approved")){
                    element.addClass(parseInt(v)?"badge-green":"badge-orange");
                    v=parseInt(v)?"Approved":"Submission";
                };
                if(i.includes("surface_area")){
                    v=parseInt(v).toLocaleString('id-ID');
                }
                if(i!="map_geolocation") element.text(v);
                    else element.prepend(comment_ele(element_id));
                if(i.includes("land_di_") || i.includes("surface_area")){
                    element.parent().siblings("td").prepend(comment_ele(element_id));
                } else {
                    element.siblings("td").prepend(comment_ele(element_id));
                }
            });
            $doku = [];
            $.each(data["documents"][83], function(i,v){
                $doku[v["file_extra"]["Tahun"]] = v["document_id"];
            });
            $.each(data["documents"][84], function(i,v){
                $doku[v["file_extra"]["Tahun"]] = v["document_id"];
            });
            $.each(data["surface_area"], (i,v)=>{
                $.each(v, (a,b)=>{
                    $element = '<tr>';
                    $.each(b, (t,y)=>{
                        var dname = 'surface_data['+i+']['+(a+1)+']['+(t+1)+']';
                        if(!t) y = "Rp. "+parseInt(y).toLocaleString('id-ID');
                        val_dname = comment_ele(dname);
                        if(i==1){
                            //if(!t) $('[data-name="'+dname+'"]').parent().siblings("td").prepend(val_dname);
                            $('[data-name="'+dname+'"]').parent().siblings("td").prepend(val_dname);
                            if(!t) {
                                $('[data-name="'+dname+'"]').text(y);
                            } else {
                                $('[data-name="'+dname+'"]').append(y);
                            }
                        } else if(t<2){
                            $element += '<td data-name="'+dname+'" data-id="'+dname+'"><div class="left_c">';
                            $element += val_dname?val_dname.prop('outerHTML'):"";
                            $element += y+'</div></td>';
                        }
                    });
                    if($element != '<tr>'){
                        if($doku[b[2]])
                            $element += '<td><button data-id="'+$doku[b[2]]+'" data-method="2" class="btn btn-sm btn-success mr-1 btn-xi"> \
                                <i class="anticon anticon-folder-open anticon-lg"></i></button></td>';
                        $(".by_"+(i==2?"market":"njop")).append($element+"</tr>");
                    }
                    
                });
            });
            $.each(data["documents"], function(i,v){
                if(!Array.isArray(v)) $('#project-details-attachment .row').append(sp_render($arrays[i],v));
            });
            if(escalate){
                $("#save_land").click(()=>{
                   $.ajax({
                        type: "POST",
                        data: {
                            id:<?=$land_id?>,
                            data:JSON.stringify(comments),
                            user:data.history.land_user_history_id
                        },
                        url: "<?=base_url("land/approval")?>",
                        async: false,
                        success: function(data){
                            location.reload();
                        }
                    });
                });
            } else {
                $("#save_land").remove();
            }
        }, "JSON");
    });
    $(document).delegate('[rel="comments"]', "click", (e)=>{
        selfis = $(e.target);
        summernote = "";
        summernote_toolbar = [];
        buttons = {later: function(){}};
        if(escalate){
            buttons["submit"] = {
                btnClass: 'btn-orange',
                action: function(){
                    summervalue = summernote.summernote('code');
                    summerclean = summervalue.replace(/<\/?[^>]+(>|$)/g, "");
                    if(summerclean!=""){
                        comments[selfis.data("comment")]=summervalue;
                        selfis.not(".ed").addClass("ed");
                    }
                    //console.log(comments[selfis.data("comment")]);

                    //$.alert(summervalue, 'Hello');
                }
            }
            summernote_toolbar = [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['action', ['undo', 'redo']],
            ];
        }
        $.confirm({
            title: 'Comment',
            columnClass: 'xlarge',
            content: '<textarea id="summernote" name="editordata"></textarea>',
            onContentReady: function(){
                if(escalate) summernote.summernote('focus');
            },
            onOpenBefore: function(){
                // console.log(comments[selfis.data("comment")]);
                summernote = this.$content.find('#summernote');
                summernote.summernote({
                    height: 300,
                    toolbar: summernote_toolbar
                });
                summernote.summernote('foreColor', 'black');
                summernote.summernote('fontName', 'Poppins');
                summernote.summernote("code", comments[selfis.data("comment")]);
                if(!escalate) summernote.summernote("disable");
            },
            buttons: buttons
        });
    });

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
				"file_type":0,
				"file_annoations":"",
				"file_extra":[]
			};
		}
		ar_pn = ["ASLI","COPY","N/A"];
		$select_oName = "col_doc[" + array.id + "][1]";
		$select_o = $("<select>",{"name":$select_oName,"class":"form-control mr-1","disabled":true});
		$.each(ar_pn, function(i,v){ $select_o.append($("<option>",{"value":i,"selected":(i==rData["file_type"])}).text(v)) });
		$dFlex = $("<div>",{"class":"d-flex align-items-center"}).append(sp_noela($select_o, $select_oName));
		

		z=1;
		$.each(array.extra, function(i,v){
			z++;
			$inputField = $("<input>",{
				"type":"text",
				"name":"col_doc[" + array.id + "]["+(z)+"]",
				"class":"form-control mr-1",
				"placeholder":v,
                "value":rData["file_extra"][i],
                "disabled": true
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
		});
		z++;
		
		$dFlex.append(
			sp_noela($("<input>",{
				"type":"text",
				"name":"col_doc[" + array.id + "]["+(z)+"]",
				"class":"form-control mr-1",
				"placeholder":"keterangan",
                "value":rData["file_annoations"],
                "disabled":true
			}), "col_doc[" + array.id + "]["+(z)+"]")
		).append(
			$("<button>", {"data-val":array.id, "data-method":2, "class":"btn btn-success mr-1 btn-xi", "disabled":rData["document_id"]===undefined})
				.append($("<i>",{"class":"anticon anticon-folder-open anticon-lg"}))
		);

		$formGroup = $("<div>",{class:"form-group colDoc"})
			.append($("<label>",{"data-val":array.id, "for":"docky_"+array.id, "class":"dockies"}).text(array.text))
			.append($dFlex)

		if(rData["document_id"]) $formGroup.append($("<input>",{"type":"hidden", "name":"col_doc[" + array.id + "][id]","value":rData["document_id"]}));
		return $("<div>",{class:"col-xs-12 col-sm-12 col-md-12 col-lg-6"}).append($formGroup);
	}
    
    $(document).delegate('.btn-xi', 'click', function(e) {
		e.preventDefault();
		$di = $('[name="land_id"]').val();
		$vf = $(this);
		$id = $vf.attr("data-val");
		
		file_option = {
			theme: 'anticon',
			allowedFileTypes: ["image","pdf"],
			allowedFileExtensions: ["jpg", "jpeg", "gif", "png", "pdf"],
			maxFileSize: 10000,
			maxFilesNum: 10,
			browseClass: "btn btn-primary wfile",
            showCaption: false,
            showClose: false,
            showBrowse: false,
            showRemove: false,
            showUpload:false,
            showUploadedThumbs: false,
            initialPreviewShowDelete: false,
            showPreview: true,
			fileActionSettings: {showDrag: false},
			overwriteInitial: false,
			layoutTemplates: {
				main2: "<div class='input-group {class}'>\
					{browse} \
				</div> \
				{preview}",
			}
		};

		$("#tambahDoc").modal('show');

		$file_id = $('.colDoc [name="col_doc['+$id+'][id]"]');
		if($file_id.length || $vf.attr("data-id")){
            $dat_id = ($file_id.length)?$file_id.val():$vf.attr("data-id");
			$.ajax({
				async: false,
				type: 'POST',
				dataType: "JSON",
				data: {id:$dat_id},
				url: '<?=base_url("land/file_list")?>',
				success: function(rd) {
					console.log(rd);
					file_option["initialPreview"]=rd.initialPreview;
					file_option["initialPreviewConfig"]=rd.initialPreviewConfig;
					file_option["initialPreviewAsData"]=true;
				}
			});
		}

		$('[name="x_file"]').fileinput("destroy").off().fileinput(file_option);
	});
</script>