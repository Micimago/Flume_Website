<?php
// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// display the event list
$output .= '<div id="event-'.get_the_ID().'" class="vsel-content '.vsel_event_cats().vsel_event_status().'">';
	$output .= '<div class="vsel-meta">';
		if ($widget_link_title != 'yes') {
			$output .= '<h3 class="vsel-meta-title">' . get_the_title() . '</h3>';
		} else {
			$output .=  '<h3 class="vsel-meta-title"><a href="'. get_permalink() .'" rel="bookmark" title="'. get_the_title() .'">'. get_the_title() .'</a></h3>';
		}
		if ( ($widget_date_hide != 'yes') ) {
			// error in case of missing date or when event start date is greater than event end date
			if ( empty($widget_start_date) || empty($widget_end_date) || ($widget_start_date > $widget_end_date) ) {
				$output .= '<p class="vsel-meta-date vsel-meta-error-date">';
				$output .= esc_attr__( 'Error: please reset date', 'very-simple-event-list' );
				$output .= '</p>';
			} elseif ($widget_end_date > $widget_start_date) {
				if ($widget_date_combine == "yes") {
					$output .= '<p class="vsel-meta-date vsel-meta-combined-date">';
					$output .= sprintf(esc_attr($widget_start_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($widget_start_date) ).'</span>' );
					$output .= $sep;
					$output .= sprintf(esc_attr($widget_end_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($widget_end_date) ).'</span>' );
					$output .= '</p>';
				} else {
					$output .= '<p class="vsel-meta-date vsel-meta-start-date">';
					$output .= sprintf(esc_attr($widget_start_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($widget_start_date) ).'</span>' );
					$output .= '</p>';
					$output .= '<p class="vsel-meta-date vsel-meta-end-date">';
					$output .= sprintf(esc_attr($widget_end_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($widget_end_date) ).'</span>' );
					$output .= '</p>';
				}
			} elseif ($widget_end_date == $widget_start_date) {
				$output .= '<p class="vsel-meta-date vsel-meta-single-date">';
				$output .= sprintf(esc_attr($widget_date_label), '<span>'.date_i18n( esc_attr($date_format), esc_attr($widget_end_date) ).'</span>' );
				$output .= '</p>';
			}
		}
		if ($widget_time_hide != 'yes') {
			if (!empty($widget_time)){
				$output .= '<p class="vsel-meta-time">';
				$output .= sprintf(esc_attr($widget_time_label), '<span>'.esc_attr($widget_time).'</span>' );
				$output .= '</p>';
			}
		}
		if ($widget_location_hide != 'yes') {
			if (!empty($widget_location)){
				$output .= '<p class="vsel-meta-location">';
				$output .= sprintf(esc_attr($widget_location_label), '<span>'.esc_attr($widget_location).'</span>' );
				$output .= '</p>';
			}
		}
		if ($widget_link_hide != 'yes') {
			if (!empty($widget_link)){
				$output .= '<p class="vsel-meta-link">';
				$output .= sprintf( '<a href="%1$s"'. $widget_link_target .'>%2$s</a>', esc_url($widget_link), esc_attr($widget_link_label) );
				$output .= '</p>';
			}
		}
		if ( ($widget_cats_hide != 'yes') ) {
			$cats_raw = wp_strip_all_tags( get_the_term_list( get_the_ID(), 'event_cat', '<span>', ' | ', '</span>' ) );
			$cats = get_the_term_list( get_the_ID(), 'event_cat', '<span>', ' | ', '</span>' );
			if( has_term( '', 'event_cat', get_the_ID() ) ) {
				if ($widget_link_cat != 'yes') {
					$output .= '<p class="vsel-meta-cats">';
					$output .= $cats_raw;
					$output .= '</p>';
				} else {	
					$output .= '<p class="vsel-meta-cats">';
					$output .= $cats;
					$output .= '</p>';
				}
			}
		}
	$output .= '</div>';
	if ( ($widget_image_hide == 'yes') && ($widget_info_hide == 'yes') ) {
		$output .= '';
	} else {
		$output .= '<div class="vsel-image-info">';
			if ($widget_image_hide != 'yes') {
				if ( has_post_thumbnail() ) {
					if ($widget_link_image != 'yes') {
						$output .= get_the_post_thumbnail( null, $widget_image_source, array('class' => ''.$widget_img_class.'', 'alt' => ''. get_the_title() .'') );
					} else {
						$output .=  '<a href="'. get_permalink() .'">'. get_the_post_thumbnail( null, $widget_image_source, array('class' => ''.$widget_img_class.'', 'title' => ''. get_the_title() .'', 'alt' => ''. get_the_title() .'') ) .'</a>';
					}
				}
			}
			if ($widget_info_hide != 'yes') {
				$output .= '<div class="vsel-info">';
					if ($widget_excerpt != 'yes') {
						$output .= apply_filters( 'the_content', get_the_content() );
					} elseif (!empty($widget_summary)) {
						$output .= apply_filters( 'the_excerpt', $widget_summary );
					}  else {
						$output .= apply_filters( 'the_excerpt', get_the_excerpt() );
					}
				$output .= '</div>';
			}
		$output .= '</div>';
	}
$output .= '</div>';
