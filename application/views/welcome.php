<link rel="stylesheet" href="<?= base_url() ?>assets/jvectormap/jquery-jvectormap-2.0.5.css">
<style>
    .ul_min {
        margin: 3px 0 0 0;
        padding-inline-start: 20px;
    }

    .ul_min_2 {
        margin: 3px 0 0 0;
        padding-inline-start: 20px;
    }

    .ul_min_3 {
        margin: 3px 0 0 0;
        padding-inline-start: 20px;
    }

    .jvectormap-tip {
        padding: 5px;
        z-index: 1000;
        font-size: 1rem;
    }

    .jvectormap-tip>b {
        display: block;
        text-align: center;
    }

    .vube .info-box-content span {
        font-size: 2.8rem;
        font-family: monospace;
        text-align: center;
    }

    .node_tree,
    .node_tree ul {
        margin: 0;
        padding: 0;
        list-style: none
    }

    .node_tree ul {
        margin-left: 1em;
        position: relative
    }

    .node_tree ul ul {
        margin-left: .5em
    }

    .node_tree ul:before {
        content: "";
        display: block;
        width: 0;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        border-left: 1px solid
    }

    .node_tree li {
        margin: 0;
        padding: 0 1em;
        line-height: 2em;
        color: #369;
        font-weight: 700;
        position: relative
    }

    .node_tree ul li:before {
        content: "";
        display: block;
        width: 10px;
        height: 0;
        border-top: 1px solid;
        margin-top: -1px;
        position: absolute;
        top: 1em;
        left: 0
    }

    .node_tree ul li:last-child:before {
        background: #fff;
        height: auto;
        top: 1em;
        bottom: 0
    }

    .indicator {
        margin-right: 5px;
    }

    .node_tree li a {
        text-decoration: none;
        color: #369;
    }

    .node_tree li a,
    .node_tree li span {
        text-decoration: none;
        color: #fff;
        border: 2px solid #000;
        border-radius: 0 10px 0 10px;
        padding: 1px 10px;
        background: #96921c;
    }
    .node_tree li a+span,
    .node_tree li span+span,
    .node_tree li span:last-child {
        margin-left: 1px;
        border-radius: 10px 0 10px;
        background: #ab4d16;
    }
    .node_tree li a+span sup,
    .node_tree li span+span sup {
        display: unset !important;
    }
    .node_tree li.nam span {
        border-radius: 10px 0 0 10px;
        padding: 1px 10px;
        background: #3c8dbc;
    }
    .node_tree li.nam span:last-child {
        margin-left: -1px;
        border-radius: 0 10px 10px 0;
        background: #419643;
    }

    .node_tree li button,
    .node_tree li button:active,
    .node_tree li button:focus {
        text-decoration: none;
        color: #369;
        border: none;
        background: transparent;
        margin: 0px 0px 0px 0px;
        padding: 0px 0px 0px 0px;
        outline: 0;
    }
    #tree_land h1{
        color: #333333;
        font-size: 18px;
        fill: #333333;
    }
    .map {
		position: absolute;
		top: 0;
		bottom: 0;
		right: 0;
		left: 0;
		height: 500px;
	}
</style>

<div class="row">
    <div class="col-md-12 col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Land Inventory Report</h5>
                    <div class="dropdown dropdown-animated scale-left">
                        <a class="text-gray font-size-18" href="javascript:void(0);" data-toggle="dropdown">
                            <i class="anticon anticon-ellipsis"></i>
                        </a>
                        <div class="dropdown-menu">
                            <button class="dropdown-item" type="button">
                                <i class="anticon anticon-printer"></i>
                                <span class="m-l-10">Print</span>
                            </button>
                            <button class="dropdown-item" type="button">
                                <i class="anticon anticon-download"></i>
                                <span class="m-l-10">Download</span>
                            </button>
                            <button class="dropdown-item" type="button">
                                <i class="anticon anticon-file-excel"></i>
                                <span class="m-l-10">Export</span>
                            </button>
                            <button class="dropdown-item" type="button">
                                <i class="anticon anticon-reload"></i>
                                <span class="m-l-10">Refresh</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="m-t-50" style="height: 330px">
                    <div id="world-map-markers" style="height: 100%" class="map mt-5"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="m-b-0">List Area Pembebasan Tanah</h5>
                <div class="m-v-60 text-center" style="display: inline">
                    <div id="container" style="height: 388px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-4">
        <div class="card" style="height: calc(100% - 20px);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="m-b-0">List Area Pembebasan Tanah</h5>
                </div>
                <div class="m-t-30">
                    <div id="tree_land"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="m-b-0">Latest Upload</h5>
                    <div>
                        <a href="javascript:void(0);" class="btn btn-sm btn-default">View All</a>
                    </div>
                </div>
                <div class="m-t-30">
                    <div class="overflow-y-auto scrollable relative" style="height: 437px">
                        <ul class="timeline p-t-10 p-l-10">
                            <li class="timeline-item">
                                <div class="timeline-item-head">
                                    <div class="avatar avatar-text avatar-sm bg-primary">
                                        <span>V</span>
                                    </div>                                                                
                                </div>
                                <div class="timeline-item-content">
                                    <div class="m-l-10">
                                        <h5 class="m-b-5">Virgil Gonzales</h5>
                                        <p class="m-b-0">
                                            <span class="font-weight-semibold">Complete task </span> 
                                            <span class="m-l-5"> Prototype Design</span>
                                        </p>
                                        <span class="text-muted font-size-13">
                                            <i class="anticon anticon-clock-circle"></i>
                                            <span class="m-l-5">10:44 PM</span>
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-item-head">
                                    <div class="avatar avatar-text avatar-sm bg-success">
                                        <span>L</span>
                                    </div>                                                                
                                </div>
                                <div class="timeline-item-content">
                                    <div class="m-l-10">
                                        <h5 class="m-b-5">Lilian Stone</h5>
                                        <p class="m-b-0">
                                            <span class="font-weight-semibold">Attached file </span> 
                                            <span class="m-l-5"> Mockup Zip</span>
                                        </p>
                                        <span class="text-muted font-size-13">
                                            <i class="anticon anticon-clock-circle"></i>
                                            <span class="m-l-5">8:34 PM</span>
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-item-head">
                                    <div class="avatar avatar-text avatar-sm bg-warning">
                                        <span>E</span>
                                    </div>                                                                
                                </div>
                                <div class="timeline-item-content">
                                    <div class="m-l-10">
                                        <h5 class="m-b-5">Erin Gonzales</h5>
                                        <p class="m-b-0">
                                            <span class="font-weight-semibold">Commented  </span> 
                                            <span class="m-l-5"> 'This is not our work!'</span>
                                        </p>
                                        <span class="text-muted font-size-13">
                                            <i class="anticon anticon-clock-circle"></i>
                                            <span class="m-l-5">8:34 PM</span>
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-item-head">
                                    <div class="avatar avatar-text avatar-sm bg-primary">
                                        <span>R</span>
                                    </div>                                                                
                                </div>
                                <div class="timeline-item-content">
                                    <div class="m-l-10">
                                        <h5 class="m-b-5">Riley Newman</h5>
                                        <p class="m-b-0">
                                            <span class="font-weight-semibold">Commented  </span> 
                                            <span class="m-l-5"> 'Hi, please done this before tommorow'</span>
                                        </p>
                                        <span class="text-muted font-size-13">
                                            <i class="anticon anticon-clock-circle"></i>
                                            <span class="m-l-5">8:34 PM</span>
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-item-head">
                                    <div class="avatar avatar-text avatar-sm bg-danger">
                                        <span>P</span>
                                    </div>                                                                
                                </div>
                                <div class="timeline-item-content">
                                    <div class="m-l-10">
                                        <h5 class="m-b-5">Pamela Wanda</h5>
                                        <p class="m-b-0">
                                            <span class="font-weight-semibold">Removed  </span> 
                                            <span class="m-l-5"> a file</span>
                                        </p>
                                        <span class="text-muted font-size-13">
                                            <i class="anticon anticon-clock-circle"></i>
                                            <span class="m-l-5">8:34 PM</span>
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-item-head">
                                    <div class="avatar avatar-text avatar-sm bg-secondary">
                                        <span>M</span>
                                    </div>                                                                
                                </div>
                                <div class="timeline-item-content">
                                    <div class="m-l-10">
                                        <h5 class="m-b-5">Marshall Nichols</h5>
                                        <p class="m-b-0">
                                            <span class="font-weight-semibold">Create   </span> 
                                            <span class="m-l-5"> this project</span>
                                        </p>
                                        <span class="text-muted font-size-13">
                                            <i class="anticon anticon-clock-circle"></i>
                                            <span class="m-l-5">5:21 PM</span>
                                        </span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="m-b-0">Task</h5>
                    <div>
                        <a href="javascript:void(0);" class="btn btn-sm btn-default">View All</a>
                    </div>
                </div>
            </div>
            <div class="m-t-10">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-today">Today</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-week">Week</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-month">Month</a>
                    </li>
                </ul>
                <div class="tab-content m-t-15">
                    <div class="tab-pane card-body fade show active" id="tab-today">
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-today-1" type="checkbox">
                                    <label for="task-today-1" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Define users and workflow</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">A cheeseburger is more than sandwich</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-today-2" type="checkbox" checked="">
                                    <label for="task-today-2" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Schedule jobs</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">I'm gonna build me an airport</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-today-3" type="checkbox" checked="">
                                    <label for="task-today-3" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Extend the data model</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">Let us wax poetic about cheeseburger</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-today-4" type="checkbox">
                                    <label for="task-today-4" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Change interface</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">Efficiently unleash cross-media information</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-today-5" type="checkbox">
                                    <label for="task-today-5" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Create databases</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">Here's the story of a man named Brady</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane card-body fade" id="tab-week">
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-week-1" type="checkbox">
                                    <label for="task-week-1" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Verify connectivity</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">Bugger bag egg's old boy willy jolly</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-week-2" type="checkbox">
                                    <label for="task-week-2" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Order console machines</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">Value proposition alpha crowdsource</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-week-3" type="checkbox" checked="">
                                    <label for="task-week-3" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Customize Template</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">Do you see any Teletubbies in here</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-week-4" type="checkbox" checked="">
                                    <label for="task-week-4" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Batch schedule</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">Trillion a very small stage in a vast</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-week-5" type="checkbox" checked="">
                                    <label for="task-week-5" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Prepare implementation</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">Drop in axle roll-in rail slide</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane card-body fade" id="tab-month">
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-month-1" type="checkbox">
                                    <label for="task-month-1" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Create user groups</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">Nipperkin run a rig ballast chase</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-month-2" type="checkbox" checked="">
                                    <label for="task-month-2" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Design Wireframe</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">Value proposition alpha crowdsource</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-month-3" type="checkbox">
                                    <label for="task-month-3" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Customize Template</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">I'll be sure to note that</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-month-4" type="checkbox">
                                    <label for="task-month-4" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Management meeting</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">Hand-crafted exclusive finest</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-15">
                            <div class="d-flex align-items-center">
                                <div class="checkbox">
                                    <input id="task-month-5" type="checkbox" checked="">
                                    <label for="task-month-5" class="d-flex align-items-center">
                                        <span class="inline-block m-l-10">
                                            <span class="text-dark font-weight-semi-bold font-size-16">Extend data model</span>
                                            <span class="m-b-0 text-muted font-size-13 d-block">European minnow priapumfish mosshead</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>/assets/jvectormap/jquery-jvectormap-2.0.5.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/jqvmap/maps/jquery.vmap.indonesia.js"></script>
<script src="<?= base_url() ?>assets/highcharts/_highcharts.js"></script>
<script src="<?= base_url() ?>assets/highcharts/sunburst.js"></script>
<script src="<?= base_url() ?>assets/highcharts/export-data.js"></script>
<script src="<?= base_url() ?>assets/highcharts/accessibility.js"></script>
<script>
    $.fn.extend({
        treed: function(o) {

            var openedClass = 'glyphicon-minus-sign';
            var closedClass = 'glyphicon-plus-sign';

            if (typeof o != 'undefined') {
                if (typeof o.openedClass != 'undefined') {
                    openedClass = o.openedClass;
                }
                if (typeof o.closedClass != 'undefined') {
                    closedClass = o.closedClass;
                }
            };

            var tree = $(this);
            tree.addClass("node_tree");
            tree.find('li').has("ul").each(function() {
                var branch = $(this);
                branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
                branch.addClass('branch');
                branch.on('click', function(e) {
                    if (this == e.target) {
                        var icon = $(this).children('i:first');
                        icon.toggleClass(openedClass + " " + closedClass);
                        $(this).children().children().toggle();
                    }
                })
                branch.children().children().toggle();
            });
            tree.find('.branch .indicator').each(function() {
                $(this).on('click', function() {
                    $(this).closest('li').click();
                });
            });
            tree.find('.branch>a').each(function() {
                $(this).on('click', function(e) {
                    $(this).closest('li').click();
                    e.preventDefault();
                });
            });
            tree.find('.branch>button').each(function() {
                $(this).on('click', function(e) {
                    $(this).closest('li').click();
                    e.preventDefault();
                });
            });
        }
    });

    format_number = (number) => {
        return new Intl.NumberFormat('ID-JK').format(number);
    }

    $.getJSON("<?= base_url("dashboard/json_wall") ?>", (data) => {
        arrays = {
            path01:"Aceh", path02:"Sumatera Utara", path03:"Sumatera Barat", path04:"Riau", path05:"Jambi", 
            path06:"Sumatera Selatan", path07:"Bengkulu", path08:"Lampung", path09:"Kep. Bangka Belitung",
            path10:"Kep. Riau", path11:"DKI Jakarta", path12:"Jawa Barat", path13:"Jawa Tengah",
            path16:"Yogyakarta", path15:"Jawa Timur", path14:"Banten", path17:"Bali", path18:"Nusa Tenggara Barat",
            path19:"Nusa Tenggara Timur", path20:"Kalimantan Barat", path21:"Kalimantan Tengah", path22:"Kalimantan Selatan",
            path23:"Kalimantan Timur", path24:"Kalimantan Utara", path25:"Sulawesi Utara", path26:"Sulawesi Tengah",
            path27:"Sulawesi Selatan", path28:"Sulawesi Tenggara", path29:"Gorontalo", path30:"Sulawesi Barat", path31:"Maluku",
            path32:"Maluku Utara", path33:"Papua", path34:"Papua Barat"
        };
        
        xpend_b = ""; xpend_b_ac = 0;
        $.each(data.child, (i,v)=>{
            if(!Array.isArray(v)){
                xpend_c = ""; xpend_c_ac = 0;
                $.each(v, (u, y) => {
                    xpend_d = ""; xpend_d_ac = 0;
                    $.each(y, (a, b) => {
                        xpend_e = ""; xpend_e_ac = 0;
                        $.each(b, (c, d) => {
                            xpend_e_ac += parseInt(d);
                            xpend_e += '<li class="nam"><span>' + c + '</span>';
                            xpend_e += '<span>' + format_number(d) + 'M<sup>2</sup></span></li>';
                        });
                        xpend_d_ac += xpend_e_ac;
                        xpend_d += '<li class="nim"><a href="#">' + a + "</a>";
                        xpend_d += '<span>' + format_number(xpend_e_ac) + 'M<sup>2</sup></span><ul>';
                        xpend_d += xpend_e;
                        xpend_d += "</ul></li>";
                    });
                    xpend_c_ac += xpend_d_ac;
                    xpend_c += '<li class="num"><a href="#">' + u + "</a>";
                    xpend_c += '<span>' + format_number(xpend_d_ac) + 'M<sup>2</sup></span><ul>';
                    xpend_c += xpend_d;
                    xpend_c += "</ul></li>";
                });
                xpend_b_ac += xpend_c_ac;
                xpend_b += '<li class="nom"><a href="#">' + arrays[i] +'</a>';
                xpend_b += '<span>' + format_number(xpend_c_ac) + 'M<sup>2</sup></span><ul>';
                xpend_b += xpend_c;
                xpend_b += "</ul></li>";
            }
        });
        xpend = '<ul id="tree1"><li><a href="#">Global</a>';
        xpend += '<span>' + format_number(xpend_b_ac) + 'M<sup>2</sup></span><ul>';
        xpend += xpend_b;
        xpend += "</ul></li></ul>";

        $("#tree_land").append(xpend);
        $('#tree1').treed();

        _globalValue = 0;
        $.each(data.value, (a, b) => {
            _globalValue += b;
        });
        $("#Global").html(format_number(_globalValue) + "M<sup>2</sup>");

        $('#world-map-markers').vectorMap({
            map: 'indonesia_id',
            normalizeFunction: 'polynomial',
            hoverColor: '#c9dfaf',
            enableZoom: false,
            zoomButtons: false,
            backgroundColor: 'transparent',
            regionStyle: {
                initial: {
                    'fill': 'rgba(210, 214, 222, 1)',
                    'fill-opacity': 1,
                    'stroke': 'none',
                    'stroke-width': 0,
                    'stroke-opacity': 1
                },
                selected: {
                    fill: 'yellow'
                },
                selectedHover: {}
            },
            markerStyle: {
                initial: {
                    fill: '#00a65a',
                    stroke: '#111'
                }
            },
            series: {
                regions: [{
                    scale: ['#DEEBF7', '#08519C'],
                    attribute: 'fill',
                    values: data.value,
                    min: jvm.min(data.value),
                    max: jvm.max(data.value),
                    legend: {
                        vertical: true
                    },
                }]
            },
            onRegionClick: function(element, code, region) {
                var message = 'You clicked "' +
                    region +
                    '" which has the code: ' +
                    code.toUpperCase();

                alert(message);
            },
            onRegionTipShow: function(event, label, index) {
                area_name = label.html();
                append = "";

                if (data.child[index].length != 0) {
                    append += "<ul class='ul_min'>";
                    $.each(data.child[index], (i, v) => {
                        append += '<li><b>' + i +'</b></li>';
                        append += "<ul class='ul_min_2'>";
                        $.each(v, (a, b) => {
                            append += '<li><b>' + a +'</b></li>';
                            append += "<ul class='ul_min_3'>";
                            $.each(b, (c, d) => {
                                append += '<li><b>' + c + ': ' + format_number(d) + 'M<sup>2</sup></b></li>';
                            });
                            append += "</ul>";
                        });
                        append += "</ul>";
                    });
                    append += "</ul>";
                }

                label.html(
                    '<b>' + area_name + '</b>' + append
                );
            },
        });

        Highcharts.setOptions({ lang: { decimalPoint: ',', thousandsSep: '.' } });
        Highcharts.getOptions().colors.splice(0, 0, 'transparent');
        Highcharts.chart('container', {
            chart: {
                //height: '90%',
                //height: 200,
            },
            title: {
                text: undefined
            },
            series: [{
                type: "sunburst",
                data: data.sunburst,
                allowDrillToNode: true,
                cursor: 'pointer',
                dataLabels: {
                    format: '{point.name} : {point.value}',
                    filter: {
                        property: 'innerArcLength',
                        operator: '>',
                        value: 16
                    },
                    rotationMode: 'circular'
                },
                levels: [{
                    level: 1,
                    levelIsConstant: false,
                    dataLabels: {
                        filter: {
                            property: 'outerArcLength',
                            operator: '>',
                            value: 64
                        }
                    }
                }, {
                    level: 2,
                    colorByPoint: true
                },
                {
                    level: 3,
                    colorVariation: {
                        key: 'brightness',
                        to: -0.5
                    }
                }, {
                    level: 4,
                    colorVariation: {
                        key: 'brightness',
                        to: 0.5
                    }
                }]

            }],
            tooltip: {
                headerFormat: "",
                padding: 2,
				useHTML: true,
                pointFormat: 'Luas Pembebasan Tanah di <b>{point.name}</b> adalah <b>{point.value}M<sup>2</sup></b>'
            }
        });
    });
</script>