<?php
/**
 * Navbar Component.
 *
 * @package Navbar component
 */
if ( isset( $data ) && count( $data ) ) : ?>
	<div class="tutor-wp-dashboard-header tutor-px-24 tutor-mb-24">
		<div class="tutor-row tutor-align-lg-center">
			<div class="tutor-col-lg">
				<div class="tutor-d-lg-flex tutor-align-lg-center tutor-px-12 tutor-py-16">
					<span class="tutor-fs-5 tutor-fw-medium tutor-mr-16">
						<?php echo esc_html( $data['page_title'] ); ?>
					</span>
					
					<?php
					// If modal target set then button will be set as modal button otherwise url button.
					if ( isset( $data['modal_target'] ) && '' !== $data['modal_target'] ) :
						?>
						<?php if ( isset( $data['add_button'] ) && $data['add_button'] ) : ?>
							<button class="tutor-btn tutor-btn-outline-primary tutor-btn-md" data-tutor-modal-target="<?php echo esc_html( $data['modal_target'] ); ?>">
								<span class="tutor-icon-plus-o tutor-mr-8"></span>
								<span><?php echo esc_html( $data['button_title'] ); ?></span>
							</button>
						<?php endif; ?>
					<?php else : ?>
						<?php if ( isset( $data['add_button'] ) && $data['add_button'] ) : ?>
							<a href="<?php echo esc_url( $data['button_url'] ); ?>" class="tutor-btn tutor-btn-outline-primary tutor-btn-md">
								<span class="tutor-icon-plus-o tutor-mr-8"></span>
								<span><?php echo esc_html( $data['button_title'] ); ?></span>
							</a>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>

			<div class="tutor-col-lg-auto">
				<?php if ( isset( $data['tabs'] ) ) : ?>
					<ul class="tutor-nav tutor-nav-admin" tutor-priority-nav>
						<?php foreach ( $data['tabs'] as $key => $v ) : ?>
							<li class="tutor-nav-item">
								<a class="tutor-nav-link<?php echo esc_attr( $data['active'] == $v['key'] ? ' is-active' : '' ); ?>" data-keypage="<?php echo isset( $v['key'] ) ? esc_attr( $v['key'] ) : ''; ?>" data-keyvalue="<?php echo isset( $v['value'] ) ? esc_attr( $v['value'] ) : ''; ?>" href="<?php echo esc_attr( $v['url'] ); ?>">
									<span><?php echo isset( $v['title'] ) ? esc_html( $v['title'] ) : ''; ?></span>
									<?php if ( isset( $v['value'] ) ) : ?>
										<span class="tutor-ml-4">
											(<?php echo isset( $v['value'] ) ? esc_attr( $v['value'] ) : ''; ?>)
										</span>
									<?php endif; ?>
								</a>
							</li>
						<?php endforeach; ?>
						<li class="tutor-nav-item tutor-nav-more tutor-d-none">
							<a class="tutor-nav-link tutor-nav-more-link" href="#"><span class="tutor-mr-4"><?php _e("More", "tutor"); ?></span> <span class="tutor-nav-more-icon tutor-icon-times"></span></a>
							<ul class="tutor-nav-more-list tutor-dropdown"></ul>
						</li>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>
