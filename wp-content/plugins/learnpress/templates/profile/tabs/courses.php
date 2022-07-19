<?php
/**
 * Template for displaying courses tab in user profile page.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/tabs/courses.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.10
 */

defined( 'ABSPATH' ) || exit();

if ( ! isset( $user ) || ! isset( $tab_active ) || ! isset( $courses_enrolled_tab ) ||
	! isset( $courses_created_tab ) || ! isset( $courses_enrolled_tab_active ) ||
	! isset( $args_query_user_courses_attend ) || ! isset( $args_query_user_courses_created ) ||
	! isset( $args_query_user_courses_statistic ) ) {
	return;
}
?>

<div class="learn-press-subtab-content">
	<div class="learn-press-profile-course__statistic">
		<?php lp_skeleton_animation_html( 4, 'random', 'height: 30px;border-radius:4px;' ); ?>
		<input type="hidden" name="args_query_user_courses_statistic"
			value="<?php echo htmlentities( wp_json_encode( $args_query_user_courses_statistic ) ); ?>">
	</div>

	<div class="learn-press-profile-course__tab">
		<ul class="learn-press-profile-course__tab__inner">
			<li>
				<a class="<?php echo $tab_active === 'enrolled' ? 'active' : ''; ?>" data-tab="enrolled">
					<?php esc_html_e( 'Enrolled', 'learnpress' ); ?>
				</a>
			</li>

			<?php if ( $user->can_create_course() ) : ?>
				<li>
					<a class="<?php echo $tab_active === 'created' ? 'active' : ''; ?>" data-tab="created">
						<?php esc_html_e( 'Created', 'learnpress' ); ?>
					</a>
				</li>
			<?php endif; ?>
		</ul>

		<div class="learn-press-course-tab-enrolled learn-press-course-tab-filters" data-tab="enrolled"
			style="<?php echo $tab_active !== 'enrolled' ? 'display: none;' : ''; ?>">
			<ul class="learn-press-filters">
				<?php foreach ( $courses_enrolled_tab as $key => $enrolled ) : ?>
					<li>
						<a class="<?php echo $key === $courses_enrolled_tab_active ? 'active' : ''; ?>"
							data-tab="<?php echo $key === '' ? 'all' : $key; ?>">
							<?php echo esc_html( $enrolled ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>

			<div class="learn-press-profile-course__progress">
				<?php foreach ( $courses_enrolled_tab as $key => $enrolled ) : ?>
					<div class="learn-press-course-tab__filter__content"
						data-tab="<?php echo $key === '' ? 'all' : $key; ?>"
						style="<?php echo $key !== $courses_enrolled_tab_active ? 'display: none' : ''; ?>"> <?php // phpcs:ignore ?>
						<?php lp_skeleton_animation_html( 4, 'random', 'height: 30px;border-radius:4px;' ); ?>
					</div>
				<?php endforeach; ?>
				<input class="lp_profile_tab_input_param" type="hidden" name="args_query_user_courses_attend"
					value="<?php echo htmlentities( wp_json_encode( $args_query_user_courses_attend ) ); ?>">
			</div>
		</div>

		<?php if ( learn_press_user_maybe_is_a_teacher() ) : ?>
			<div class="learn-press-course-tab-created learn-press-course-tab-filters" data-tab="created"
				style="<?php echo $tab_active !== 'created' ? 'display: none;' : ''; ?>">
				<ul class="learn-press-filters">
					<?php foreach ( $courses_created_tab as $key => $created ) : ?>
						<li>
							<a class="<?php echo $key === '' ? 'active' : ''; ?>"
								data-tab="<?php echo $key === '' ? 'all' : $key; ?>">
								<?php echo esc_html( $created ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>

				<div class="learn-press-profile-course__progress">
					<?php foreach ( $courses_created_tab as $key => $created ) : ?>
						<div class="learn-press-course-tab__filter__content"
							data-tab="<?php echo $key === '' ? 'all' : $key; ?>" style="<?php echo $key !== '' ? 'display: none' : ''; ?>"> <?php // phpcs:ignore ?>
							<?php lp_skeleton_animation_html( 4, 'random', 'height: 30px;border-radius:4px;' ); ?>
						</div>
					<?php endforeach; ?>
					<input class="lp_profile_tab_input_param" type="hidden" name="args_query_user_courses_created"
						value="<?php echo htmlentities( wp_json_encode( $args_query_user_courses_created ) ); ?>">
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
