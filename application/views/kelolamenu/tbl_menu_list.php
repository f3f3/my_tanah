<link href="<?=base_url('assets/enlink/vendors/datatables/css/dataTables.bootstrap4.min.css')?>" rel="stylesheet">
<link href="<?=base_url('assets/enlink/vendors/datatables/css/buttons.bootstrap4.min.css')?>" rel="stylesheet">
<link href="<?=base_url('assets/enlink/vendors/datatables/responsive.bootstrap4.min.css')?>" rel="stylesheet">
<link href="<?=base_url('assets/enlink/css/table.css')?>" rel="stylesheet">
<div class="page-header">
    <h2 class="header-title">SETTING TAMPILAN MENU</h2>
    <div class="header-sub-title">
        <nav class="breadcrumb breadcrumb-dash">
            <a href="#" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>HOME</a>
            <a class="breadcrumb-item" href="#">PENGATURAN</a>
            <span class="breadcrumb-item active">SETTING TAMPILAN MENU</span>
        </nav>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h4>Data Table</h4>
        <div class="m-t-25"><table id="mytable" class="table"></table></div>
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
<script type="text/javascript">
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
            buttons: [{
                text: 'NEW',
                className: 'buttons-new buttons-html5',
                action: function ( e, dt, node, config ) {
                    alert( 'Button activated' );
                }
            }, 'copy', 'excel', 'pdf', 'print'],
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
            ajax: {"url": "kelolamenu/json", "type": "POST"},
            columns: [
                {
                    "title": "No",
                    "data": "id_menu",
                    "orderable": false
                },{
                    "title": "Nama",
                    "data": "title"
                },{
                    "title": "URL",
                    "data": "url"
                },{
                    "title": "Icon",
                    "data": "icon"
                },{
                    "title": "Main Menu",
                    "data": "is_main_menu"
                },{
                    "title": "Aktif",
                    "data": "is_aktif"
                },
                {
                    "title": "Action",
                    "data" : "action",
                    "orderable": false,
                    "className" : "text-center"
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
    });
</script>