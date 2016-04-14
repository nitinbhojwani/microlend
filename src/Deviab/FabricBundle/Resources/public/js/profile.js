function getProfile() {
    $.ajax({
        type : "GET",
        url : '/api/v1/lender',
        contentType: "application/json",
        success : function(result){
            var dataset = result;
            console.log(dataset);
            $('#profile-id').val(dataset.lender.id);
            $('#profile-name').val(dataset.lender.fname);
            $('#profile-email').val(dataset.email);
            $('#profile-phone').val(dataset.lender.primary_mobile_number);
            
        },
        error : function(error) {
            console.log("error",error);
        }
    });
}
