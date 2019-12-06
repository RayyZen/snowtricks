$(document).ready(function() {

	setInterval(function(){
		$(".arrow").effect("bounce", { direction:"down", times:2 }, 1000);
	}, 4000);
	$(".arrow").click(function() {
        $([document.documentElement, document.body]).animate({
	        scrollTop: $(".tricks").offset().top - 66
	    }, 1000);
	});

	var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML("<img>")).attr("src", event.target.result).appendTo(placeToInsertImagePreview);
                };

                reader.readAsDataURL(input.files[i]);
            }
        }

    };
    $(".thumbnail-upload").on("change", function() {
        $(".preview-thumbnail").empty();
        imagesPreview(this, "div.preview-thumbnail");
    });
    
    $(".additional-upload").on("change", function() {
        $(".preview-additional").empty();
        imagesPreview(this, "div.preview-additional");
    });

    $(".btn-add-video").click(function() {
        $(".videos-field").append("<tr><td><button type='button' class='btn btn-del-video text-danger'><i class='fad fa-trash fa-lg'></i></button></td><td><input type='text' name='add-video[]' required='required' class='form-control form-control' placeholder='<iframe>...</iframe>' /></td></tr>");
    });
    
    $(".videos-field").delegate(".btn-del-video", "click", function () {
        $(this).closest('tr').remove();
    });

    $(".btn-del-image").click(function () {
        var path = $(this).attr('data-path');
        var img_id = $(this).attr('data-id');
        $.ajax({
            type: 'POST',
            url: path,
            success: function(data) {
                $("[data-card-id=img-" + img_id + "]").fadeOut();
            }
        });
    });

    
    $(".btn-del-video").click(function () {
        var path = $(this).attr('data-path');
        var vid_id = $(this).attr('data-id');
        $.ajax({
            type: 'POST',
            url: path,
            success: function(data) {
                $("[data-card-id=vid-" + vid_id + "]").fadeOut();
            }
        });
    });

    

});