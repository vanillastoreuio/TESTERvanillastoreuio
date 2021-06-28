<?php
/**
 * Featured Post Widget
 *
 * @package Catch Themes
 * @subpackage Clean Business
 * @since Clean Business 0.1
 */



/**
 * Featured Post widget class
 *
 * @since Clean Business 0.1
 */
class clean_business_featured_post_widget extends WP_Widget {

	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	function __construct() {

		$this->defaults = array(
			'title'           => '',
			'post_type'       => 'all-category',
			'post_id'         => '',
			'category'        => array(),
			'post_number'     => 1,
			'order'     	  => 'DESC',
			'orderby'     	  => 'date',
			'layout'     	  => 'one-column',
			'disable_image'   => 0,
			'image_alignment' => 'left',
			'image_size'      => '',
			'disable_title'   => 0,
			'hide_category'   => 0,
			'hide_tags'       => 1,
			'hide_posted_on'  => 1,
			'hide_author'     => 1,
			'content_type'    => '',
			'content_limit'   => 200,
			'more_text'       => esc_html__( 'Read More ...', 'clean-business' ),
		);

		$widget_ops = array(
			'classname'   => 'ct-featured-post ctfeaturedpostpageimage',
			'description' => esc_html__( 'Displays featured posts with thumbnails', 'clean-business' ),
		);

		$control_ops = array(
			'id_base' => 'ct-featured-post',
		);

		parent::__construct(
			'ct-featured-post', // Base ID
			esc_html__( 'CT: Featured Posts', 'clean-business' ), // Name
			$widget_ops,
			$control_ops
		);
	}

	function form( $instance ) {

		//* Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$style = 'style="display: none;"';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title', 'clean-business' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php esc_html_e( 'Select Posts From', 'clean-business' ); ?>:</label>
			<select class="ct_feat_post_post_type widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
				<?php
					$post_type_choices = array(
						'all-categories'  => esc_html__( 'All Categories', 'clean-business' ),
						'select-category' => esc_html__( 'Select Category', 'clean-business' ),
						'id'              => esc_html__( 'ID', 'clean-business' ),
					);

				foreach ( $post_type_choices as $key => $value ) {
					echo '<option value="' . $key . '" '. selected( $key, $instance['post_type'], false ) .'>' . $value .'</option>';
				}
				?>
			</select>
		</p>

		<p <?php echo ( 'id' == $instance['post_type'] )? '' : $style;  ?>>
			<label for="<?php echo $this->get_field_id( 'post_id' ); ?>"><?php esc_html_e( 'Post ID', 'clean-business' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'post_id' ); ?>" name="<?php echo $this->get_field_name( 'post_id' ); ?>" value="<?php echo sanitize_text_field( $instance['post_id'] ); ?>" class="widefat"/>
			<span class="description"><?php esc_html_e( 'Separate Multiple Post IDs by ,(comma)', 'clean-business' ); ?></span>
		</p>

        <p <?php echo ( 'select-category' == $instance['post_type'] )? '': $style; ?>>
        	<?php
        		clean_business_dropdown_categories(
        			$this->get_field_name( 'category[]' ),
        			$this->get_field_id( 'category' ),
        			(array) $instance['category']
        		);
        	?>
        </p>

        <p <?php echo ( 'id' == $instance['post_type'] )? $style : '';  ?>>
			<label for="<?php echo $this->get_field_id( 'post_number' ); ?>"><?php esc_html_e( 'No. of Posts', 'clean-business' ); ?>:</label>
			<input type="number" id="<?php echo $this->get_field_id( 'post_number' ); ?>" name="<?php echo $this->get_field_name( 'post_number' ); ?>" value="<?php echo absint( $instance['post_number'] ); ?>" class="small-text" min="1" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php esc_html_e( 'Order By', 'clean-business' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat">
				<?php
					$choices = array(
						'date'          => esc_html__( 'Date', 'clean-business' ),
						'ID'            => esc_html__( 'ID', 'clean-business' ),
						'author'        => esc_html__( 'Author', 'clean-business' ),
						'title'         => esc_html__( 'title', 'clean-business' ),
						'name'          => esc_html__( 'Name', 'clean-business' ),
						'comment_count' => esc_html__( 'Comment Count', 'clean-business' ),
						'rand'          => esc_html__( 'Random', 'clean-business' ),
					);

				foreach ( $choices as $key => $value ) {
					echo '<option value="' . $key . '" '. selected( $key, $instance['orderby'], false ) .'>' . $value .'</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php esc_html_e( 'Order', 'clean-business' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat">
				<?php
					$choices = array(
						'DESC'   => esc_html__( 'Descending (3, 2, 1)', 'clean-business' ),
						'ASC'   => esc_html__( 'Ascending (1, 2, 3)', 'clean-business' ),
					);

				foreach ( $choices as $key => $value ) {
					echo '<option value="' . $key . '" '. selected( $key, $instance['order'], false ) .'>' . $value .'</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php esc_html_e( 'Layout', 'clean-business' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>" class="widefat">
				<?php
					$post_type_choices = array(
						'one-column'   => esc_html__( '1 Column', 'clean-business' ),
						'two-column'   => esc_html__( '2 Column', 'clean-business' ),
						'three-column' => esc_html__( '3 Column', 'clean-business' ),
						'four-column'  => esc_html__( '4 Column', 'clean-business' ),
					);

				foreach ( $post_type_choices as $key => $value ) {
					echo '<option value="' . $key . '" '. selected( $key, $instance['layout'], false ) .'>' . $value .'</option>';
				}
				?>
			</select>
		</p>

		<p>
        	<input class="checkbox ct_feat_post_disable_image" type="checkbox" <?php checked($instance['disable_image'], true) ?> id="<?php echo $this->get_field_id( 'disable_image' ); ?>" name="<?php echo $this->get_field_name( 'disable_image' ); ?>" />
        	<label for="<?php echo $this->get_field_id('disable_image'); ?>"><?php esc_html_e( 'Check to Disable Image', 'clean-business' ); ?></label><br />
        </p>

        <p <?php echo ( $instance['disable_image'] )? $style : '';  ?>>
			<label for="<?php echo $this->get_field_id( 'image_alignment' ); ?>"><?php esc_html_e( 'Image Alignment', 'clean-business' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'image_alignment' ); ?>" name="<?php echo $this->get_field_name( 'image_alignment' ); ?>" class="widefat">
				<?php
					$image_alignment_choices = array(
						'top'    => esc_html__( 'Top', 'clean-business' ),
						'left'   => esc_html__( 'Left', 'clean-business' ),
						'right'  => esc_html__( 'Right', 'clean-business' ),
						'center' => esc_html__( 'Center', 'clean-business' ),
					);

				foreach ( $image_alignment_choices as $key => $value ) {
					echo '<option value="' . $key . '" '. selected( $key, $instance['image_alignment'], false ) .'>' . $value .'</option>';
				}
				?>
			</select>
		</p>

		<p <?php echo ( $instance['disable_image'] )? $style : '';  ?>>
			<label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php esc_html_e( 'Image Size', 'clean-business' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'image_size' ); ?>" class="automobile-image-size-selector widefat" name="<?php echo $this->get_field_name( 'image_size' ); ?>">
				<?php
				$sizes = clean_business_get_additional_image_sizes();
				foreach( (array) $sizes as $name => $size )
					echo '<option value="'.esc_attr( $name ).'" '.selected( $name, $instance['image_size'], FALSE ).'>'.esc_html( $name ).' ( '.$size['width'].'x'.$size['height'].' )</option>';
				?>
			</select>
		</p>

        <p>
        	<input class="checkbox" type="checkbox" <?php checked($instance['disable_title'], true) ?> id="<?php echo $this->get_field_id( 'disable_title' ); ?>" name="<?php echo $this->get_field_name( 'disable_title' ); ?>" />
        	<label for="<?php echo $this->get_field_id('disable_title'); ?>"><?php esc_html_e( 'Check to Disable Title', 'clean-business' ); ?></label><br />
        </p>

        <p>
			<span class="description"><?php esc_html_e( 'Post Meta Info', 'clean-business' ); ?></span><br/>
			<input class="checkbox" type="checkbox" <?php checked($instance['hide_category'], true) ?> id="<?php echo $this->get_field_id( 'hide_category' ); ?>" name="<?php echo $this->get_field_name( 'hide_category' ); ?>" />
        	<label for="<?php echo $this->get_field_id('hide_category'); ?>"><?php esc_html_e( 'Check to Hide Cagegory', 'clean-business' ); ?></label><br />
        	<input class="checkbox" type="checkbox" <?php checked($instance['hide_tags'], true) ?> id="<?php echo $this->get_field_id( 'hide_tags' ); ?>" name="<?php echo $this->get_field_name( 'hide_tags' ); ?>" />
        	<label for="<?php echo $this->get_field_id('hide_tags'); ?>"><?php esc_html_e( 'Check to Hide Tags', 'clean-business' ); ?></label><br />
        	<input class="checkbox" type="checkbox" <?php checked($instance['hide_posted_on'], true) ?> id="<?php echo $this->get_field_id( 'hide_posted_on' ); ?>" name="<?php echo $this->get_field_name( 'hide_posted_on' ); ?>" />
        	<label for="<?php echo $this->get_field_id('hide_posted_on'); ?>"><?php esc_html_e( 'Check to Hide Posted On Date', 'clean-business' ); ?></label><br />
        	<input class="checkbox" type="checkbox" <?php checked($instance['hide_author'], true) ?> id="<?php echo $this->get_field_id( 'hide_author' ); ?>" name="<?php echo $this->get_field_name( 'hide_author' ); ?>" />
        	<label for="<?php echo $this->get_field_id('hide_author'); ?>"><?php esc_html_e( 'Check Hide to Author', 'clean-business' ); ?></label><br />
		</p>

        <p>
			<label for="<?php echo $this->get_field_id( 'content_type' ); ?>"><?php esc_html_e( 'Content Type', 'clean-business' ); ?>:</label>
			<select class="ct_feat_post_content_type" id="<?php echo $this->get_field_id( 'content_type' ); ?>" name="<?php echo $this->get_field_name( 'content_type' ); ?>">
				<option value="content" <?php selected( 'content', $instance['content_type'] ); ?>><?php esc_html_e( 'Show Content', 'clean-business' ); ?></option>
				<option value="excerpt" <?php selected( 'excerpt', $instance['content_type'] ); ?>><?php esc_html_e( 'Show Excerpt', 'clean-business' ); ?></option>
				<option value="content-limit" <?php selected( 'content-limit', $instance['content_type'] ); ?>><?php esc_html_e( 'Show Content Limit', 'clean-business' ); ?></option>
				<option value="" <?php selected( '', $instance['content_type'] ); ?>><?php esc_html_e( 'No Content', 'clean-business' ); ?></option>
			</select>
			<br />
			<label <?php echo ( 'content-limit' != $instance['content_type'] )? $style : '';  ?>for="<?php echo $this->get_field_id( 'content_limit' ); ?>"><?php esc_html_e( 'Limit content to', 'clean-business' ); ?>
				<input type="text" id="<?php echo $this->get_field_id( 'content_limit' ); ?>" name="<?php echo $this->get_field_name( 'content_limit' ); ?>" value="<?php echo esc_attr( intval( $instance['content_limit'] ) ); ?>" size="3" />
				<?php esc_html_e( 'characters', 'clean-business' ); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'more_text' ); ?>"><?php esc_html_e( 'More Text (if applicable)', 'clean-business' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'more_text' ); ?>" name="<?php echo $this->get_field_name( 'more_text' ); ?>" value="<?php echo esc_html( $instance['more_text'] ); ?>" />
		</p>

		<script>
		jQuery(document).ready(function($){
			post_type = $( '.ct_feat_post_post_type' );

			post_type.change(function(){
				post_type_val = $(this).val();
				post_id      = $(this).parent().next();
				multi_cat_id = $(this).parent().next().next();
				post_no_id   = $(this).parent().next().next().next();

				if( 'all-categories' == post_type_val ) {
					post_id.hide();
					multi_cat_id.hide();
					post_no_id.show();
				}
				else if( 'id' == post_type_val ) {
					post_id.show();
					multi_cat_id.hide();
					post_no_id.hide();
				}
				else if( 'select-category' == post_type_val ) {
					post_id.hide();
					multi_cat_id.show();
					post_no_id.show();
				}
				return false;
			});

			disable_image = $( '.ct_feat_post_disable_image' );
			disable_image.change(function(){
				image_alignment = $(this).parent().next();
				image_size = $(this).parent().next().next();

				if( $(this).is(':checked') ) {
					image_alignment.hide();
					image_size.hide();
				}
				else {
					image_alignment.show();
					image_size.show();
				}
				return false;
			});

			content_type = $( '.ct_feat_post_content_type' );
			content_type.change(function(){
				content_type_val = $(this).val();
				content_limit = $(this).next().next();

				if( 'content-limit' == content_type_val ) {
					content_limit.show();
				}
				else {
					content_limit.hide();
				}
				return false;
			});
		});
		</script>
       	<?php
	}

	function update( $new_instance, $old_instance ) {

		$instance                    = $old_instance;
		$instance['title']           = sanitize_text_field( $new_instance['title'] );
		$instance['post_type']       = sanitize_key( $new_instance['post_type'] );
		$instance['post_id']         = sanitize_text_field( $new_instance['post_id'] );
		$instance['category']        = ( array ) $new_instance['category'];
		$instance['post_number']     = absint( $new_instance['post_number'] );
		$instance['order']           = sanitize_key( $new_instance['order'] );
		$instance['orderby']         = sanitize_key( $new_instance['orderby'] );
		$instance['layout']          = sanitize_key( $new_instance['layout'] );
		$instance['disable_image']   = clean_business_sanitize_checkbox( $new_instance['disable_image'] );
		$instance['image_alignment'] = sanitize_key( $new_instance['image_alignment'] );
		$instance['image_size']      = sanitize_key( $new_instance['image_size'] );
		$instance['disable_title']   = clean_business_sanitize_checkbox( $new_instance['disable_title'] );
		$instance['hide_category']   = clean_business_sanitize_checkbox( $new_instance['hide_category'] );
		$instance['hide_tags']       = clean_business_sanitize_checkbox( $new_instance['hide_tags'] );
		$instance['hide_posted_on']  = clean_business_sanitize_checkbox( $new_instance['hide_posted_on'] );
		$instance['hide_author']     = clean_business_sanitize_checkbox( $new_instance['hide_author'] );
		$instance['content_type']    = sanitize_key( $new_instance['content_type'] );
		$instance['content_limit']   = absint( $new_instance['content_limit'] );
		$instance['more_text']       = sanitize_text_field( $new_instance['more_text'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		$output ='';

		// Merge with defaults
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$output .= $args['before_widget'];

		// Set up the author bio
		if ( ! empty( $instance['title'] ) ) {
			$output .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];
		}

		$query_args = array(
			'post_type'           => 'post',
			'order'               => $instance['order'],
			'orderby'             => $instance['orderby'],
			'ignore_sticky_posts' => '1',
		);

		if ( 'id' == $instance['post_type'] ) {
			$post_id_array = explode( ',', $instance['post_id'] );
			$query_args['post__in'] = $post_id_array;
		}
		elseif ( 'select-category' == $instance['post_type'] ) {
			$query_args['category__in']    = ( array ) $instance['category'];
			$query_args['posts_per_page'] = absint( $instance['post_number'] );
		}
		else {
			$query_args['posts_per_page'] = absint( $instance['post_number'] );
		}

		$loop = new WP_Query( $query_args );

		if ( $loop->have_posts() ) {
			$output .= '<div class="article-wrap ' . esc_attr( $instance['layout'] ) . ' '. esc_attr( $instance['image_alignment'] ) . ' ' . esc_attr( $instance['image_size'] ) .'">';

		while ( $loop->have_posts() ) {
			$loop->the_post();

			$class = 'post-'. esc_attr( get_the_ID() ) . ' post type-post hentry';

			if( $instance['disable_image'] || !has_post_thumbnail() ) {
				$class .= " no-featured-image";
			}

			$output .= '
			<article class="' . esc_attr( $class ) . '">';

				$title_attribute = the_title_attribute( 'echo=0' );

				if( !$instance['disable_image'] && has_post_thumbnail() ) {
					$output.= '
					<figure class="featured-image">
						<a href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '">' .
							get_the_post_thumbnail(
								get_the_ID(),
								$instance['image_size']
								) .'
						</a>
					</figure>';
				}

				$output .= '<div class="entry-container">';

				$output .= '<header class="entry-header">';

				if ( !$instance['disable_title'] ) {
					$output .= '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" title="'. $title_attribute .'">'. get_the_title() .'</a></h2>';
				}

				if (
					$instance['hide_category'] &&
					$instance['hide_tags'] &&
					$instance['hide_posted_on'] &&
					$instance['hide_author'] ) {
				}

				$output .= clean_business_get_highlight_meta(
							$instance['hide_category'],
							$instance['hide_tags'],
							$instance['hide_posted_on'],
							$instance['hide_author']
						);

				$output .= '</header><!-- .entry-header -->';

				if ( 'excerpt' == $instance['content_type'] ) {
					$output .= '<div class="entry-summary">';
					$output .= '<p>' . get_the_excerpt() . '</p>';
					$output .= '</div><!-- .entry-summary -->';
				}
				elseif ( 'content-limit' == $instance['content_type'] ) {
					$output .= '<div class="entry-summary">';
					$output .= clean_business_get_the_content_limit( (int) $instance['content_limit'], esc_html( $instance['more_text'] ) );
					$output .= '</div><!-- .entry-summary -->';
				}

				elseif( 'content' == $instance['content_type'] ) {
					$output .= '<div class="entry-content">';
					$output .= get_the_content( esc_html( $instance['more_text'] ) );
					$output .= '</div><!-- .entry-content -->';

				}

				$output .= '</div><!-- .entry-container -->';
				$output .= '</article><!-- .type-post -->';
			} //endwhile;

			$output .= '</div><!-- .article-wrap -->';
		} // endif;

		//* Restore original query
		wp_reset_postdata();

		$output .= $args['after_widget'];

		echo $output;
	}
}

/**
 * Initialize Ad Code Widget
 */
function clean_business_featured_post_init() {
	register_widget( 'clean_business_featured_post_widget' );
}
add_action( 'widgets_init', 'clean_business_featured_post_init' );
