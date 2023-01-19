<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA LAND_DOCUMENT_TYPE</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered'>        

	    <tr><td width='200' data_type='varchar'>Land Document Type Name <?php echo form_error('land_document_type_name') ?></td><td><input type="text" class="form-control" name="land_document_type_name" id="land_document_type_name" placeholder="Land Document Type Name" value="<?php echo $land_document_type_name; ?>" /></td></tr>
	    <tr><td width='200' data_type='varchar'>Land Document Type Extra <?php echo form_error('land_document_type_extra') ?></td><td><input type="text" class="form-control" name="land_document_type_extra" id="land_document_type_extra" placeholder="Land Document Type Extra" value="<?php echo $land_document_type_extra; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="land_document_type_id" value="<?php echo $land_document_type_id; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('land_document_type') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>