<?php 

// Generate Social Share buttons for single posts

/// SOCIAL SHARING BUTTONS (popup) ///
function social_sharing_buttons() {	
	global $post;
	
		// Get current page URL 
		$shareURL = urlencode(get_permalink());
 
		// Get current page title
		$shareTitle = str_replace( ' ', '%20', get_the_title());
		
		// Get Post Thumbnail for pinterest
		$shareThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		
		// Construct sharing URL
		$twitterURL = 'https://twitter.com/intent/tweet?text='.$shareTitle.'&amp;url='.$shareURL.'&amp;via=Nuzest';
		$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$shareURL;
		$googleURL = 'https://plus.google.com/share?url='.$shareURL;
		$whatsappURL = 'whatsapp://send?text='.$shareTitle . ' ' . $shareURL;
		$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$shareURL.'&amp;title='.$shareTitle;
		$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$shareURL.'&amp;media='.$shareThumbnail[0].'&amp;description='.$shareTitle;
 
		// Add sharing button at the end of page/page content
		$content .= '<ul class="list-inline">';
		$content .= '<li class="share-twitter"><a title="Tweet this" href="'.$twitterURL.'" target="popup" onclick="window.open(\' '.$twitterURL.' \', \'popup\',\'width=600,height=600\'); return false;"><i class="fa fa-twitter"></i></a></li>';
		$content .= '<li class="share-facebook"><a title="Share on Facebook" href="'.$facebookURL.'" target="popup" onclick="window.open(\' '.$facebookURL.' \', \'popup\',\'width=600,height=600\'); return false;"><i class="fa fa-facebook"></i></a></li>';
		$content .= '<li class="share-whatsapp hidden-md hidden-lg"><a title="Share on WhatsApp" href="'.$whatsappURL.'" target="_blank"><i class="fa fa-whatsapp"></i></a></li>';
		$content .= '<li class="share-googleplus"><a title="Share on Google+" href="'.$googleURL.'" target="popup" onclick="window.open(\' '.$googleURL.' \', \'popup\',\'width=600,height=600\'); return false;"><i class="fa fa-google-plus"></i></a></li>';
		$content .= '<li class="share-linkedin"><a title="Share on LinkedIn" href="'.$linkedInURL.'" target="popup" onclick="window.open(\' '.$linkedInURL.' \', \'popup\',\'width=600,height=600\'); return false;"><i class="fa fa-linkedin"></i></a></li>';
		$content .= '<li class="share-pinterest"><a title="Pin this" href="'.$pinterestURL.'" target="popup" onclick="window.open(\' '.$pinterestURL.' \', \'popup\',\'width=600,height=600\'); return false;"><i class="fa fa-pinterest-p"></i></a></li>';
		$content .= '</ul>';
		
		return $content;
};
