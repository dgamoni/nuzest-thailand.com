jQuery(document).ready(function () {

  var showBio = jQuery('a[data-show-modal="biography"]'),
      loadingBio = false;

  showBio.click(function (e) {
      e.preventDefault();

      if (typeof theme_js_vars.ajaxurl !== 'undefined') {

          var $link = jQuery(this),
              $theModal = jQuery('#generalModal'),
              appendTo = $theModal.find('#modalContent'),
              thisID = jQuery(this).data('profile-id'),
              authorID = jQuery(this).data('author-id');

          if (loadingBio) return;
          loadingBio = true;

          // visual state to show loading
          $link.addClass('loading');

          jQuery.ajax({
              url: theme_js_vars.ajaxurl,
              data: {
                  'action': 'ajax_get_profile',
                  'id': thisID,
                  'authorID': authorID
              },
              success: function (data) {
                  appendTo.html(data);
                  $theModal.modal('toggle');
                  $link.removeClass('loading');
                  loadingBio = false;
              },
              error: function (errorThrown) {
                  appendTo.html('Sorry, there was an error loading the profile.');
                  $theModal.modal('toggle');
                  $link.removeClass('loading');
                  loadingBio = false;
              }
          });

      }
  });
});
