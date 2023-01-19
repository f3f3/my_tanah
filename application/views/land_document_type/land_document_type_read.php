<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Land_document_type Read</h2>
        <table class="table">
	    <tr><td>Land Document Type Name</td><td><?php echo $land_document_type_name; ?></td></tr>
	    <tr><td>Land Document Type Extra</td><td><?php echo $land_document_type_extra; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('land_document_type') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>