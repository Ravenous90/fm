// jquery scripts

jQuery(document).ready(function ($) {

    let ajax_path = '/wp-admin/admin-ajax.php';
    let steps = {'step1': 'name', 'step2': 'players', 'step3': 'teams'};
    let start_tournament_data = {};

    function convert_action_name(name) {
        return name.replace(/-/g, '_');
    }

    $(".modal-start").each( function(){
        $(this).wrap('<div class="overlay"></div>')
    });

    // открытие попапа старт турнира
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

    $('.next-button').on('click', function(e) {
        e.preventDefault();
        var step = $('.modal-start.open .content').find('.active').attr('id');
        switch (step) {
            case steps.step1:
                var tournament_name = $("input[name='tournament-name']").val();
                if (tournament_name != '') {

                    // запись имени турнира в массив
                    start_tournament_data[steps.step1] = tournament_name;

                    $('.start-content#name').removeClass('active');
                    $('.start-content#players').addClass('active');
                    $('.next-button').attr('id', 'go-to-teams');

                    // получение списка игроков из базы
                    $.ajax({
                        url: ajax_path + '?action=get_all_info',
                        type: 'post',
                        data: {
                            table_name: 'fm_players',
                        },
                        dataType: 'json',
                        success: function (data) {
                            console.info(data);
                            $.each(data, function (index, value) {
                                $('.players-view').append('<div class="one-player" data-name="' + value.name + '">'
                                    + value.name + '</div>');
                            });
                        },
                        error: function (error) {
                            alert('Error with getting info from DB - ' + error);
                        }
                    });

                    // добавление нового игрока в базу, и в список
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
                                    data ? $('.players-view')
                                            .append('<div class="one-player" data-name="' + player_name + '">'
                                            + player_name + '</div>')
                                         : alert('Inserting was failed');
                                },
                                error: function (error) {
                                    alert('Error with getting info from DB - ' + error);
                                }
                            });
                        } else {
                            alert('Enter player name');
                        }
                    });

                    $('.players-view').on('click', '.one-player', function () {
                        var name = $(this).data('name');
                        $(this).remove();
                        $('.chosen-players-view ol').append('<li class="chosen-player" id="player-1" data-name="'+name+'">'+name+'</li>');
                    });

                    $('.chosen-players-view ol').on('click', '.chosen-player', function () {
                        var name = $(this).data('name');
                        $(this).remove();
                        $('.players-view').append('<div class="one-player" data-name="'+name+'">'+name+'</div>');
                    });;

                } else {
                    alert('Enter tournament name');
                }
                break;
            case steps.step2:

                $('.start-content#players').removeClass('active');
                $('.start-content#teams').addClass('active');
                $('.next-button').text('Start');

                // получение списка команд из базы
                $.ajax({
                    url: ajax_path + '?action=get_all_info',
                    type: 'post',
                    data: {
                        table_name: 'teams',
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.info(data);
                        $.each(data, function (index, value) {
                            $('.players-view').append('<div class="one-player" data-name="' + value.name + '">'
                                + value.name + '</div>');
                        });
                    },
                    error: function (error) {
                        alert('Error with getting info from DB - ' + error);
                    }
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
