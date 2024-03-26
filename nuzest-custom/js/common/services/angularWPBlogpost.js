(function() {
  "use strict";

  // WP recipe post type module
  angular.module('angularWPBlogpost', ['angularWPPosts', 'angularWPAuthor'])

  // WP post type recipe service
  .factory('blogpostService', function($http, postsService, authorService) {

    var blogPostService = postsService.getNew('post');

    return blogPostService;

  });
})()