(function() {
  "use strict";

  // WP recipe post type module
  angular.module('angularWPPosts', ['angularPagination'])
  .config(['$locationProvider',function ($locationProvider) {
    $locationProvider.html5Mode({
  enabled: true,
  requireBase: false
});

  }])

  // WP post type generic service
  .factory('postsService', function($http, paginationService, $location) {

    var postsService = {};

    postsService.getNew = function(type) {

      type = type === undefined ? 'post' : type;
      var pagination = paginationService.getNew();
      var lang = $location.search().lang;

      var service = {
        url : '/wp-json/posts/',
        items : {},
        pagination : pagination,
        defaultParams : {
          'type': type,
          'filter[posts_per_page]': pagination.perPage,
          'lang': lang
        },
        prevParams : {},
        loading: false
      }

      service.get = function(id) {
        return $http.get(service.url + id, {cache : true});
      }

      // call with filters to perform new search
      // call with null,page to perform pagination on prev filters
      service.search = function(filters, page) {
        var params;
        if (filters) {
          params = angular.copy(service.defaultParams);
          params = _.extend(params, createSearchParams(filters));
          page = 1;
        } else {
          params = service.prevParams;
          page = page || 1;
        }
        service.pagination.currentPage = page;
        params = _.extend(params, {'page': service.pagination.currentPage});
        service.prevParams = params;

        service.loading = true;
        return $http.get(service.url,{params: params, cache: true})
        .then(function(res) {
          service.loading = false;
          service.items = res.data;
          service.pagination.totalResults = res.headers('X-WP-Total');
          service.pagination.totalPages = res.headers('X-WP-TotalPages');
        });
      }

      function createSearchParams(filters) {
        var params = {};
        _.each(filters, function(filter,key) {
          if (key === 'search') {
            if (filter)
              params['filter[s]'] = filter;
          } else if (key === 'category') {
            if (filter)
              var keys = _.chain(filter).compactObject().keys().value();
              params['filter[category_name]'] = keys.join(',');
          } else {
            var keys = _.chain(filter).compactObject().keys().value();
            params['filter['+key+']'] = keys.join(',');
          }
        })
        return params;
      }

      return service;
    }

    return postsService;
  });

})()
