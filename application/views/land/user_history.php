<link rel="stylesheet" href="<?=base_url()?>assets/tabulator/dist/css/bootstrap/tabulator_bootstrap4.min.css">
<link href="<?=base_url('assets/enlink/css/table.css')?>" rel="stylesheet">
<style>
    .tabulator-col:last-child .tabulator-col-content {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .fs-14 {
        font-size: 14px;
    }
</style>

<div class="page-header">
    <h2 class="header-title">USER HISTORY</h2>
    <div class="header-sub-title">
        <nav class="breadcrumb breadcrumb-dash">
            <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>HOME</a>
            <a class="breadcrumb-item" href="#">HISTORY</a>
            <span class="breadcrumb-item active">USER HISTORY</span>
        </nav>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="dt-buttons btn-group mt-1 mb-3">
            <button class="btn btn-success buttons-excel buttons-html5" tabindex="0" aria-controls="mytable" type="button"><span>Excel</span></button>
            <button class="btn btn-danger buttons-pdf buttons-html5" tabindex="0" aria-controls="mytable" type="button"><span>PDF</span></button>
            <button class="btn btn-warning buttons-print" tabindex="0" aria-controls="mytable" type="button"><span>Print</span></button>
        </div>
        <table class="table" id="mytable"></table>
    </div>
</div>

<script type="text/javascript" src="https://oss.sheetjs.com/sheetjs/xlsx.full.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/tabulator/dist/js/tabulator.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.5/jspdf.plugin.autotable.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var t = new Tabulator("#mytable", {
            paginationSize:10,
            pagination:"remote",
            ajaxURL:"user_history/json",
            ajaxFiltering:true,
            ajaxConfig:"POST",
            layout:"fitColumns",
            responsiveLayout:"collapse",
            placeholder: "No data!",
            ajaxSorting:true,
            //autoColumns:true,
            dataTree:false,
            columns: [
                {title:"No.", formatter:"rownum", width:75, hozAlign:"center"},
                {
                    "title":"Document Code",
                    "field":"land_documents_code",
                    "width":280
                },
                    {
                    "title":"History Status",
                    "field":"land_user_history_type_name",
                    "width":150
                },
                {
                    "title":"Status",
                    "field":"land_status_type_name",
                    "width":150
                },
                {
                    "formatter":"html",
                    "title":"Approved",
                    "field":"land_status_approved",
                    "hozAlign":"center",
                    "width":120
                },
                {
                    "title":"Approved By",
                    "field":"land_status_approved_user"
                },
                {
                    "title":"Checked By",
                    "field":"land_comments_user"
                },
                {
                    "title":"Date",
                    "field":"land_user_history_date"
                },
                {
                    "title":"Action",
                    "field":"action",
                    "formatter":"html",
                    "headerSort":false,
                    "align":"center",
                    "hozAlign":"center",
                    "cssClass":"lestAction",
                    "width":200
                }
            ],
            ajaxResponse:function(url, params, response){
                if(response.last_page == 1){
                    $(".tabulator-footer").hide();
                }else{
                    $(".tabulator-footer").show();
                }
                return response;
            },
        });

        $(".buttons-excel").click(function(){
            t.download("xlsx", "data.xlsx", {sheetName:"MyData"});
        });
        $(".buttons-pdf").click(function(){
            t.download("pdf", "data.pdf", {orientation:"portrait"});
        });
    });

</script>