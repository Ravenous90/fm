// jquery scripts

jQuery(document).ready(function ($) {

    const ajax_path = '/wp-admin/admin-ajax.php';

    // steps for view popup 'start trournament'
    const steps = {'step1': 'name', 'step2': 'players', 'step3': 'teams'};

    // array with with input data for start tournament
    let start_tournament_data = {};

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

        $('.start-content#name').addClass('active');
    });

    // visible input for add players
    $('.new-player-button').on('click', function () {
        $('.add-player-wrapper').css({'opacity': 1, 'pointer-events': 'visible'});

    });

    // main logic for start tournament
    $('.next-button').on('click', function(e) {
        e.preventDefault();
        var step = $('.modal-start.open .content').find('.active').attr('id');
        switch (step) {
            case steps.step1:
                $('.players-view').empty();
                var tournament_name = $("input[name='tournament-name']").val();
                if (tournament_name != '') {

                    // record var in first step - tornament name
                    start_tournament_data[steps.step1] = tournament_name;

                    $('.start-content#name').removeClass('active');
                    $('.start-content#players').addClass('active');
                    $('.next-button').attr('id', 'go-to-teams');

                    // getting list of players from DB
                    $.ajax({
                        url: ajax_path + '?action=get_all_info',
                        type: 'post',
                        data: {
                            table_name: 'fm_players',
                        },
                        dataType: 'json',
                        success: function (data) {
                            // console.info(data);
                            $.each(data, function (index, value) {
                                $('.players-view').append('<div class="one-player" data-name="' + value.name + '">'
                                    + value.name + '</div>');
                            });
                        },
                        error: function (error) {
                            alert('Error with getting info from DB - ' + error);
                        }
                    });

                    // add new player to DB and to the viewing list
                    $('.add-player').on('click', function () {
                        var player_name = $("input[name='player-name']").val();
                        if (player_name != '') {
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
                        } else {
                            alert('Enter player name');
                        }
                    });

                    // removing player
                    $('.del-player-button').on('click', function () {
                        var player = $('.one-player');
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

                    $('.players-view').on('click', '.one-player', function () {
                        var name = $(this).data('name');
                        $(this).remove();

                        if ($(this).hasClass('delete-player')) {
                            deletePlayer(name);
                        } else {
                            $('.chosen-players-view ol')
                                .append('<li class="chosen-player" data-name="' + name + '">' + name + '</li>');
                        }
                    });

                    // move chosen player back to player's list
                    $('.chosen-players-view ol').on('click', '.chosen-player', function () {
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
            case steps.step2:
                $('.start-content#players').removeClass('active');
                $('.start-content#teams').addClass('active');
                $('.next-button').text('Start');

                // // record var in second step - players
                let players = {};

                $('.chosen-player').each(function (e) {
                    players[e] = $(this).data('name');
                });

                start_tournament_data[steps.step2] = players;
                console.info(start_tournament_data);

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
                                .append('<div class="one-league" data-name="'+value.name+'" data-id="'+value.id+'">'
                                + value.name + '</div>');
                        });
                    },
                    error: function (error) {
                        alert('Error with getting info from DB - ' + error);
                    }
                });

                //

                $('.leagues-view').on('click', '.one-league', function () {
                    var league_id = $(this).data('id');
                    $('.leagues-view').find('.one-league').addClass('deactivated');
                    $('.back-to-leagues').css('display', 'inline-block');

                    $.ajax({
                        url: ajax_path + '?action=get_info_with_flags',
                        type: 'post',
                        data: {
                            table_name: 'fm_leagues',

                            // if didn't set field - all fields will be getting by default
                            // need to set string with coma
                            fields : 'id',

                            // flags and values need to be arrays for parsing in back-end
                            flags: ['id'],
                            values: [league_id],
                        },
                        dataType: 'json',
                        success: function (data) {
                            console.info(data);
                            $.ajax({
                                url: ajax_path + '?action=get_info_with_flags',
                                type: 'post',
                                data: {
                                    table_name: 'fm_teams',
                                    flags: ['leagues_id'],
                                    values: [data[0].id],
                                },
                                dataType: 'json',
                                success: function (data) {
                                    console.info(data);
                                    $.each(data, function (index, value) {
                                        $('.teams-view')
                                            .append('<div class="one-team" data-name="'+value.name+'" data-id="'+value.id+'">' +
                                                '<img src="'+value.img_url+'" alt="'+value.name+'"></div>');
                                    });
                                },
                                error: function (error) {
                                    alert('Error with getting info from DB - ' + error);
                                }
                            });

                        },
                        error: function (error) {
                            alert('Error with getting info from DB - ' + error);
                        }
                    });

                });

                // back to leagues button
                $('.back-to-leagues').on('click', function () {
                    $('.teams-view').empty()
                    $('.leagues-view').find('.one-league').removeClass('deactivated');
                });

                break;
            case steps.step3:
                 setTimeout( function(){
                     $('#start').parents(".overlay").removeClass("open");
                     $('.start-content#teams').removeClass('active');
                 }, 500);
                break;
            default:
                alert('there is no step');
                break;
        }
    });

    // закрытие попапа начала турнира

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


// $('#set-tournament-name').on('click' , function (e) {
//     e.preventDefault();
//     var action = convert_action_name($(this).attr('id'));
//     var tournament_name = $("input[name='tournament-name'").val();
//     if (tournament_name != '') {
//         $.ajax({
//             url: ajax_path + '?action=' + action,
//             type: 'post',
//             data: {
//                 tournament_name: tournament_name,
//             },
//             dataType: 'json',
//             success: function (data) {
//                 console.info(data);
//             }
//         });
//     } else {
//         alert('Enter tournament name');
//     }
// });


// end jquery scripts_data
