webpackJsonp([1],{

/***/ 67:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(68);
module.exports = __webpack_require__(69);


/***/ }),

/***/ 68:
/***/ (function(module, exports) {

$(document).ready(function () {
  var modal = $('.modal');
  $('.history-link').click(function (event) {
    event.preventDefault();

    var $this = $(this),
        url = $this.data('href');

    $.ajax({
      url: url,
      method: 'get'
    }).done(function (response) {
      modal.find('.modal-title').text(response.title);
      modal.find('.modal-body').html(response.data);
      modal.modal('show');
    });
  });

  $('body').on('click', '.toggle-turns', function (event) {
    event.preventDefault();

    var $this = $(this),
        game_id = $this.data('game-id');

    $('.hidden-table-row').filter(function (index, item) {
      return $(item).data('game-id') === game_id;
    }).toggle(0, function () {
      $this.toggleClass('active');
    });
  });
});

/***/ }),

/***/ 69:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })

},[67]);