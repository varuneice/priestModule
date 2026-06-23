(function ($) {
    $(function () {
        debugger;
        var url = $("#container-abc-url-id").text();
        
        // $('#tab-1-table-id').dataTable({
        //     "aoColumnDefs": [
        //         {'bSortable': false, 'aTargets': [5, 6]}
        //     ]
        // });
     
         //eventdelete code
          $("#tab-1-table-id").delegate('a.icon-delete', 'click', function(e) {
          debugger;
          e.preventDefault();
          $('#record_id').text($(this).attr('rev'));
         $('#dialogDelete').dialog('open');
        });
         if ($("#dialogDelete").length > 0) {
         debugger;
         $("#dialogDelete").dialog({
          autoOpen: false,
          resizable: false,
          draggable: false,
          height: 220,
          modal: true,
          close: function() {
            $('#record_id').text('');
        },
        buttons: [{
                html: "<i class='fa fa-trash-o'></i>&nbsp; Delete item",
                "class": "btn btn-danger",
                click: function() {
                    $.ajax({
                        type: "POST",
                        data: {
                            id: $('#record_id').text(),
                            controller: 'Category',
                            action: 'delete'
                        },
                        url: url + "index.php?controller=Category&action=delete",
                        beforeSend: function() {
                            $(".overlay").css('display', 'block');
                            $(".loading-img").css('display', 'block');
                        },
                        success: function(res) {
                            $("#tab-1-table-id").html(res);
                            $(".overlay").css('display', 'none');
                            $(".loading-img").css('display', 'none');

                            $('#tab-1-table-id').dataTable({
                                "aoColumnDefs": [
                                    {'bSortable': false, 'aTargets': [1, 2]}
                                ]
                            });
                        }
                    });
                    $(this).dialog('close');

                }}, {
                html: "<i class='fa fa-times'></i>&nbsp; Cancel",
                "class": "btn btn-default",
                click: function() {
                    $(this).dialog('close');
                }}]
            });
         }
        
        if ($("a.gallery-delete").length > 0) {
            $("#table-frm-id").delegate("a.gallery-delete", 'click', function(e) {
                e.preventDefault();
                $('#record_id').text($(this).attr('rev'));
                $('#dialogDeleteGallery').dialog('open');
            });
        }
        
        
    });
 }(jQuery));