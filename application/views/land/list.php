<link rel="stylesheet" href="<?=base_url()?>assets/tabulator/dist/css/tabulator_modern.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/tabulator/dist/css/bootstrap/tabulator_bootstrap4.min.css">
<link href="<?=base_url('assets/enlink/css/table.css')?>" rel="stylesheet">
<style>
    .tabulator-col .tabulator-col-content {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .tabulator-col.tabulator-col-group .tabulator-col-content {
        height: unset;
    }
</style>
<div class="page-header">
    <h2 class="header-title">LIST DATA LAND</h2>
    <div class="header-sub-title">
        <nav class="breadcrumb breadcrumb-dash">
            <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>HOME</a>
            <a class="breadcrumb-item" href="#">LAND</a>
            <span class="breadcrumb-item active">LIST</span>
        </nav>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="dt-buttons btn-group mt-1 mb-3">
            <?=anchor(site_url('land/create'),'<span>NEW</span>','class="btn btn-primary buttons-new buttons-html5"')?>
            <a href="<?=base_url("land/export")?>" class="btn btn-success buttons-excel buttons-html5" tabindex="0" aria-controls="mytable" type="button"><span>Excel</span></a>
        </div>
        <table class="table table-bordered table-striped" id="mytable"></table>
    </div>
</div>

<script type="text/javascript" src="https://oss.sheetjs.com/sheetjs/xlsx.full.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/tabulator/dist/js/tabulator.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.5/jspdf.plugin.autotable.js"></script>

<script type="text/javascript">
    function findChildren(row, action) {
        if (action == "expand"){
            row.treeExpand();
        }else{
            row.treeCollapse()};
        var childRows = row.getTreeChildren();

        if (childRows.length > 0){
            childRows.forEach(function(child){
                if (child.getTreeChildren().length > 0){
                    findChildren(child, action)
                }
            })
        }
    }

    function traverseRows(tbl, action) {
        var tblRows = tbl.getRows();
        tblRows.forEach(function(row){
            if (row.getTreeChildren().length > 0){
                findChildren(row, action)
            }
        });
    }

    var t = new Tabulator("#mytable", {
            paginationSize:10,
            pagination:"remote",
            ajaxURL:"land/json",
            ajaxFiltering:true,
            ajaxConfig:"POST",
            layout:"fitColumns",
            responsiveLayout:"collapse",
            placeholder: "No data!",
            ajaxSorting:true,
            dataTreeCollapseElement:'<i class="anticon anticon-caret-down mr-1"></i>',
            dataTreeExpandElement:'<i class="anticon anticon-caret-right mr-1"></i>',
            //autoColumns:true,
            dataTree:true,
            /*dataTreeRowExpanded:function(row, level){
                $.ajax({
                    async: false,
                    type: 'POST',
                    dataType: "JSON",
                    data: {
                        id:row.getData().location_id,
                        target:row.getData().location_target
                    },
                    url: '<?=base_url("land/get_data_tree")?>',
                    success: function(raw_data) {
                        row._row.data._children=[];
                        $.each(raw_data, function(i,v){
                            row.addTreeChild(v);
                        });
                    }
                });
            },*/
            downloadConfig:{
                columnHeaders:true, //do not include column headers in downloaded table
                columnGroups:true, //do not include column groups in column headers for downloaded table
                rowGroups:true, //do not include row groups in downloaded table
                columnCalcs:true, //do not include column calcs in downloaded table
                dataTree:true, //do not include data tree in downloaded table
            },
            ajaxResponse:function(url, params, response){
                if(response.last_page == 1){
                    $(".tabulator-footer").hide();
                }else{
                    $(".tabulator-footer").show();
                }
                return response;
            },
            renderComplete:function(){
                
            },
            columns: [
                {
                    "title":"Location",
                    "field":"location",
                    "headerSort":false,
                },
                {
                    "title":"Code",
                    "field":"land_documents_code",
                    "headerSort":false,
                },
                {
                    title:"Land Type",
                    columns:[
                        {"title":"Physic", "field":"land_physics_name", "headerSort":false, "hozAlign":"center"},
                        {"title":"Project", "field":"land_project_type_name", "headerSort":false, "hozAlign":"center"},
                    ],
                },
                {
                    "title":"Surface Area",
                    columns:[
                        {"title":"Documents", "field":"surface_area_by_doc", "headerSort":false, "hozAlign":"center"},
                        {"title":"Remeasurement", "field":"surface_area_by_remeas", "headerSort":false, "hozAlign":"center"},
                        {"title":"GPS", "field":"surface_area_by_geo", "headerSort":false, "hozAlign":"center"},
                    ],
                },
                {
                    "title":"Action",
                    "field":"action",
                    "formatter":"html",
                    "headerSort":false,
                    "align":"center",
                    "cssClass":"lestAction",
                    "width":200,
                    "hozAlign":"center",
                    "download":false
                }
            ]
        });
        
        $(".buttons-excel").click(function(){
            traverseRows(t, "expand");
            t.download("xlsx", "data.xlsx", {sheetName:"MyData"});
            traverseRows(t, "collapse");
        });
        $(".buttons-pdf").click(function(){
            traverseRows(t, "expand");
            t.download("pdf", "data.pdf", {orientation:"portrait"});
            traverseRows(t, "collapse");
        });
</script>