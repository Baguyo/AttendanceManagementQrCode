

$(document).ready(function () {

    Webcam.set({
    width: 350,
    height: 200,
    image_format: 'jpeg',
    jpeg_quality: 90
});
    

    $("#take_photo_btn").click(function(e){

        $("webcam-container").prepend("<div id='webcam' class='d-none  w-100'></div>")

        Webcam.attach('#webcam');
        $("#webcam").removeClass("d-none");
        $("#webcam").addClass("d-block");


        $("#take_photo_btn").removeClass("d-block");
        $("#take_photo_btn").addClass("d-none");
        
        $("#snap_btn").removeClass("d-none");
        $("#snap_btn").addClass("d-block");
    })


    $("#snap_btn").click(function(e){
        Webcam.snap(function(data_uri){
            // alert(data_uri);
            // $(".webcam-container").prepend(`<img src='${picture}'>`)

            //SET IMAGE PREVIEW AND REMOVE VIDEO
            $(".webcam-container").prepend("<img src='' alt='' id='img_capture' class='img-responsive'>");
            
            $("#img_capture")[0].src = data_uri;
            $("#webcam").removeClass("d-block");
            $("#webcam").addClass("d-none");
            $("#snap_btn").removeClass("d-block");
            $("#snap_btn").addClass("d-none");

            //ENABLED RETAKE PHOTO
            $("#retake_photo_btn").removeClass("d-none");
            $("#retake_photo_btn").addClass("d-block");
        })
    })

    $("#retake_photo_btn").click(function(e){
        $("#img_capture").remove();
        $("#webcam").removeClass("d-none");
        $("#webcam").addClass("d-block");

        $("#snap_btn").removeClass("d-none");
        $("#snap_btn").addClass("d-block");

        $("#retake_photo_btn").removeClass("d-block");
        $("#retake_photo_btn").addClass("d-none");
        // $("#retake_photo_btn").removeClass("d-block");
        // $("#retake_photo_btn").addClass("d-none");

        // $("#take_photo_btn").removeClass("d-none")
        // $("#take_photo_btn").addClass("d-block")
    })


    // // $("#submit_data").click(function(e){
    // //     e.preventDefault();

    //     var base64image = $("#img_capture")[0].src;

    //     Webcam.upload( base64image, function(code, text) {
    //     $("#user_photo").val(base64image);
    //     //console.log(text);
    //     });
    // // })

    $("#time_in_form").submit(function (e) { 
        e.preventDefault();
        
        var username = $("input[name='username']").val();
        var password = $("input[name='password']").val();

        if($("#image_capture").length == 0){
            $("#photo_error_message").html("Take photo required")
        }
    

        // alert(username+password);
        
        $.ajax({
            type: "POST",
            url: "upload.php",
            data: {"username": username, "password": password},
            success: function (response) {
                    if(response == "found"){
                        var base64image = $("#img_capture")[0].src;
                        Webcam.upload( base64image, 'upload.php', function(code, text) {
                            // $("#user_photo").val(base64image);
                            $("#success_modal").modal("show");
                            setInterval(function(){
                                location.reload(true);
                            },4000)
                        });
                        // alert("found");
                    }else{
                        $("#log_error").html("Incorrect username or password");
                    }
                
                        
                
                // else{
                //     alert("good")
                // }
            }
        });

        // if(username.length == " "){
        //     alert("error");
        // }
        // alert(username);
        
        
    });

   
    //CLOSE MODAL AND REFRESH

    

    $(".close").click(function (e) { 
        location.reload(true);
    });

});;
