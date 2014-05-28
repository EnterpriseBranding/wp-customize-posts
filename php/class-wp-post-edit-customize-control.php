<?php

/**
 * Post Selection Customize Control Class
 *
 * @package WordPress
 * @subpackage Customize
 */
class WP_Post_Edit_Customize_Control extends WP_Customize_Control {

	/**
	 * @access public
	 * @var string
	 */
	public $type = 'post_edit';

	/**
	 * Constructor.
	 *
	 * @uses WP_Customize_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string $id
	 * @param array $args
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Render the control's content.
	 */
	public function render_content() {
		?>

		<?php
	}

	/**
	 * @todo Use these Mustache templates in php as well?
	 */
	static function render_templates() {
		?>
		<script id="tmpl-customize-posts-meta-field" type="text/html">
			<dt>
				<input type="text" class="meta-key" value="{{ data.key }}">
			</dt>
			<dd>
				<ul class="meta-value-list" data-tmpl="customize-posts-meta-field-value">
					<# _.each( data.values, function ( value, i ) { #>
						{{{
							wp.template( 'customize-posts-meta-field-value' )( {
								post_id: data.post_id,
								key: data.key,
								value: value,
								i: i
							} )
						}}}
					<#  } ); #>
				</ul>
				<button type="button" class="add add-meta-value button button-secondary"><?php esc_html_e( 'Add value', 'customize-posts' ) ?></button>
			</dd>
		</script>

		<script id="tmpl-customize-posts-meta-field-value" type="text/html">
			<?php
			$id = 'posts[{{ data.post_id }}][meta][{{ data.key }}][{{ data.i }}]';
			?>
			<li class="meta-value-item">
				<button type="button" class="delete-meta button button-secondary" title="<?php esc_attr_e( 'Delete meta value', 'customize-posts' ) ?>"><?php _e( '&times;', 'customize-posts' ) ?></button>
				<textarea class="meta-value" id="<?php echo esc_attr( $id ) ?>" name="<?php echo esc_attr( $id ) ?>">{{ data.value }}</textarea>
			</li>
		</script>
		<?php
	}


	/**
	 * @param int|WP_Post $post
	 * @return string
	 */
	static function get_control_fields( $post ) {
		$post = get_post( $post );
		$post_type_obj = get_post_type_object( $post->post_type );

		ob_start();
		?>
		<span class="customize-control-title">
			<?php esc_html_e( 'Edit Post', 'customize-posts' ); ?>
		</span>
		<div class="customize-control-content">
			<p>
				<?php $id = "posts[$post->ID][post_parent]"; ?>
				<label for="<?php echo esc_attr( $id ) ?>"><?php esc_html_e( 'Title:' ) ?></label>
				<input type="text" class="post-data post_title" id="<?php echo esc_attr( $id ) ?>" name="<?php echo esc_attr( $id ) ?>" value="<?php echo esc_attr( $post->post_title ) ?>" >
			</p>
			<p>
				<?php $id = "posts[$post->ID][post_parent]"; ?>
				<label for="<?php echo esc_attr( $id ) ?>"><?php esc_html_e( 'Slug:' ) ?></label>
				<input type="text" class="post-data post_name" id="<?php echo esc_attr( $id ) ?>" name="<?php echo esc_attr( $id ) ?>" value="<?php echo esc_attr( $post->post_name ) ?>" >
			</p>
			<p>
				<?php $id = "posts[$post->ID][post_parent]"; ?>
				<label for="posts[<?php echo esc_attr( $post->ID ) ?>][post_author]"><?php esc_html_e( 'Author:' ) ?></label>
				<?php wp_dropdown_users( array( 'name' => $id, 'class' => 'post-data post_author' ) ); ?>
			</p>
			<p>
				<?php $id = "posts[$post->ID][post_parent]"; ?>
				<?php $label = sprintf( 'Published: (%s)', get_option( 'timezone_string' ) ?: 'UTC' . get_option( 'gmt_offset' ) ); ?>
				<label for="<?php echo esc_attr( $id ) ?>"><?php echo esc_html( $label ) ?></label>
				<input type="text" class="post-data post_date" pattern="\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d" id="<?php echo esc_attr( $id ) ?>" name="<?php echo esc_attr( $id ) ?>" value="<?php echo esc_attr( $post->post_date ) ?>" >
			</p>
			<p>
				<?php $id = "posts[$post->ID][post_parent]"; ?>
				<label for="<?php echo esc_attr( $id ) ?>"><?php esc_html_e( 'Content:' ) ?></label>
				<textarea class="post-data post_content" id="<?php echo esc_attr( $id ) ?>" name="<?php echo esc_attr( $id ) ?>"><?php echo esc_textarea( $post->post_content ) ?></textarea>
			</p>
			<p>
				<?php $id = "posts[$post->ID][post_parent]"; ?>
				<label for="<?php echo esc_attr( $id ) ?>"><?php esc_html_e( 'Excerpt:' ) ?></label>
				<textarea class="post-data post_excerpt" id="<?php echo esc_attr( $id ) ?>" name="<?php echo esc_attr( $id ) ?>"><?php echo esc_textarea( $post->post_excerpt ) ?></textarea>
			</p>
			<p>
				<?php $id = "posts[$post->ID][post_parent]"; ?>
				<label for="<?php echo esc_attr( $id ) ?>"><?php esc_html_e( 'Status:' ) ?></label>
				<select class="post-data post_status" id="<?php echo esc_attr( $id ) ?>" name="<?php echo esc_attr( $id ) ?>">
					<?php foreach ( get_post_stati( array( 'internal' => false ) ) as $post_status ): ?>
						<option value='<?php echo esc_attr( $post_status ) ?>'><?php echo esc_html( get_post_status_object( $post_status )->label ) ?></option>
					<?php endforeach; ?>
				</select>
			</p>

			<p>
				<?php $id = "posts[$post->ID][post_parent]"; ?>
				<label for="<?php echo esc_attr( $id ) ?>"><?php esc_html_e( 'Comment:' ) ?></label>
				<select class="post-data comment_status" id="<?php echo esc_attr( $id ) ?>" name="<?php echo esc_attr( $id ) ?>">
					<option value="open"><?php esc_html_e( 'Open' ); ?>
					<option value="closed"><?php esc_html_e( 'Closed' ); ?>
				</select>
			</p>

			<?php if ( is_post_type_hierarchical( $post->post_type ) ): ?>
				<p>
					<?php $id = "posts[$post->ID][post_parent]"; ?>
					<label for="<?php echo esc_attr( $id ) ?>"><?php esc_html_e( 'Parent:' ) ?></label>
					TODO
				</p>
				<p>
					<?php $id = "posts[$post->ID][post_parent]"; ?>
					<label for="<?php echo esc_attr( $id ) ?>"><?php esc_html_e( 'Menu order:' ) ?></label>
					<input type="number" class="post-data menu_order" id="<?php echo esc_attr( $id ) ?>" name="<?php echo esc_attr( $id ) ?>" value="<?php echo esc_attr( $post->menu_order ) ?>" >
				</p>
			<?php endif; ?>

			<?php if ( 'page' === $post->post_type ): ?>
				<p>
					<?php $id = 'posts[{{ data.post_id }}][meta][_page_template][0]'; ?>
					<label for="<?php echo esc_attr( $id ) ?>"><?php esc_html_e( 'Page template:' ) ?></label>
					<input type="text" class="meta-value" id="<?php echo esc_attr( $id ) ?>" name="<?php echo esc_attr( $id ) ?>" value="{{ data.meta._wp_page_template ? data.meta._wp_page_template[0] : '' }}" >
				</p>
			<?php endif; ?>

			<?php if ( current_user_can( 'edit_post_meta', $post->ID ) ): ?>
				<section class="post-meta">
					<h3><?php esc_html_e( 'Meta', 'customize-posts' ) ?></h3>
					<dl class="post-meta" data-tmpl="customize-posts-meta-field">
						<?php foreach ( get_post_custom( $post->ID ) as $meta_key => $meta_values ): ?>
							<dt>
								<input type="text" class="meta-key" value="<?php echo esc_attr( $meta_key ) ?>">
							</dt>
							<dd>
								<ul class="meta-value-list" data-tmpl="customize-posts-meta-field-value">
									<?php foreach ( $meta_values as $i => $meta_value ): ?>
										<?php $id = "posts[$post->ID][meta][$meta_key][$i]"; ?>
										<li class="meta-value-item">
											<button type="button" class="delete-meta button button-secondary" title="<?php esc_attr_e( 'Delete meta value', 'customize-posts' ) ?>"><?php _e( '&times;', 'customize-posts' ) ?></button>
											<textarea class="meta-value" id="<?php echo esc_attr( $id ) ?>" name="<?php echo esc_attr( $id ) ?>"><?php echo esc_textarea( $meta_value ) ?></textarea>
										</li>
									<?php endforeach; ?>
								</ul>
								<button type="button" class="add add-meta-value button button-secondary"><?php esc_html_e( 'Add value', 'customize-posts' ) ?></button>
							</dd>
						<?php endforeach; ?>
					</dl>
					<p>
						<button type="button" class="add add-meta button button-secondary"><?php esc_html_e( 'Add meta', 'customize-posts' ) ?></button>
					</p>
				</section>
			<?php endif; ?>
		</div>
		<?php

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}