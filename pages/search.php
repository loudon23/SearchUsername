<?php
/**
  * 검색 api
  *
  * core/user_api.php 내에 like 검색이 없음
  * 그래서 별도로 만듬
  */

$p_realname = '%'.gpc_get_string( 'referal' ) .'%';
$t_request_id = gpc_get_int( 'request_id' );

$t_query = 'SELECT * FROM {user} WHERE ' . db_helper_like('realname');
$t_result = db_query( $t_query, array( $p_realname ) );
$t_rows = db_num_rows($t_result);

$t_response['request_id'] = $t_request_id;
$t_response['data']       = '';

if( $t_rows  > 0 ) {
    $t_response['data'] = '<ul class="search_result">';
    while( $t_row = db_fetch_array( $t_result ) ) {
        $t_response['data'] .= '<li>' .
            '<a class=search_result href="#">' . $t_row['realname'] . '</a></li>';
    }

    $t_response['data'] .= '</ul>';
}
$t_response_json = json_encode( $t_response );
echo $t_response_json;