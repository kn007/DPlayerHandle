<?php

/**
*	DPlayer是一个可爱且支持弹幕的HTML5视频播放器，由DIYgod编写，项目地址：https://github.com/MoePlayer/DPlayer
*
*	DPlayer Lite是一个简洁实用的HTML5视频播放器，由kn007基于DPlayer 1.17.1 5207d26修改而成，项目地址：https://github.com/kn007/DPlayer-Lite
*
*	调用DPlayerHandle类并进行初始化，可以很简便的在WordPress使用上DPlayer Lite及DPlayer（有限功能）
*	短代码调用方法详见博客文章：https://kn007.net/topics/wordpress-blog-use-new-html5-video-player-dplayer-lite/
*
*	支持原生[video]标签，前提是增加dplayer参数，并且视频地址使用src参数
*
*	此代码以MIT许可协议授权，作者kn007，写于2017年12月12日。Github地址：https://github.com/kn007/DPlayerHandle
**/


class DPlayerHandle {
	protected $instance = 0;
	protected $hls_enable = 0;
	protected $flv_enable = 0;
	protected $dash_enable = 0;
	protected $webtorrent_enable = 0;

	public function init() {
		add_shortcode( 'dplayer', array( $this, 'dplayer_shortcode' ) );
		add_action( 'admin_print_footer_scripts', array( $this, 'shortcode_buttons' ), 99999 );
		add_filter( 'wp_video_shortcode_override' , array( $this, 'override_wp_video_shortcode' ), 1, 2 );
		wp_register_script( 'hlsjs', 'https://unpkg.com/hls.js/dist/hls.min.js', array(), "0.8.8", true );
		wp_register_script( 'flvjs', 'https://unpkg.com/flv.js/dist/flv.min.js', array(), "1.3.3", true );
		wp_register_script( 'dashjs', 'https://cdn.jsdelivr.net/npm/dashjs/dist/dash.all.min.js', array(), "2.6.4", true );
		wp_register_script( 'webtorrent', 'https://cdn.jsdelivr.net/webtorrent/latest/webtorrent.min.js', array(), "0.98.20", true );
		wp_register_script( 'dplayer', 'https://unpkg.com/dplayer', array(), "1.17.1", true );
	}

	protected function dplayer_extension( $name ) {
		wp_dequeue_script( 'dplayer' );
		switch ( $name ) {
			case 'hlsjs':
				wp_enqueue_script( 'hlsjs' );
				$this->hls_enable++;
				break;
			case 'flvjs':
				wp_enqueue_script( 'flvjs' );
				$this->flv_enable++;
				break;
			case 'dashjs':
				wp_enqueue_script( 'dashjs' );
				$this->dash_enable++;
				break;
			case 'webtorrent':
				wp_enqueue_script( 'webtorrent' );
				$this->webtorrent_enable++;
				break;
		}
		wp_enqueue_script( 'dplayer' );
	}

	public function dplayer_shortcode( $atts = array(), $content = '' ) {
		if ( !is_singular() && !is_admin() ) return;

		$atts = shortcode_atts(
			array(
				'autoplay'       => 'false',
				'theme'          => '#b7daff',
				'loop'           => 'false',
				'preload'        => 'auto',
				'src'            => '',
				'poster'         => '',
				'type'           => 'auto',
				'mutex'          => 'true',
				'iconsColor'     => '#ffffff',
			), $atts, 'dplayer_shortcode' );

		$atts['autoplay']        = wp_validate_boolean( $atts['autoplay'] );
		$atts['theme']           = esc_attr( $atts['theme'] );
		$atts['loop']            = wp_validate_boolean( $atts['loop'] );
		$atts['preload']         = esc_attr( $atts['preload'] );
		$atts['src']             = esc_url_raw( $atts['src'] );
		$atts['poster']          = esc_url_raw( $atts['poster'] );
		$atts['type']            = strtolower( esc_attr( $atts['type'] ) );
		$atts['mutex']           = wp_validate_boolean( $atts['mutex'] );
		$atts['iconsColor']      = esc_attr( $atts['iconsColor'] );

		if ( empty( $atts['src'] ) ) return;

		$this->instance++;
		( 1 === $this->instance ) && wp_enqueue_script( 'dplayer' );

		( 0 === $this->hls_enable ) && ( $atts['type'] == 'hls' || preg_match( "/\.(m3u8)($|\?|\#)/", strtolower( $atts['src'] ) ) ) && $this->dplayer_extension( 'hlsjs' );
		( 0 === $this->flv_enable ) && ( $atts['type'] == 'flv' || preg_match( "/\.(flv)($|\?|\#)/", strtolower( $atts['src'] ) ) ) && $this->dplayer_extension( 'flvjs' );
		( 0 === $this->dash_enable ) && ( $atts['type'] == 'dash' || preg_match( "/\.(mpd)($|\?|\#)/", strtolower( $atts['src'] ) ) ) && $this->dplayer_extension( 'dashjs' );
		( 0 === $this->webtorrent_enable ) && ( $atts['type'] == 'webtorrent' || preg_match( "/\.(torrent)($|\?|\#)/", strtolower( $atts['src'] ) ) || preg_match( "/(magnet:\?xt=urn:btih:)?(.{40})/", strtolower( $atts['src'] ) ) ) && $this->dplayer_extension( 'webtorrent' );

		if ( empty( $atts['poster'] ) ) {
			$output = sprintf( '<script>var dp%u=new DPlayer({container:document.getElementById("dplayer-%u"),autoplay:%b,theme:"%s",loop:%b,preload:"%s",video:{url:"%s",type:"%s"},mutex:%b,iconsColor:"%s"});</script>',
				$this->instance,
				$this->instance,
				$atts['autoplay'],
				$atts['theme'],
				$atts['loop'],
				$atts['preload'],
				$atts['src'],
				$atts['type'],
				$atts['mutex'],
				$atts['iconsColor']
			);
		} else {
			$output = sprintf( '<script>var dp%u=new DPlayer({container:document.getElementById("dplayer-%u"),autoplay:%b,theme:"%s",loop:%b,preload:"%s",video:{url:"%s",pic:"%s",type:"%s"},mutex:%b,iconsColor:"%s"});</script>',
				$this->instance,
				$this->instance,
				$atts['autoplay'],
				$atts['theme'],
				$atts['loop'],
				$atts['preload'],
				$atts['src'],
				$atts['poster'],
				$atts['type'],
				$atts['mutex'],
				$atts['iconsColor']
			);
		}

		$html = sprintf( '<div id="dplayer-%u"></div>',
			$this->instance
		);

		add_action( 'wp_footer', function () use ( $output ) {
			echo '		' . $output . "\n";
		}, 99999 );

		return $html;
	}

	public function shortcode_buttons() {
		if ( wp_script_is( 'quicktags' ) ) {
			echo "<script type=\"text/javascript\">QTags.addButton('add_dplayer', 'dplayer', '[dplayer src=\"\"]');</script>";
		}
	}

	public function override_wp_video_shortcode( $html = '', $atts = array() ) {
		if ( '' !== $html || empty( $atts['dplayer'] ) || empty( $atts['src'] ) ) return $html;

		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) return $html;

		$atts = shortcode_atts(
			array(
				'autoplay'       => 'false',
				'theme'          => '#b7daff',
				'loop'           => 'false',
				'preload'        => 'auto',
				'src'            => '',
				'poster'         => '',
				'type'           => 'auto',
				'mutex'          => 'true',
				'iconsColor'     => '#ffffff',
			), $atts, 'video' );

		( $atts['loop'] == 'true' || $atts['loop'] == 'on' || $atts['loop'] == '1' ) And $atts['loop'] = 'true' Or $atts['loop'] = 'false';
		( $atts['autoplay'] == 'true' || $atts['autoplay'] == 'on' || $atts['autoplay'] == '1' ) And $atts['autoplay'] = 'true' Or $atts['autoplay'] = 'false';

		$video_attr_strings = array();
		foreach ( $atts as $k => $v ) {
			if ( $v == '' ) continue;
			$video_attr_strings[] = $k . '="' . esc_attr( $v ) . '"';
		}

		$html .= sprintf( '[dplayer %s]', join( ' ', $video_attr_strings ) );

		return do_shortcode( $html );
	}
}

