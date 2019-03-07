<?php
global $wpdb;

add_action('wp_ajax_get_all_info', 'get_all_info'); // wp_ajax_{ЗНАЧЕНИЕ ПАРАМЕТРА ACTION!!}
add_action('wp_ajax_nopriv_get_all_info', 'get_all_info');  // wp_ajax_nopriv_{ЗНАЧЕНИЕ ACTION!!}
// первый хук для авторизованных, второй для не авторизованных пользователей

//add_action('wp_ajax_set_tournament_name', 'set_tournament_name');
//add_action('wp_ajax_nopriv_set_tournament_name', 'set_tournament_name');

add_action('wp_ajax_insert_new_row', 'insert_new_row');
add_action('wp_ajax_nopriv_insert_new_row', 'insert_new_row');

function get_all_info() {
    global $wpdb;
    $table_name = $_POST['table_name'] ?? null;

    if (!is_null($table_name)) {
        $sql = "SELECT * FROM " . $table_name;
        $result = $wpdb->get_results($sql);
        echo json_encode($result);
        die;
    } else {
        echo 'Error: cannot get table name';
        die;
    }
}

function insert_new_row() {
    global $wpdb;
    $table_name = $_POST['table_name'] ?? null;
    $table_rows = $_POST['table_rows'] ?? null;

        if (!is_null($table_name) && !is_null($table_rows)) {
//            $keys = implode(array_keys($table_rows),', ');
//            $values = implode($table_rows,', ');
            $result = $wpdb->insert($table_name, $table_rows);
            echo $result;
            die;
        } else {
            echo 'There is no post data';
            die;
        }
}

//function set_tournament_name() {
//    global $wpdb;
//    $tournament_name = $_POST['tournament_name'] ?? null;
//
//    if (!is_null($tournament_name)) {
//        $result = $wpdb->insert(
//            'fm-tournaments',
//            ['name' => $tournament_name],
//            ['%s']
//        );
//        echo $result ?: 'Error: cannot insert name to db';
//        die;
//    } else {
//        echo 'Error: cannot get tournament name';
//    }
//}

