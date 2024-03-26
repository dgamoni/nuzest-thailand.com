jQuery(document).ready(function () {
    jQuery(".story-slider").owlCarousel({
	
        slideSpeed: 300,
        stopOnHover: true,
        paginationSpeed: 400,
        transitionStyle: "fade",
        afterMove: function (e) {
            if(this.owl.currentItem == 0){
				alert("first");
                jQuery("#carousel-custom-dots .active").removeClass("active");
                jQuery('.owl-dot:first-child').addClass("active");
            } else if(this.owl.currentItem == 1){
				alert("second");
                jQuery("#carousel-custom-dots .active").removeClass("active");
                jQuery('.owl-dot:nth-child(2)').addClass("active");
            } else if(this.owl.currentItem == 2){
				alert("third");
                jQuery("#carousel-custom-dots .active").removeClass("active");
                jQuery('.owl-dot:nth-child(3)').addClass("active");
            } 
        }
    });

    jQuery('.owl-dot').click(function (e) {
        e.preventDefault();
        jQuery("#carousel-custom-dots .active").removeClass("active");
        jQuery(this).addClass("active");
        jQuery(".story-slider").trigger('to.owl.carousel', [jQuery(this).index(), 300]);
    });

});
