<?php
/**
 * The template for displaying meta box in page/post
 *
 * This adds Select Sidebar, Header Featured Image Options, Single Page/Post Image Layout
 * This is only for the design purpose and not used to save any content
 *
 * @package Catch_Wheels
 */



/**
 * Class to Renders and save metabox options
 *
 * @since Catch Wheels 0.1
 */
class Catch_Wheels_Metabox {
	private $meta_box;

	private $fields;

	/**
	* Constructor
	*
	* @since Catch Wheels 0.1
	*
	* @access public
	*
	*/
	public function __construct( $meta_box_id, $meta_box_title, $post_type ) {

		$this->meta_box = array (
							'id' 		=> $meta_box_id,
							'title' 	=> $meta_box_title,
							'post_type' => $post_type,
							);

		$this->fields = array(
			'catch-wheels-header-image',
			'catch-wheels-sidebar-option',
			'catch-wheels-featured-image',
		);


		// Add metaboxes
		add_action( 'add_meta_boxes', array( $this, 'add' ) );

		add_action( 'save_post', array( $this, 'save' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_metabox_scripts' ) );
	}

	/**
	* Add Meta Box for multiple post types.
	*
	* @since Catch Wheels 0.1
	*
	* @access public
	*/
	public function add($postType) {
		if( in_array( $postType, $this->meta_box['post_type'] ) ) {
			add_meta_box( $this->meta_box['id'], $this->meta_box['title'], array( $this, 'show' ), $postType );

			add_meta_box( $this->meta_box['id'] . '_vid_gallery', esc_html__( 'Video Gallery Options', 'catch-wheels' ), array( $this, 'vid_gallery_show' ), $postType, 'side', 'core' );
		}
	}

	/**
	  * Renders metabox
	  *
	  * @since Catch Wheels 0.1
	  *
	  * @access public
	  */
	public function show() {
		global $post;

		$sidebar_options = array(
			'default-sidebar'        => esc_html__( 'Default Sidebar', 'catch-wheels' ),
			'optional-sidebar-one'   => esc_html__( 'Optional Sidebar One', 'catch-wheels' ),
			'optional-sidebar-two'   => esc_html__( 'Optional Sidebar Two', 'catch-wheels' ),
			'optional-sidebar-three' => esc_html__( 'Optional Sidebar three', 'catch-wheels' ),
		);

		$header_image_options 	= array(
			'default' => esc_html__( 'Default', 'catch-wheels' ),
			'enable'  => esc_html__( 'Enable', 'catch-wheels' ),
			'disable' => esc_html__( 'Disable', 'catch-wheels' ),
		);

		$featured_image_options	= array(
			'disabled'              => esc_html__( 'Disabled', 'catch-wheels' ),
			'default'               => esc_html__( 'Default', 'catch-wheels' ),
			'post-thumbnail'        => esc_html__( 'Enabled', 'catch-wheels' ),
		);


		// Use nonce for verification
		wp_nonce_field( basename( __FILE__ ), 'catch_wheels_custom_meta_box_nonce' );

		// Begin the field table and loop  ?>
		<div id="catch-wheels-ui-tabs" class="ui-tabs">
			<ul class="catch-wheels-ui-tabs-nav" id="catch-wheels-ui-tabs-nav">
				<li><a href="#frag2"><?php esc_html_e( 'Header Featured Image Options', 'catch-wheels' ); ?></a></li>
				<li><a href="#frag3"><?php esc_html_e( 'Single Page/Post Image Layout', 'catch-wheels' ); ?></a></li>
			</ul>
			<div id="frag2" class="catch_ad_tabhead">
				<table id="header-image-metabox" class="form-table" width="100%">
					<tbody>
						<tr>
							<?php
							$metaheader = get_post_meta( $post->ID, 'catch-wheels-header-image', true );

							if ( empty( $metaheader ) ){
								$metaheader = 'default';
							}

							foreach ( $header_image_options as $field => $label ) {
							?>
								<td style="width: 100px;">
									<label class="description">
										<input type="radio" name="catch-wheels-header-image" value="<?php echo esc_attr( $field ); ?>" <?php checked( $field, $metaheader ); ?>/>&nbsp;&nbsp;<?php echo esc_html( $label ); ?>
									</label>
								</td>

							<?php
							} // end foreach
							?>
						</tr>
					</tbody>
				</table>
			</div>

			<div id="frag3" class="catch_ad_tabhead">
				<table id="featured-image-metabox" class="form-table" width="100%">
					<tbody>
						<tr>
							<select name="catch-wheels-featured-image" id="custom_element_grid_class">
								 <?php
									foreach ( $featured_image_options as $field => $label ) {

										$metaimage = get_post_meta( $post->ID, 'catch-wheels-featured-image', true );

										if( empty( $metaimage ) ){
											$metaimage='default';
										}
									?>
										<option value="<?php echo esc_attr( $field ); ?>" <?php selected( $metaimage, $field ); ?>><?php echo esc_html( $label ); ?></option>
									<?php
									} // end foreach
								?>
							</select>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	<?php
	}

	/**
	  * Renders metabox
	  *
	  * @since Catch Wheels 0.1
	  *
	  * @access public
	  */
	public function vid_gallery_show() {
		global $post;

		// Use nonce for verification
		wp_nonce_field( basename( __FILE__ ), 'catch_wheels_custom_meta_box_nonce' );

		$layout = get_post_meta( $post->ID, 'catch-wheels-video-layout', true );

		if ( ! $layout ){
			$layout = 'default';
		}

		$cols = get_post_meta( $post->ID, 'catch-wheels-video-cols', true );

		if ( ! $cols ){
			$cols = 'layout-two';
		}

		// Begin the field table and loop  ?>
		<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="catch-wheels-video-layout"><?php esc_html_e( 'Template', 'catch-wheels' ) ?></label></p>
		<select name="catch-wheels-video-layout">
			<option value="default" <?php selected( $layout, 'default' ); ?>><?php esc_html_e( 'Default', 'catch-wheels' ) ?></option>
			<option value="left-sidebar" <?php selected( $layout, 'left-sidebar' ); ?>><?php esc_html_e( 'Left Sidebar ( Primary Sidebar, Content )', 'catch-wheels' ) ?></option>
			<option value="no-sidebar" <?php selected( $layout, 'no-sidebar' ); ?>><?php esc_html_e( 'No Sidebar', 'catch-wheels' ) ?></option>
			<option value="no-sidebar-full-width" <?php selected( $layout, 'full-width' ); ?>><?php esc_html_e( 'No Sidebar: Full Width', 'catch-wheels' ) ?></option>
			<option value="right-sidebar" <?php selected( $layout , 'right-sidebar'); ?>><?php esc_html_e( 'Right Sidebar ( Content, Primary Sidebar )', 'catch-wheels' ) ?></option>
		</select>

		<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="catch-wheels-video-cols"><?php esc_html_e( 'Gallery Layout', 'catch-wheels' ) ?></label></p>
		<select name="catch-wheels-video-cols">
			<option value="layout-one" <?php selected( $cols, 'layout-one' ); ?>><?php esc_html_e( 'One Column', 'catch-wheels' ) ?></option>
			<option value="layout-two" <?php selected( $cols, 'layout-two' ); ?>><?php esc_html_e( 'Two Columns', 'catch-wheels' ) ?></option>
			<option value="layout-three" <?php selected( $cols, 'layout-three' ); ?>><?php esc_html_e( 'Three Columns', 'catch-wheels' ) ?></option>
			<option value="layout-four" <?php selected( $cols , 'layout-four'); ?>><?php esc_html_e( 'Four Columns', 'catch-wheels' ) ?></option>
		</select>
	<?php
	}

	/**
	 * Save custom metabox data
	 *
	 * @action save_post
	 *
	 * @since Catch Wheels 0.1
	 *
	 * @access public
	 */
	public function save( $post_id ) {
		global $post_type;

		$post_type_object = get_post_type_object( $post_type );

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                      // Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )        // Check Revision
		|| ( ! in_array( $post_type, $this->meta_box['post_type'] ) )                  // Check if current post type is supported.
		|| ( ! check_admin_referer( basename( __FILE__ ), 'catch_wheels_custom_meta_box_nonce') )    // Check nonce - Security
		|| ( ! current_user_can( $post_type_object->cap->edit_post, $post_id ) ) )  // Check permission
		{
		  return $post_id;
		}

		foreach ( $this->fields as $field ) {
			$new = $_POST[ $field ];

			delete_post_meta( $post_id, $field );

			if ( '' == $new || array() == $new ) {
				return;
			} else {
				if ( ! update_post_meta ( $post_id, $field, sanitize_key( $new ) ) ) {
					add_post_meta( $post_id, $field, sanitize_key( $new ), true );
				}
			}
		} // end foreach

		//Validation for header image extra options
		$date = $_POST['catch-wheels-event-day'];
		if ( '' != $date ) {
			if ( ! update_post_meta( $post_id, 'catch-wheels-event-day', sanitize_text_field( $date ) ) ) {
				add_post_meta( $post_id, 'catch-wheels-event-day', sanitize_text_field( $date ), true );
			}
		}

		//Validation for header image extra options
		$time = $_POST['catch-wheels-event-month'];
		if ( '' != $time ) {
			if ( ! update_post_meta( $post_id, 'catch-wheels-event-month', sanitize_text_field( $time ) ) ) {
				add_post_meta( $post_id, 'catch-wheels-event-month', sanitize_text_field( $time ), true );
			}
		}

		//Validation for header image extra options
		$vid_layout = $_POST['catch-wheels-video-layout'];
		if ( '' != $vid_layout ) {
			if ( ! update_post_meta( $post_id, 'catch-wheels-video-layout', sanitize_text_field( $vid_layout ) ) ) {
				add_post_meta( $post_id, 'catch-wheels-video-layout', sanitize_text_field( $vid_layout ), true );
			}
		}

		//Validation for header image extra options
		$vid_cols = $_POST['catch-wheels-video-cols'];
		if ( '' != $vid_cols ) {
			if ( ! update_post_meta( $post_id, 'catch-wheels-video-cols', sanitize_text_field( $vid_cols ) ) ) {
				add_post_meta( $post_id, 'catch-wheels-video-cols', sanitize_text_field( $vid_cols ), true );
			}
		}
	}

	public function enqueue_metabox_scripts( $hook ) {
		$allowed_pages = array( 'post-new.php', 'post.php' );

		// Bail if not on required page
		if ( ! in_array( $hook, $allowed_pages ) ) {
			return;
		}

		//Scripts
		wp_enqueue_script( 'catch-wheels-metabox-script', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'inc/metabox/metabox.js', array( 'jquery', 'jquery-ui-tabs' ), '2017-08-15' );

		//CSS Styles
		wp_enqueue_style( 'catch-wheels-metabox-style', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'inc/metabox/metabox.css' );
	}
}

$catch_wheels_metabox = new Catch_Wheels_Metabox(
	'catch-wheels-options', 					//metabox id
	esc_html__( 'Catch Wheels Options', 'catch-wheels' ), //metabox title
	array( 'page', 'post' )				//metabox post types
);
