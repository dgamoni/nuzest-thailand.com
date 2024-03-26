// fire modal for CMS controlled button on testimonials page
jQuery(document).ready(function($) {
	// target button in intro section
	$('.intro-sec a').on('click', function(e) {
		// prevent clicks
		e.preventDefault();
		// launch the modal
		$('#testimonialForm').modal('show');
	});

	// Testimonial Submission Modal
	$('#submitTestBtn').click(function(e){
		e.preventDefault();
		$('#testimonialForm').modal('toggle');
	});
});
