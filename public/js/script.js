$(document).ready(function() {

	var str = "123";
	var res = str.replace("123", "456");

	setInterval(function(){
		$(".arrow").effect("bounce", { direction:'down', times:2 }, 1000);
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
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };
    $('.thumbnail-upload').on('change', function() {
        $('.preview-thumbnail').empty();
        imagesPreview(this, 'div.preview-thumbnail');
    });
    
    $('.additional-upload').on('change', function() {
        $('.preview-additional').empty();
        imagesPreview(this, 'div.preview-additional');
    });


	
});