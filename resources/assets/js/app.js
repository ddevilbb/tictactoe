$(document).ready(function () {
  let modal = $('.modal');
  $('.history-link').click(function (event) {
    event.preventDefault();

    let $this = $(this),
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

    let $this = $(this),
      game_id = $this.data('game-id');

    $('.hidden-table-row').filter(function (index, item) {
      return $(item).data('game-id') === game_id;
    }).toggle(0, function () {
      $this.toggleClass('active');
    });
  });
});