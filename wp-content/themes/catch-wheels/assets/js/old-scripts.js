// old script


// var strong_teams = [
//    'FC&nbsp;Barcelona',
//    'Juventus',
//    'FC&nbsp;Bayern&nbsp;Munich',
//    'Manchester&nbsp;City',
//    'Paris&nbsp;Saint&#8209;Germain',
//    'Manchester&nbsp;United',
//    'Liverpool',
//    'Real&nbsp;Madrid',
// ];
//
// var weak_teams = [
//    'Arsenal',
//    'Atlético&nbsp;Madrid',
//    'Tottenham&nbsp;Hotspur',
//    'Borussia&nbsp;Dortmund',
//    'Chelsea',
// ];
//
// var players = [
//    'Тема',
//    'Конан',
//    'Русик'
// ];
//
// $(".lets-start-game").on("click", function (event) {
//    event.preventDefault();
//    var popup = $('#' + $(this).attr("rel"));
//    $(popup).show(2000);
//    $('.overlay_popup').show();
//
//    $.each(players, function (index, value) {
//        $('.div-players').append("<div class='one-player' id='" + index + "'>" + value + "</div>");
//    });
//
// 	$(".priority-number").text("1");
//
//    $(".one-player").on("click", function () {
//        var id = $(this).attr('id');
//        var chosen_player = $(this).text();
// 					var priority = 1;
//        $("#" + id + "").hide(1500).text("");
//        $(".td-player").each(function () {
//            if ($.trim($(this).text()) == "") {
//                $(this).append(players[id]);
//                return false;
//            }
//        });
//
//
//        if ($.trim($(".one-player").text()) == "") {
//        $(".priority-players").text("");
//            setTimeout(function () {
//                $('.overlay_popup').hide();
//                $('.popup').hide(1000);
//            }, 1500);
//        }
//        $(".one-player").each(function () {
//        	if ($.trim($(this).text()) == "") {
//          	priority += 1;
//          }
//        });
//
//        $(".priority-number").text(priority);
//    });
// });
//
// $('.overlay_popup').click(function () {
//    $('.overlay_popup').hide();
//    $('.popup').hide(1000);
//    $('.one-player').remove();
// });
//
//
// $(".get-strong-team").on("click", function (event) {
//    event.preventDefault();
//    if (strong_teams.length <= 5) {
//        alert('Набор сильных команд закрыт');
//    } else {
//        var rand_s = Math.floor(Math.random() * strong_teams.length);
//        var rand_command_s = strong_teams[rand_s];
//
//        $(".strong-team").each(function () {
//            if ($.trim($(this).text()) == "") {
//                $(this).append(rand_command_s);
//                return false;
//            }
//        });
//
//        strong_teams.splice($.inArray(rand_command_s, strong_teams), 1);
//        $(".count-strong-teams").text(strong_teams.length);
//    }
// });
//
// $(".get-weak-team").on("click", function (event) {
//    event.preventDefault();
//    if (weak_teams.length <= 2) {
//        alert('Набор слабых команд закрыт');
//    } else {
//        var rand_w = Math.floor(Math.random() * weak_teams.length);
//        var rand_command_w = weak_teams[rand_w];
//
//        $(".weak-team").each(function () {
//            if ($.trim($(this).text()) == "") {
//                $(this).append(rand_command_w);
//                return false;
//            }
//        });
//
//        weak_teams.splice($.inArray(rand_command_w, weak_teams), 1);
//        $(".count-weak-teams").text(weak_teams.length);
//    }
// });
//
// $(".new-tournament").on("click", function (event) {
//    event.preventDefault();
//    location.reload();
// });
//
// $(".button-tournament").on("click", function (event) {
//    event.preventDefault();
// 	$(".button-tournament").addClass("active");
// 	setTimeout(
// 	function () {
// 		$(".button-tournament").removeClass("active");
// 	}, 2000);
// });

// end old script