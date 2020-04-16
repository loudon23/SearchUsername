<?php

class SearchUsernamePlugin extends MantisPlugin {

    public function register() {
        $this->name        = 'SearchUsername';
        $this->description = '이슈 모니터링 사용자 검색용 플러그인. AD계정의 displayName으로 바꾸니깐 PYL이 \'이 이슈를 모니터링하는 사용자\'에 검색해서 넣는게 불편하다고 하여 만듬';

        $this->version  = '1.0.0';
        $this->requires = array(
                'MantisCore' => '2.0.0',
        );

        $this->author  = 'loudon23';
        $this->contact = 'loudon23@naver.com';
        $this->url     = 'http://github.com/mantisbt-plugins/SearchRelatedIssue';
//        $this->page    = 'config_page';
    }

    function hooks() {
        return array(
                'EVENT_LAYOUT_RESOURCES' => 'resources',
        );
    }

    function resources() {

        $t_page = array_key_exists( 'REQUEST_URI', $_SERVER ) ? basename( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) ) : basename( __FILE__ );
        if( $t_page == 'view.php' ) {
            return '<link rel="stylesheet" type="text/css" href="' . plugin_file( 'username_search.css' ) . '"></link>' .
                    '<script type="text/javascript" src="' . plugin_file( 'username_search.js' ) . '"></script>';
        }
    }

}
