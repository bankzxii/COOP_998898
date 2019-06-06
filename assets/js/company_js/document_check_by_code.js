jQuery( ".document_check_btn" ).click(function() {
    var student_id = jQuery(this).data('studentid');
    jQuery("#document_check_table tbody").empty();

    jQuery.getJSON( SITE_URL+"/Company/Coop_Submitted_Form_Search/get_by_student/"+student_id, function( result ) {
        var items = [];
        jQuery.each( result.data, function( key, val ) {
            if(val.file != '') {
                $('#document_check_table tbody').append(
                    '<tr>'+
                    '<th >'+val.document_code+'</td>'+
                    '<td>'+val.file+'</td>'+         
                    '</tr>');
            } else {
                $('#document_check_table tbody').append(
                    '<tr>'+
                    '<td>'+val.document_code+'</td>'+
                    '<td> - </td>'+         
                    '</tr>');
            }
            
        });
    });

    $("#document_check_student").modal()


});
