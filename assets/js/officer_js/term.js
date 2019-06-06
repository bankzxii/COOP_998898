function changeTermAjax()
{
    var term_id = jQuery('#term_option').find(":selected").val()

    changeTerm(term_id)
}

$('#term_option_menu').change(function() {
    changeTerm(jQuery(this).val())
})

function changeTerm(term_id)
{
    var data = { term_id: term_id }
    jQuery.post(SITE_URL+"/Officer/Change_term/ajax_change/", data, function(response) {
        // Do something with the request
        $("#selectTermBox").modal('hide')
        //alert
        swal({
            title: "เปลี่ยนปีการศึกษาเรียบร้อย!",
            text: "",
            icon: "success",
          })
          .then((xxx) => {
            window.location.reload();
          });

    }, 'json');
}
