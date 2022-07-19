<?php
/**
 * Template for displaying header of single course popup.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/header.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.3
 */

defined( 'ABSPATH' ) || exit();

if ( ! isset( $course ) || ! isset( $user ) || ! isset( $percentage ) ||
	! isset( $completed_items ) || ! isset( $total_items ) ) {
	return;
}
?>

<div id="popup-header">
	<div class="popup-header__inner">
		<h2 class="course-title">
			<a href="<?php echo esc_url( $course->get_permalink() ); ?>"><?php echo $course->get_title(); ?></a>
		</h2>

		<?php if ( $user->has_enrolled_or_finished( $course->get_id() ) ) : ?>
			<div class="items-progress" data-total-items="<?php echo $total_items; ?>">
				<span class="number">
					<?php echo wp_sprintf( '<span class="items-completed">%1$s</span> of %2$d %3$s', esc_html( $completed_items ), esc_html( $course->count_items() ), __( 'items', 'learnpress' ) ); ?>
				</span>
				<div class="learn-press-progress">
					<div class="learn-press-progress__active" data-value="<?php echo $percentage; ?>%;">
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<a href="<?php echo $course->get_permalink(); ?>" class="back-course"><i class="fa fa-times"></i></a>
</div>
