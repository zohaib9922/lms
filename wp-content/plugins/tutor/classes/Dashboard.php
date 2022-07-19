<?php
/**
 * Dashboard class
 *
 * @author: themeum
 * @author_uri: https://themeum.com
 * @package Tutor
 * @since v.1.3.4
 */

namespace TUTOR;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class Dashboard {

	public function __construct() {
		add_action( 'tutor_load_template_before', array( $this, 'tutor_load_template_before' ), 10, 2 );
		add_action( 'tutor_load_template_after', array( $this, 'tutor_load_template_after' ), 10, 2 );
		add_filter( 'should_tutor_load_template', array( $this, 'should_tutor_load_template' ), 10, 2 );
		add_action( 'wp_ajax_tutor_create_new_draft_course', array( __CLASS__, 'create_new_draft_course') );
	}

	/**
	 * @param $template
	 * @param $variables
	 */
	public function tutor_load_template_before( $template, $variables ) {
		global $wp_query;

		$tutor_dashboard_page = tutor_utils()->array_get( 'query_vars.tutor_dashboard_page', $wp_query );
		if ( $tutor_dashboard_page === 'create-course' ) {
			global $post;
			wp_reset_query();

			/**
			 * Get course which currently in edit if not then redirect to dashboard
			 * page to create new one.
			 */
			$course_ID = (int) sanitize_text_field( tutor_utils()->array_get( 'course_ID', $_GET ) );
			if ( ! $course_ID ) {
				$template = trailingslashit( tutor()->path ) . 'templates/permission-denied.php';
				tutor_load_template_from_custom_path(
					$template	
				);
			} else {
				$post = get_post( $course_ID );
				setup_postdata( $post );
			}
		}
	}

	public function tutor_load_template_after() {
		global $wp_query;

		$tutor_dashboard_page = tutor_utils()->array_get( 'query_vars.tutor_dashboard_page', $wp_query );
		if ( $tutor_dashboard_page === 'create-course' ) {
			wp_reset_query();
		}
	}

	public function should_tutor_load_template( $bool, $template ) {
		if ( $template === 'dashboard.create-course' && ! tutor()->has_pro ) {
			return false;
		}
		return $bool;
	}

	/**
	 * Create new draft course
	 *
	 * @since v2.0.3
	 *
	 * @return void  send JSON response
	 */
	public static function create_new_draft_course() {
		$can_publish_course = (bool) current_user_can( 'tutor_instructor' ) || current_user_can('administrator');
		tutor_utils()->checking_nonce();
		if ( $can_publish_course ) {
			$post_type = tutor()->course_post_type;
			$course_id   = wp_insert_post(
				array(
					'post_title'  => __( 'New Course', 'tutor' ),
					'post_type'   => $post_type,
					'post_status' => 'draft',
				)
			);
			if ( $course_id ) {
				$response = array(
					'course_id' => $course_id,
					'url'		=> add_query_arg(
						array(
							'course_ID' => $course_id
						),
						tutor_utils()->tutor_dashboard_url( 'create-course' )
					)
				);
				wp_send_json_success($response);
			} else {
				wp_send_json_error();
			}
		} else {
			$response = array(
				'error_message' => __( 'You are not allowed to publish course', 'tutor' )
			);
			wp_send_json_error( $response );
		}
	}
}
