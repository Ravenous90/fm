// jquery scripts

jQuery(document).ready(function ($) {

    const ajax_path = '/wp-admin/admin-ajax.php';

    // steps for view popup 'start trournament'
    const STEPS = {
        'step1': 'name',
        'step2': 'players',
        'step3': 'teams',
        'step4': 'teams-to-players'
    };
    const STEPS_ARR = [STEPS.step1, STEPS.step2, STEPS.step3, STEPS.step4];
    const START_CLASS = '.start-content';
    const START_IDS = ['#'+ STEPS.step1, '#' + STEPS.step2, '#' + STEPS.step3, '#' + STEPS.step4];

    // array with with input data for start tournament
    var start_tournament_data = {};

    function activateNextStep(step_name) {
        let step_number = $.inArray(step_name, STEPS_ARR);

        $(START_CLASS + START_IDS[step_number]).removeClass('active');
         if (START_IDS[step_number + 1] != -1) {
            $(START_CLASS + START_IDS[step_number + 1]).addClass('active');
        } else {
            alert ('Error with getting step');
        }
    }

    function convert_action_name(name) {
        return name.replace(/-/g, '_');
    }

    // popup start tournament
    $(".modal-start").each( function(){
        $(this).wrap('<div class="overlay"></div>')
    });

    $(".open-modal").on('click', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation;

        var $this = $(this),
            modal = $($this).data("modal");

        $(modal).parents(".overlay").addClass("open");
        setTimeout(function () {
            $(modal).addClass("open");
        }, 350);

        $(START_CLASS + START_IDS[0]).addClass('active');
    });

    // main logic for start tournament
    $('.next-button').on('click', function(e) {
        e.preventDefault();
        var step = $('.modal-start.open .content').find('.active').attr('id');
        switch (step) {

//  <------________STEP 1________------>

            case STEPS.step1:
                let tournament_name = $("input[name='tournament-name']").val();

                $('.players-view').empty();
                if (tournament_name != '') {
                    activateNextStep(step);

                    // record var in first step - tournament name
                    start_tournament_data[STEPS.step1] = tournament_name;

                    // getting list of players from DB
                    $.ajax({
                        url: ajax_path + '?action=get_all_info',
                        type: 'post',
                        data: {
                            table_name: 'fm_players',
                        },
                        dataType: 'json',
                        success: function (data) {
                            $.each(data, function (index, value) {
                                $('.players-view').append('<div class="one-player" data-name="' + value.name + '">'
                                    + value.name + '</div>');
                            });
                        },
                        error: function (error) {
                            alert('Error with getting info from DB - ' + error);
                        }
                    });

                    // visible input for add players
                    $('.new-player-button').on('click', function () {
                        $('.add-player-wrapper').toggleClass('invisible');
                    });

                    // add new player to DB and to the viewing list
                    $('.add-player').on('click', function () {
                        var player_name = $("input[name='player-name']").val();
                        if (player_name == '') {
                            alert('Enter player name');
                        } else {
                            $.ajax({
                                url: ajax_path + '?action=insert_new_row',
                                type: 'post',
                                data: {
                                    table_name: 'fm_players',
                                    table_rows: {
                                        'name': player_name,
                                    }
                                },
                                success: function (data) {
                                    let state = $('.del-player-button').hasClass('activated');
                                    let base_class = !state ? 'one-player' : 'one-player' + ' delete-player';

                                    if (data) {
                                        $('.players-view')
                                            .append('<div class="' + base_class + '" data-name="' + player_name + '">'
                                                + player_name + '</div>');
                                        $('.add-player-wrapper').css({'opacity': 0, 'pointer-events': 'none'});
                                    } else {
                                        alert('Inserting was failed');
                                    }
                                },
                                error: function (error) {
                                    alert('Error with getting info from DB - ' + error);
                                }
                            });
                            $('.fm-input').val('');
                        }
                    });

                    // removing player
                    $('.del-player-button').on('click', function () {
                        let player = $('.one-player');
                        if (!$(this).hasClass('activated')) {
                            player.each(function () {
                                $(this).addClass('delete-player');
                            });
                            $(this)
                                .addClass('activated')
                                .removeClass('btn-danger')
                                .addClass('btn-info');
                        } else {
                            player.each(function () {
                                $(this).removeClass('delete-player');
                            });
                            $(this)
                                .removeClass('activated')
                                .removeClass('btn-info')
                                .addClass('btn-danger');
                        }
                    });

                    function deletePlayer(player_name) {
                        $.ajax({
                            url: ajax_path + '?action=remove_one_row',
                            type: 'post',
                            data: {
                                table_name: 'fm_players',
                                flags: {
                                    'name': player_name,
                                },
                                // need to put all flag's types in simple array
                                flags_types: [
                                    '%s',
                                ],
                            },
                            success: function (data) {
                                data ? alert('Player ' + player_name + ' was removing') : alert('Some problems on back-end');
                            },
                            error: function (error) {
                                alert('Error with removing from DB - ' + error);
                            }
                        });
                    }

                    function choosePlayer(player_object) {
                        let name = player_object.data('name');
                        player_object.remove();

                        if (player_object.hasClass('delete-player')) {
                            deletePlayer(name);
                        } else {
                            $('.chosen-players-view ol')
                                .append('<li class="chosen-player" data-name="' + name + '">' + name + '</li>');
                        }
                    }

                    // choosing players for game
                    $('.players-view').on('click', '.one-player', function () {
                        choosePlayer($(this));
                    });


                    // choose random player
                    $('.random-player-block').on('click', function () {
                        let players = $('.one-player');
                        if (players.hasClass('delete-player')) {
                            alert('Delete player or turn off deletion');
                        } else if (players.length == 0) {
                            alert('There are no players');
                        } else {
                            let rnd = Math.floor(Math.random() * players.length + 1);
                            let rnd_pl = $('.one-player:nth-child(' + rnd + ')');
                            choosePlayer(rnd_pl);
                        }
                    });

                    // move chosen player back to player's list
                    $('.chosen-players-view').on('click', '.chosen-player', function () {
                        var name = $(this).data('name');
                        $(this).remove();
                        $('.players-view')
                            .append('<div class="one-player" data-name="' + name + '">' + name + '</div>');
                    });

                    $('.fm-input').val('');
                } else {
                    alert('Enter tournament name');
                }
                break;

//  <------________STEP 2________------>

            case STEPS.step2:
                let players = [];

                $('.chosen-player').each(function (e) {
                    players[e] = $(this).data('name');
                });

                if (players.length == 0) {
                        alert('Choose players');
                } else {

                    activateNextStep(step);

                    // record var in second step - players
                    start_tournament_data[STEPS.step2] = players;

                    // getting list of leagues
                    $.ajax({
                        url: ajax_path + '?action=get_all_info',
                        type: 'post',
                        data: {
                            table_name: 'fm_leagues',
                        },
                        dataType: 'json',
                        success: function (data) {
                            $.each(data, function (index, value) {
                                $('.leagues-view')
                                    .append('<div class="one-league" data-name="' + value.name + '" data-id="' + value.id + '">'
                                        + value.name + '</div>');
                            });
                        },
                        error: function (error) {
                            alert('Error with getting info from DB - ' + error);
                        }
                    });

                    // getting list of teams
                    setTimeout(function () {
                        $.ajax({
                            url: ajax_path + '?action=get_all_info',
                            type: 'post',
                            data: {
                                table_name: 'fm_teams',
                            },
                            dataType: 'json',
                            success: function (data) {
                                console.info(data);
                                $.each(data, function (index, value) {
                                    $('.teams-view')
                                        .append('<div class="one-team deactivated" data-name="' + value.name + '" data-id="' + value.id + '" ' +
                                            'data-league="' + value.leagues_id + '">' +
                                            '<img src="' + value.img_url + '" alt="' + value.name + '"></div>');
                                });
                            },
                            error: function (error) {
                                alert('Error with getting info from DB - ' + error);
                            }
                        });
                    }, 500);

                    // getting teams by league
                    $('.leagues-view').on('click', '.one-league', function () {
                        let league_id = $(this).data('id');

                        $('.leagues-view').toggleClass('deactivated');
                        $('.back-to-leagues').toggleClass('deactivated');
                        $('.teams-view').toggleClass('deactivated');

                        $('.one-team*[data-league="' + league_id + '"]').each(function () {
                            $(this).toggleClass('deactivated');
                        });
                    });

                    // back to leagues button
                    $('.back-to-leagues').on('click', function () {
                        $('.back-to-leagues').toggleClass('deactivated');
                        $('.teams-view').toggleClass('deactivated');
                        $('.leagues-view').toggleClass('deactivated');
                        $('.one-team').not('.deactivated').addClass('deactivated');
                    });

                    // choose teams for n-basket
                    $('.teams-view').on('click', '.one-team', function () {
                        let basket_id = $('.baskets-number').val();
                        let team_name = $(this).data('name');
                        let team_id = $(this).data('id');
                        let team_league = $(this).data('league');
                        let img_src = $(this).children().attr('src');

                        $(this).remove();

                        if (!$('ol').is('#' + basket_id)) {
                            $('.chosen-teams-view').append('<ol id="' + basket_id + '"></ol>');
                        }

                        $('.chosen-teams-view ol#' + basket_id)
                            .append('<li class="chosen-team" data-name="' + team_name + '" data-id="' + team_id + '" ' +
                                'data-league="' + team_league + '" data-img="' + img_src + '">' + team_name + '</li>');
                    });

                    // move chosen team back to team's list
                    $('.chosen-teams-view').on('click', '.chosen-team', function () {
                        let team_name = $(this).data('name');
                        let team_id = $(this).data('id');
                        let team_league = $(this).data('league');
                        let img_src = $(this).data('img');

                        $(this).remove();

                        // switch class name depending on where click removing
                        let needed_class = $('.leagues-view').hasClass('deactivated') ? 'one-team' : 'one-team deactivated';
                        $('.teams-view')
                            .append('<div class="' + needed_class + '" data-name="' + team_name + '" data-id="' + team_id + '" ' +
                                'data-league="' + team_league + '">' +
                                '<img src="' + img_src + '" alt="' + team_name + '"></div>');
                    });
                }
                break;

//  <------________STEP 3________------>

            case STEPS.step3:
                activateNextStep(step);

                let baskets_arr = [];

                // transform object with players to simple array for better using
                let player_arr = $.map(start_tournament_data[STEPS.step2], function(e) {return e});
                let current_player_key = 0;
                let current_player = player_arr[current_player_key];

                $('.next-button').text('Start');

                // add players to block, where will be chosen teams
                $.each(player_arr, function (index, value) {
                    $('.teams-to-players-view')
                        .append('<div class="teams-to-one-player" data-player="' + value + '">' +
                        '<span class="teams-to-current-player">' + value + '</span></div>');
                });

                // get baskets array
                $('.chosen-teams-view ol').each(function () {
                    baskets_arr.push($(this).attr('id'));
                });
                let current_basket = baskets_arr[0];

                // add teams to their baskets for choosing
                $('.chosen-team').each(function () {
                    let team_name = $(this).data('name');
                    let team_id = $(this).data('id');
                    let team_league = $(this).data('league');
                    let img_src = $(this).data('img');
                    let basket_id = $(this).parent().attr('id');

                    let cur_cl = (basket_id == current_basket) ? '' : ' deactivated';

                    $('.teams-in-basket-view')
                        .append('<div class="one-team-in-basket'+cur_cl+'" data-id="'+team_id+'" ' +
                        'data-name="'+team_name+'" data-league="'+team_league+'" data-basket="'+basket_id+'">' +
                        '<img src="'+img_src+'" alt="'+team_name+'"></div>');
                });

                function updateCurrentBasketTeams(current_basket) {
                    $('.one-team-in-basket').each(function () {
                        if ($(this).data('basket') == current_basket) {
                            if($(this).hasClass('deactivated')) {
                                $(this).removeClass('deactivated');
                            }
                        } else {
                            if(!$(this).hasClass('deactivated')) {
                                $(this).addClass('deactivated');
                            }
                        }
                    });
                }

                function changeTextOfCurrentBasket(current_basket) {

                    let text = ' ';
                    switch (Number(current_basket)) {
                        case 1:
                            text = 'first';
                            break;
                        case 2:
                            text = 'second';
                            break;
                        case 3:
                            text = 'third';
                            break;
                        case 4:
                            text = 'fourth';
                            break;
                        case 5:
                            text = 'fifth';
                            break;
                    }
                    $('.current-basket-id').text(text);
                }

                changeTextOfCurrentBasket(current_basket);

                // get list of teams from next basket
                $('.next-basket').on('click', function () {
                    let basket_pos = $.inArray(current_basket, baskets_arr);

                    if ((basket_pos) != baskets_arr.length - 1) {
                        current_basket = baskets_arr[basket_pos + 1];
                        updateCurrentBasketTeams(current_basket);
                        changeTextOfCurrentBasket(current_basket);
                    }
                });

                // get list of teams from previous basket
                $('.previous-basket').on('click', function () {
                    let basket_pos = $.inArray(current_basket, baskets_arr);

                    if ((basket_pos) != 0) {
                        current_basket = baskets_arr[basket_pos - 1];
                        updateCurrentBasketTeams(current_basket);
                        changeTextOfCurrentBasket(current_basket);
                    }
                });

                function chooseTeam(team_object) {
                    let team_name = team_object.data('name');
                    let team_id = team_object.data('id');
                    let team_league = team_object.data('league');
                    let img_src = team_object.children().attr('src');
                    let basket_id = team_object.data('basket');

                    team_object.remove();

                    $('.chosen-team-to-player').each(function () {
                        if ($(this).hasClass('can-deleted')) {
                            $(this).removeClass('can-deleted');
                        }
                    });

                    $('.teams-to-one-player[data-player="'+current_player+'"]')
                        .append('<p class="chosen-team-to-player can-deleted" data-name="'+team_name+'" data-id="'+team_id+'" ' +
                            'data-league="'+team_league+'" data-img="'+img_src+'" data-player="'+current_player+'" ' +
                            'data-basket="'+basket_id+'">' + team_name + '</p>');

                    // choose next player
                    current_player_key++;
                    current_player = player_arr[current_player_key];

                    // if there isn't name in player array (previous was last name in array) assign first name as current
                    if ($.inArray(current_player, player_arr) == -1) {
                        current_player_key = 0;
                        current_player = player_arr[current_player_key];
                    }
                }
                // add team to current player from current basket
                $('.teams-in-basket-view').on('click', '.one-team-in-basket', function () {
                    chooseTeam($(this));
                });

                // choose random team from current basket
                $('.random-team-block').on('click', function () {
                    let teams = [];
                    $('.one-team-in-basket').each(function () {
                        if (!$(this).hasClass('deactivated')) {
                            teams.push($(this));
                        }
                    });
                    if (teams.length == 0) {
                        alert('There are no teams in current basket');
                    } else {
                        let rnd = Math.floor(Math.random() * teams.length + 1);
                        let rnd_team = $('.one-team-in-basket:nth-child(' + rnd + ')');
                        chooseTeam(rnd_team);
                    }
                });

                // move chosen team-to-player back to teams-in-basket list
                $('.teams-to-one-player').on('click', '.chosen-team-to-player', function () {
                    if (!$(this).hasClass('can-deleted')) {
                        alert('You can remove only last team of the list');
                    } else {
                        let team_name = $(this).data('name');
                        let team_id = $(this).data('id');
                        let team_league = $(this).data('league');
                        let img_src = $(this).data('img');
                        let basket_id = $(this).data('basket');

                        $(this).remove();

                        let cur_cl = basket_id == current_basket ? '' : ' deactivated';

                        $('.teams-in-basket-view')
                            .append('<div class="one-team-in-basket' + cur_cl + '" data-id="' + team_id + '" ' +
                                'data-name="' + team_name + '" data-league="' + team_league + '" ' +
                                'data-basket="' + basket_id + '">' +
                                '<img src="' + img_src + '" alt="' + team_name + '"></div>');

                        current_player = $(this).data('player');
                        current_player_key = $.inArray(current_player, player_arr);

                        let previous_player = current_player_key != 0 ?
                            player_arr[current_player_key - 1] :
                            player_arr[player_arr.length - 1];

                        let prev_team = $('.teams-to-one-player').find('[data-player=' + previous_player + ']').last();

                        if (prev_team.data('player') == previous_player) {
                            $(prev_team).addClass('can-deleted');
                        }
                    }
                });

                break;

//  <------________STEP 3________------>

            case STEPS.step4:
                 // setTimeout( function(){
                 //     $('#start').parents(".overlay").removeClass("open");
                 //     $(START_CLASS + START_IDS[$.inArray(step, STEPS_ARR)]).removeClass('active');
                 // }, 500);
                let player_to_teams = [];
                $('.teams-to-one-player').each(function () {
                    $(this).children().each(function () {
                        if ($(this).hasClass('chosen-team-to-player')) {
                            let player = $(this).data('player');
                            let team = $(this).data('name');
                            player_to_teams.push({
                                [player]: team
                            });
                        }
                    });
                });
                start_tournament_data[STEPS.step3] = player_to_teams;
console.info(start_tournament_data);
                break;
            default:
                alert('there is no step');
                break;
        }
    });

    // close popup start tournament
    $(document).on('click', function(e){
        var target = $(e.target);
            if ($(target).hasClass("overlay")) {
                $(target).find('.modal-start').each(function () {
                    $(this).removeClass("open");
                });
                setTimeout(function () {
                    $(target).removeClass("open");
                    $('.start-content').removeClass('active');
                }, 350);
            }
    });

});

// end jquery scripts_data
