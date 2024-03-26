(function() {
  "use strict";

  angular.module('blogpostSearchApp', ['ngSanitize', 'ngAnimate', 'truncate', 'angularWPTaxonomy', 'angularWPBlogpost', 'angularWPAuthor'])

  // Post search area controller
  .controller('SearchArea', function($scope, $q, $location, $window, taxonomyService, blogpostService) {
      var vm = $scope.vm = this;
      var types = ['category']; //taxonomies we are concerned with
      vm.filters = {};      //filters for search service for each type
      vm.taxonomies = {};   //loaded taxonomy data for each type
      vm.selected = {};     //selected items by name for each type
      vm.order = "desc";
      //author list needs to come from php as can't be accessed via api without auth
      vm.authors = $window.blogpostSearchApp.authors;

      var inited = false;

      var throttledSearch = _.throttle(search, 500, {leading: false});
      init();

      ////

      function init() {
        loadAllTaxonomies().then(function() {
          $scope.$watch('vm.filters', update, true);
          $scope.$watch('vm.order', update, true);
        });
      }

      //watch & throttle search updates on filter changes
      function update(newValue, oldValue) {
        if (newValue !== oldValue || !inited) {
          inited = true;
          throttledSearch();
          updateSelections();
        }
      }

      function loadAllTaxonomies() {
        var loaders = [];
        _.each(types, function(type) {
          loaders.push(loadTaxonomyList(type));
        });
        return $q.all(loaders);
      }

      function loadTaxonomyList(type) {
        return taxonomyService.list(type)
        .success(function(res) {
          vm.taxonomies[type] = res;
        });
      }

      function search() {
        var order = {};
        order[vm.order] = true;
        var filters = _.extend(vm.filters, {order: order});
        blogpostService.search(filters);
      }

      function updateSelections() {
        //update all types
        _.each(types, function(type) {
          //clear current type
          vm.selected[type] = [];
          //get all slugs of all selected items
          var keys = _.chain(vm.filters[type]).compactObject().keys().value();
          //get names from all slugs and push to current type
          _.each(keys, function(slug) {
            vm.selected[type].push(_.findWhere(vm.taxonomies[type],{slug:slug}).name);
          });
        });

        //repeat for authors
        vm.selected.author = [];
        var keys = _.chain(vm.filters.author).compactObject().keys().value();
        _.each(keys, function(slug) {
          vm.selected.author.push(_.findWhere(vm.authors,{slug: parseInt(slug)}).name);
        });
      }

  })

  // Post list controller
  .controller('PostList', function($scope, $timeout, $window, blogpostService) {
    var vm = $scope.vm = this;
    vm.loading = true;
    vm.noResults = noResults;

    init();

    ////

    function init() {
      $scope.$watch(
        function() {
          return blogpostService.items;
        },
        function (newValue, oldValue) {
          if (newValue !== oldValue) {
            vm.posts = newValue;
            $timeout($window.applySnippetHeights,500);
          }
      	}
      );
      $scope.$watch(
        function() {
          return blogpostService.loading;
        },
        function (newValue, oldValue) {
          if (newValue !== oldValue) {
            vm.loading = newValue;
          }
      	}
      );
    }

    function noResults() {
      return !vm.loading && vm.posts && !vm.posts.length;
    }

  })

  // Post pagination controller
  .controller('PostPagination', function($scope, blogpostService) {
    var vm = $scope.vm = this;
    vm.pagination = blogpostService.pagination;
    vm.pages = {};
    init();

    ////

    function init() {
      $scope.$watch('vm.pagination.totalPages', function (newValue, oldValue) {
        if (newValue != oldValue) {
          updatePagination();
        }
      });
      $scope.$watch('vm.pagination.currentPage', function (newValue, oldValue) {
          if (newValue != oldValue) {
            blogpostService.search(null, newValue);
            updatePagination();
          }
      });
    }

    function updatePagination() {
      var max = Math.min(
        vm.pagination.totalPages,
        vm.pagination.currentPage + ((vm.pagination.currentPage==1)?2:1)
      );
      var min = Math.max(
        1,
        vm.pagination.currentPage - ((vm.pagination.currentPage==vm.pagination.totalPages)?2:1)
      );
      vm.pages = _.range(min,max+1);
    }
  })
  ;

})();
