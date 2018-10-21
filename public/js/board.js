"use strict";

var board = {
  init: function init(args) {
    this.config = {
      pusher: null,
      gamePlayChannel: null,
      gameOverChannel: null,
      csrf: null,
      frozen: false,
      game: args.hasOwnProperty('game') ? args.game : null,
      user: args.hasOwnProperty('user') ? args.user : null,
      elements: {
        cell: '.tic-cell',
        game_info: '.game-info'
      }
    };
    this.setDefaults();
    this.registerEvents();
    console.info('initialize - deal');
  },
  setDefaults: function setDefaults() {
    this.config.csrf = $('meta[name="csrf-token"]').attr('content');
    this.config.pusher = new Pusher('5df7c47b97d098f73fd4', {
      cluster: 'ap1',
      forceTLS: true
    });
    this.config.gamePlayChannel = this.config.pusher.subscribe('game-channel-' + this.config.game.id + '-1');
    this.config.gameOverChannel = this.config.pusher.subscribe('game-over-channel-' + this.config.game.id);
  },
  registerEvents: function registerEvents() {
    var $body = $('body');

    $body.on('click', this.config.elements.cell, this.setTurn);
    this.config.gamePlayChannel.bind('App\\Events\\AIPlay', this.showAITurn);
    this.config.gameOverChannel.bind('App\\Events\\GameOver', this.showGameStatus);
  },
  setTurn: function setTurn(event) {
    event.preventDefault();

    var $this = $(this),
        location = $this.data('location'),
        frozen = board.config.frozen,
        game = board.config.game;

    if (!frozen && game.status === null && !$this.hasClass('cell-busy')) {
      board.config.frozen = true;
      board.showTurn(location, board.config.user.sign);
      $.ajax({
        url: '/make_turn',
        method: 'post',
        data: {
          _token: board.config.csrf,
          game_id: board.config.game.id,
          player_id: board.config.user.id,
          player_type: board.config.user.sign,
          location: location
        }
      }).done(function (response) {
        board.showTurn(response.location, response.player_type);
      });
    }
  },
  showAITurn: function showAITurn(data) {
    board.config.frozen = false;

    board.showTurn(data.location, data.sign);
  },
  showTurn: function showTurn(location, sign) {
    var cell = $(board.config.elements.cell).filter(function (index, item) {
      return $(item).data('location') == location;
    });

    cell.addClass('tic-turn-' + sign + ' cell-busy');
  },
  showGameStatus: function showGameStatus(data) {
    var status = '';

    board.config.frozen = true;

    switch (data.status) {
      case 'win':
        status = '<div class="alert alert-success">Вы победили!</div>';
        break;
      case 'loose':
        status = '<div class="alert alert-danger">Вы проиграли!</div>';
        break;
      default:
        status = '<div class="alert alert-secondary">Ничья!</div>';
        break;
    }

    $(board.config.elements.game_info).html(status);
  }
};
