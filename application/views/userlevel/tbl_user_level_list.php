<link href="<?=base_url('assets/enlink/vendors/datatables/css/dataTables.bootstrap4.min.css')?>" rel="stylesheet">
<link href="<?=base_url('assets/enlink/vendors/datatables/css/buttons.bootstrap4.min.css')?>" rel="stylesheet">
<link href="<?=base_url('assets/enlink/vendors/datatables/responsive.bootstrap4.min.css')?>" rel="stylesheet">
<link href="<?=base_url('assets/enlink/css/table.css')?>" rel="stylesheet">
<link href="<?=base_url('assets/toastr/css/toastr.min.css')?>" rel="stylesheet"/>
<div class="page-header">
    <h2 class="header-title">KELOLA DATA LEVEL USER</h2>
    <div class="header-sub-title">
        <nav class="breadcrumb breadcrumb-dash">
            <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>HOME</a>
            <a class="breadcrumb-item" href="#">PENGATURAN</a>
            <span class="breadcrumb-item active">KELOLA DATA LEVEL USER</span>
        </nav>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h4>Data Table</h4>
        <div class="m-t-25"><table id="mytable" class="table"></table></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="rubahAkses" tabindex="-1" role="dialog" aria-labelledby="rubahAkses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rubahAksesTitle">Rubah Akses</h5>
            </div>
            <div class="modal-body">
                <table id="tableAkses" class="table"></table>
            </div>
	    </div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewTitle">Add New</h5>
            </div>
            <div class="modal-body">
                <div class="form-group w-100">
                    <div class="input-group" style="flex-flow: nowrap;">
                        <div class="input-affix w-unset f-auto">
                            <input type="text" class="form-control" name="nama_level" id="nama_level" placeholder="Nama Level" />
                        </div>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-success save_new" data-toggle="tooltip"><i class="anticon anticon-save anticon-lg"></i></button>
                        </div>
                    </div>
                </div>
            </div>
	    </div>
	</div>
</div>

<script src="<?=base_url('assets/enlink/vendors/datatables/js/jquery.dataTables.js')?>"></script>
<script src="<?=base_url('assets/enlink/vendors/datatables/js/dataTables.bootstrap4.js')?>"></script>
<script src="<?=base_url('assets/enlink/vendors/datatables/js/dataTables.buttons.min.js')?>"></script>
<script src="<?=base_url('assets/enlink/vendors/datatables/js/buttons.bootstrap4.min.js')?>"></script>
<script src="<?=base_url('assets/enlink/vendors/datatables/js/jszip.min.js')?>"></script>
<script src="<?=base_url('assets/enlink/vendors/datatables/js/pdfmake.min.js')?>"></script>
<script src="<?=base_url('assets/enlink/vendors/datatables/js/vfs_fonts.js')?>"></script>
<script src="<?=base_url('assets/enlink/vendors/datatables/js/buttons.html5.min.js')?>"></script>
<script src="<?=base_url('assets/enlink/vendors/datatables/js/buttons.print.min.js')?>"></script>
<script src="<?=base_url('assets/enlink/vendors/datatables/js/buttons.colVis.min.js')?>"></script>
<script src="<?=base_url('assets/enlink/vendors/datatables/dataTables.responsive.min.js')?>"></script>
<script src="<?=base_url('assets/enlink/vendors/datatables/responsive.bootstrap4.min.js')?>"></script>
<script src="<?=base_url('assets/toastr/js/toastr.min.js')?>"></script>
<script type="text/javascript">
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
    $(document).ready(function() {
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
        {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };
        var initialize = false; var tbl, level;
        var t = $("#mytable").DataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable_filter input')
                        .off('.DT')
                        .on('keyup.DT', function(e) {
                            if (e.keyCode == 13) {
                                api.search(this.value).draw();
                    }
                });
                t.buttons().container().appendTo('#mytable_wrapper .col-md-6:eq(0)');
                $($.fn.dataTable.tables(true)).DataTable().responsive.recalc();
            },
            autoWidth: false,
            buttons: [{
                text: 'NEW',
                className: 'buttons-new buttons-html5',
                action: function ( e, dt, node, config ) {
                    $("#addNew").modal('show');
                }
            }, 'excel', 'pdf', 'print'],
		    responsive: {
                details: false
            },
            Language: {
                sProcessing: "loading...",
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ ',
            },
            processing: true,
            serverSide: true,
            ajax: {"url": "userlevel/json", "type": "POST"},
            columns: [
                {
                    "title": "No",
                    "data": "id_user_level",
                    "orderable": false,
                },{
                    "title": "Level",
                    "data": "nama_level"
                },
                {
                    "title": "Action",
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center",
                }
            ],
            order: [[0, 'desc']],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
        
        $(document).delegate(".save_new", 'click', function(e){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?=base_url("userlevel/save_action")?>",                
                data: "nama_level=" + $('[name="nama_level"]').val(),
                success: function(data) {
                    if(data.status=="success"){
                        toastr.success('New access was added!', 'Succes!');
                        $("#addNew").modal('hide');
                    } else toastr.error('Please check your data!', 'Error!');
                },
                error: function() {              
                    toastr.error('Please check your connection!', 'Error!');
                }
            },"JSON");
        });

        $(document).delegate(".edited", 'click', function(e){
            e.preventDefault();
            level = $(this).attr("data-id");
            if(initialize) tbl.destroy();
            tbl = $("#tableAkses").DataTable({
                initComplete: function() {
                    initialize = true;
                    var api = this.api();
                    $('#tableAkses_filter input')
                            .off('.DT')
                            .on('keyup.DT', function(e) {
                                if (e.keyCode == 13) {
                                    api.search(this.value).draw();
                        }
                    });
                    $($.fn.dataTable.tables(true)).DataTable().responsive.recalc();
                },
                searching: false,
                autoWidth: false,
                responsive: {
                    details: false
                },
                Language: {
                    sProcessing: "loading...",
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ ',
                },
                processing: true,
                serverSide: true,
                ajax: {"url": "userlevel/akses_json/"+level, "type": "POST"},
                lengthMenu: [[5, 10, 50, -1], [5, 10, 50, "All"]],
                columns: [
                    {
                        "title": "No",
                        "data": "id_menu",
                        "orderable": false,
                    },{
                        "title": "Modul",
                        "data": "title"
                    },
                    {
                        "title": "Action",
                        "data" : "action",
                        "orderable": false,
                        "className" : "text-center",
                    }
                ],
                order: [[0, 'desc']],
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    var index = page * length + (iDisplayIndex + 1);
                    $('td:eq(0)', row).html(index);
                }
            });
            $("#rubahAkses").modal('show');
        });

        $(document).delegate(".checkz", 'change', function(){
            var id_menu = $(this).attr("data-id");
            $.ajax({
                url:"<?=base_url("userlevel/kasi_akses_ajax")?>",
                data:"id_menu=" + id_menu + "&level="+ level ,
                success: function(html) {
                    toastr.success('user access menu was changed!', 'Access Changed');
                },
                error: function() {              
                    toastr.error('Please check your connection', 'Error!');
                }
            });
        });
    });
</script>