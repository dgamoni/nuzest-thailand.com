(function() {
  "use strict";

  // Generic reusable pagination service
  angular.module('angularPagination', [])
  .factory('paginationService', function() {

    var pagination = {};

    pagination.getNew = function(perPage) {

      perPage = perPage === undefined ? 12 : perPage;

      var paginator = {
        totalPages: 1,
        totalResults: 0,
        perPage: perPage,
        currentPage: 1
      };

      paginator.setPage = function(id) {
        console.log('set page',id);
        if (id>0 && id<=paginator.totalPages)
          paginator.currentPage = id;
      }

      paginator.nextPage = function() {
        if (paginator.hasNextPage())
          paginator.currentPage += 1;
      }

      paginator.prevPage = function() {
        if (paginator.hasPrevPage())
          paginator.currentPage -= 1;
      }

      paginator.hasNextPage = function() {
        return paginator.currentPage < paginator.totalPages;
      }

      paginator.hasPrevPage = function() {
        return paginator.currentPage > 1;
      }

      return paginator;
    }

    return pagination;

  });

})();