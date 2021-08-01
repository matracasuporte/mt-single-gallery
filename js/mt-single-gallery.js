(function ($) {
  var itemGallery = $('.mt-single-gallery .gallery-grid .item');
  var buttonNavigation = $('.gallery-pagination button');
  var strongNavigation = $('.gallery-pagination div');

  var itemPerPage = 3;
  var itemBegin = 0;
  var itemEnd = itemPerPage;
  var quantityPage = Math.ceil(itemGallery.length / itemPerPage);
  var page = 1;

  //strongNavigation.hide();

  function showGalleryItem(begin, end) {
    itemGallery.hide();
    for (var i = begin; i < end; i++) {
      itemGallery.eq(i).show();
    }
    if (page === 1) {
      buttonNavigation.eq(0).addClass('disabled');
      buttonNavigation.eq(1).removeClass('disabled');
    }

    if (page > 1) {
      buttonNavigation.removeClass('disabled');
    }

    if (page === quantityPage) {
      buttonNavigation.eq(1).addClass('disabled');
    }
    strongNavigation.find('strong').eq(0).text(page);
    strongNavigation.find('strong').eq(1).text(quantityPage);
  }

  showGalleryItem(itemBegin, itemEnd, null, page);

  buttonNavigation.eq(0).click(function () {
    if (page > 1) {
      itemBegin -= itemPerPage;
      itemEnd -= itemPerPage;
      page -= 1;
      showGalleryItem(itemBegin, itemEnd);
    }
  });

  buttonNavigation.eq(1).click(function () {
    if (page < quantityPage) {
      itemBegin += itemPerPage;
      itemEnd += itemPerPage;
      page += 1;
      showGalleryItem(itemBegin, itemEnd);
    }
  });
})(jQuery);
