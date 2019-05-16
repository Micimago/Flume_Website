<?php
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// single event
function vsel_single_content( $content ) {
	// include event variables
	include 'vsel-variables.php';

	if ( is_singular('event') && in_the_loop() && ( $page_disable_single_template != 'yes' ) ) {
		// error in case of missing date or when event start date is greater than event end date
		if ( empty($page_start_date) || empty($page_end_date) || ($page_start_date > $page_end_date) ) {
			$date .= '<p class="vsel-meta-date vsel-meta-error-date">' . esc_attr__( 'Error: please reset date', 'very-simple-event-list' ) . '</p>';
		} elseif ($page_end_date > $page_start_date) {
			if ($page_date_combine == "yes") {
				$date .= '<p class="vsel-meta-date vsel-meta-combined-date">';
				$date .= sprintf(esc_attr($page_start_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_start_date) ).'</span>' );
				$date .= $sep;
				$date .= sprintf(esc_attr($page_end_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_end_date) ).'</span>' );
				$date .= '</p>';
			} else {
				$date .= '<p class="vsel-meta-date vsel-meta-start-date">';
				$date .= sprintf(esc_attr($page_start_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_start_date) ).'</span>' );
				$date .= '</p>';
				$date .= '<p class="vsel-meta-date vsel-meta-end-date">';
				$date .= sprintf(esc_attr($page_end_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_end_date) ).'</span>' );
				$date .= '</p>';
			}
		} elseif ($page_end_date == $page_start_date) {
			$date .= '<p class="vsel-meta-date vsel-meta-page-date">';
			$date .= sprintf(esc_attr($page_date_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_end_date) ).'</span>' );
			$date .= '</p>';
		}
		if(!empty($page_time)) {
			$time .= '<p class="vsel-meta-time">';
			$time .= sprintf(esc_attr($page_time_label), '<span>'.esc_attr($page_time).'</span>' );
			$time .= '</p>';
		}
		if(!empty($page_location)) {
			$location .= '<p class="vsel-meta-location">';
			$location .= sprintf(esc_attr($page_location_label), '<span>'.esc_attr($page_location).'</span>' );
			$location .= '</p>';
		}
		if(!empty($page_link)) {
			$link .= '<p class="vsel-meta-link">';
			$link .= sprintf( '<a href="%1$s"'. $page_link_target .'>%2$s</a>', esc_url($page_link), esc_attr($page_link_label) );
			$link .= '</p>';
		}
		$cats_raw = wp_strip_all_tags( get_the_term_list( get_the_ID(), 'event_cat', '<span>', ' | ', '</span>' ) );
		$cats = get_the_term_list( get_the_ID(), 'event_cat', '<span>', ' | ', '</span>' );
		if( has_term( '', 'event_cat', get_the_ID() ) ) {
			if ($page_link_cat != 'yes') {
				$categories .= '<p class="vsel-meta-cats">'.$cats_raw.'</p>';
			} else {	
				$categories .= '<p class="vsel-meta-cats">'.$cats.'</p>';
			}
		}
		$content = '<div id="vsel">' . '<div class="'.$page_meta_class.'">' . $date . $time . $location . $link . $categories . '</div>' . '<div class="'.$page_image_info_class.'">' . $content . '</div>' . '</div>';
  	} 
	return $content;
}
add_filter( 'the_content', 'vsel_single_content' );

// category, post type and search results page
function vsel_archive_content( $content ) {
	global $post_type;
	// include event variables
	include 'vsel-variables.php';

	if ( ( is_tax('event_cat') && in_the_loop() && ( $page_disable_category_template != 'yes' ) ) || ( is_post_type_archive('event') && ! is_search() && in_the_loop() && ( $page_disable_post_type_template != 'yes' ) ) || ( ( $post_type == 'event' ) && is_search() && in_the_loop() && ( $page_disable_search_template != 'yes' ) ) ) {
		// get event content
		$vsel_event_data = get_post( get_the_ID() );
		$vsel_event_content = wpautop( wp_kses_post( $vsel_event_data->post_content ) );
		if ( ($page_date_hide != 'yes') ) {
			// error in case of missing date or when event start date is greater than event end date
			if ( empty($page_start_date) || empty($page_end_date) || ($page_start_date > $page_end_date) ) {
				$date .= '<p class="vsel-meta-date vsel-meta-error-date">' . esc_attr__( 'Error: please reset date', 'very-simple-event-list' ) . '</p>';
			} elseif ($page_end_date > $page_start_date) {
				if ($page_date_combine == "yes") {
					$date .= '<p class="vsel-meta-date vsel-meta-combined-date">';
					$date .= sprintf(esc_attr($page_start_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_start_date) ).'</span>' );
					$date .= $sep;
					$date .= sprintf(esc_attr($page_end_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_end_date) ).'</span>' );
					$date .= '</p>';
				} else {
					$date .= '<p class="vsel-meta-date vsel-meta-start-date">';
					$date .= sprintf(esc_attr($page_start_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_start_date) ).'</span>' );
					$date .= '</p>';
					$date .= '<p class="vsel-meta-date vsel-meta-end-date">';
					$date .= sprintf(esc_attr($page_end_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_end_date) ).'</span>' );
					$date .= '</p>';
				}
			} elseif ($page_end_date == $page_start_date) {
				$date .= '<p class="vsel-meta-date vsel-meta-page-date">';
				$date .= sprintf(esc_attr($page_date_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_end_date) ).'</span>' );
				$date .= '</p>';
			}
		}
		if ( ($page_time_hide != 'yes') ) {
			if(!empty($page_time)) {
				$time .= '<p class="vsel-meta-time">';
				$time .= sprintf(esc_attr($page_time_label), '<span>'.esc_attr($page_time).'</span>' );
				$date .= '</p>';
			}
		}
		if ( ($page_location_hide != 'yes') ) {
			if(!empty($page_location)) {
				$location .= '<p class="vsel-meta-location">';
				$location .= sprintf(esc_attr($page_location_label), '<span>'.esc_attr($page_location).'</span>' );
				$location .= '</p>';
			}
		}
		if ( ($page_link_hide != 'yes') ) {
			if(!empty($page_link)) {
				$link .= '<p class="vsel-meta-link">';
				$link .= sprintf( '<a href="%1$s"'. $page_link_target .'>%2$s</a>', esc_url($page_link), esc_attr($page_link_label) );
				$link .= '</p>';
			}
		}
		if ( ($page_cats_hide != 'yes') ) {
			$cats_raw = wp_strip_all_tags( get_the_term_list( get_the_ID(), 'event_cat', '<span>', ' | ', '</span>' ) );
			$cats = get_the_term_list( get_the_ID(), 'event_cat', '<span>', ' | ', '</span>' );
			if( has_term( '', 'event_cat', get_the_ID() ) ) {
				if ($page_link_cat != 'yes') {
					$categories .= '<p class="vsel-meta-cats">'.$cats_raw.'</p>';
				} else {	
					$categories .= '<p class="vsel-meta-cats">'.$cats.'</p>';
				}
			}
		}
		if ( ($page_image_hide != 'yes') ) {
			if ( has_post_thumbnail() ) {
				if ($page_link_image != 'yes') {
					$image .= get_the_post_thumbnail( null, $page_image_source, array('class' => ''.$page_img_class.'', 'alt' => ''. get_the_title() .'') );
				} else {
					$image .=  '<a href="'. get_permalink() .'">'. get_the_post_thumbnail( null, $page_image_source, array('class' => ''.$page_img_class.'', 'title' => ''. get_the_title() .'', 'alt' => ''. get_the_title() .'') ) .'</a>';
				}
			}
		}
		if ( $page_info_hide != 'yes') {
			$info .= '<div class="vsel-info">';
			$info .= $vsel_event_content;
			$info .= '</div>';
		}
		$content = '<div id="vsel">' . $page_meta_section_start . $date . $time . $location . $link . $categories . $page_meta_section_end . $page_image_info_section_start . $image . $info . $page_image_info_section_end . '</div>';
	}
	return $content;
}
add_filter( 'the_content', 'vsel_archive_content' );

function vsel_archive_excerpt( $excerpt ) {
	global $post_type;
	// include event variables
	include 'vsel-variables.php';

	if ( ( is_tax('event_cat') && in_the_loop() && ( $page_disable_category_template != 'yes' ) ) || ( is_post_type_archive('event') && ! is_search() && in_the_loop() && ( $page_disable_post_type_template != 'yes' ) ) || ( ( $post_type == 'event' ) && is_search() && in_the_loop() && ( $page_disable_search_template != 'yes' ) ) ) {
		// get event summary and content to create excerpt
		$vsel_event_data = get_post( get_the_ID() );
		$vsel_event_content = $vsel_event_data->post_content;
		if ( !empty( $page_summary ) ) {
			$vsel_event_summary = wpautop( wp_kses_post( $page_summary ) );
		} else {
			$vsel_event_summary = wp_trim_words( $vsel_event_content, 55, ' [&hellip;] ');
		}
		if ( ($page_date_hide != 'yes') ) {
			// error in case of missing date or when event start date is greater than event end date
			if ( empty($page_start_date) || empty($page_end_date) || ($page_start_date > $page_end_date) ) {
				$date .= '<p class="vsel-meta-date vsel-meta-error-date">' . esc_attr__( 'Error: please reset date', 'very-simple-event-list' ) . '</p>';
			} elseif ($page_end_date > $page_start_date) {
				if ($page_date_combine == "yes") {
					$date .= '<p class="vsel-meta-date vsel-meta-combined-date">';
					$date .= sprintf(esc_attr($page_start_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_start_date) ).'</span>' );
					$date .= $sep;
					$date .= sprintf(esc_attr($page_end_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_end_date) ).'</span>' );
					$date .= '</p>';
				} else {
					$date .= '<p class="vsel-meta-date vsel-meta-start-date">';
					$date .= sprintf(esc_attr($page_start_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_start_date) ).'</span>' );
					$date .= '</p>';
					$date .= '<p class="vsel-meta-date vsel-meta-end-date">';
					$date .= sprintf(esc_attr($page_end_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_end_date) ).'</span>' );
					$date .= '</p>';
				}
			} elseif ($page_end_date == $page_start_date) {
				$date .= '<p class="vsel-meta-date vsel-meta-page-date">';
				$date .= sprintf(esc_attr($page_date_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($page_end_date) ).'</span>' );
				$date .= '</p>';
			}
		}
		if ( ($page_time_hide != 'yes') ) {
			if(!empty($page_time)) {
				$time .= '<p class="vsel-meta-time">';
				$time .= sprintf(esc_attr($page_time_label), '<span>'.esc_attr($page_time).'</span>' );
				$date .= '</p>';
			}
		}
		if ( ($page_location_hide != 'yes') ) {
			if(!empty($page_location)) {
				$location .= '<p class="vsel-meta-location">';
				$location .= sprintf(esc_attr($page_location_label), '<span>'.esc_attr($page_location).'</span>' );
				$location .= '</p>';
			}
		}
		if ( ($page_link_hide != 'yes') ) {
			if(!empty($page_link)) {
				$link .= '<p class="vsel-meta-link">';
				$link .= sprintf( '<a href="%1$s"'. $page_link_target .'>%2$s</a>', esc_url($page_link), esc_attr($page_link_label) );
				$link .= '</p>';
			}
		}
		if ( ($page_cats_hide != 'yes') ) {
			$cats_raw = wp_strip_all_tags( get_the_term_list( get_the_ID(), 'event_cat', '<span>', ' | ', '</span>' ) );
			$cats = get_the_term_list( get_the_ID(), 'event_cat', '<span>', ' | ', '</span>' );
			if( has_term( '', 'event_cat', get_the_ID() ) ) {
				if ($page_link_cat != 'yes') {
					$categories .= '<p class="vsel-meta-cats">'.$cats_raw.'</p>';
				} else {	
					$categories .= '<p class="vsel-meta-cats">'.$cats.'</p>';
				}
			}
		}
		if ( ($page_image_hide != 'yes') ) {
			if ( has_post_thumbnail() ) {
				if ($page_link_image != 'yes') {
					$image .= get_the_post_thumbnail( null, $page_image_source, array('class' => ''.$page_img_class.'', 'alt' => ''. get_the_title() .'') );
				} else {
					$image .=  '<a href="'. get_permalink() .'">'. get_the_post_thumbnail( null, $page_image_source, array('class' => ''.$page_img_class.'', 'title' => ''. get_the_title() .'', 'alt' => ''. get_the_title() .'') ) .'</a>';
				}
			}
		}
		if ( $page_info_hide != 'yes') {
			$info .= '<div class="vsel-info">';
			$info .= $vsel_event_summary;
			$info .= '</div>';
		}
		$excerpt = '<div id="vsel">' . $page_meta_section_start . $date . $time . $location . $link . $categories . $page_meta_section_end . $page_image_info_section_start . $image . $info . $page_image_info_section_end . '</div>';
	}
	return $excerpt;
}
add_filter( 'the_excerpt', 'vsel_archive_excerpt' );
