<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo TB ?>css/jquery.dataTables.min.css">
</head>
<body>
	<h1>Subscriber management</h1>
<?php echo $this->table->generate(); ?>
</div>
<script type="text/javascript" language="javascript" src="<?php echo TB ?>js/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var oTable = $('#big_table').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url(); ?>index.php/subscriber/datatable',
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 20,
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
                //oTable.fnAdjustColumnSizing();
            },
            'fnServerData': function (sSource, aoData, fnCallback) {
                $.ajax
                ({
                    'dataType': 'json',
                    'type': 'POST',
                    'url': sSource,
                    'data': aoData,
                    'success': fnCallback
                });
            }
        });
    });
</script>
</body>
</html>
