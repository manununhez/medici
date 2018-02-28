<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @subpackage  Field_Multi_Text
 * @author      Daniel J Griffiths (Ghost1227)
 * @author      Dovy Paukstys
 * @version     3.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_multi_text' ) ) {

	/**
	 * Main ReduxFramework_multi_text class
	 *
	 * @since       1.0.0
	 */
		class ReduxFramework_multi_text {

		/**
		 * Field Constructor.
		 *
		 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		function __construct( $field = array(), $value ='', $parent ) {

						//parent::__construct( $parent->sections, $parent->args );
			$this->parent = $parent;
			$this->field = $field;
			$this->value = $value;

		}

		/**
		 * Field Render Function.
		 *
		 * Takes the vars and outputs the HTML for the field in the settings
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		public function render() {
			global $sidebars_widgets;
			$this->add_text = ( isset($this->field['add_text']) ) ? $this->field['add_text'] : __( 'Add More', 'redux-framework');

			$this->show_empty = ( isset($this->field['show_empty']) ) ? $this->field['show_empty'] : true;

			echo '<ul id="' . $this->field['id'] . '-ul" class="redux-multi-text">';

			if( isset( $this->value ) && is_array( $this->value ) ) {
				foreach( $this->value as $k => $value ) {
					if( $value != '' )
						$sb_id = strtolower(preg_replace("/[^a-z0-9\-]+/i", "_", esc_attr( $value )));
						$w_num = isset($sidebars_widgets[$sb_id]) ? count($sidebars_widgets[$sb_id]) : 0;
						$remove = '';
						if (!$w_num) {
							$remove = ' <a href="javascript:void(0);" class="deletion redux-multi-text-remove">' . __( 'Remove', 'redux-framework' ) . '</a>';
						}
						echo '<li><input type="text" id="' . $this->field['id'] . '-' . $k . '" name="' . $this->field['name'] . '[]' . $this->field['name_suffix'] . '" value="' . esc_attr( $value ) . '" class="regular-text ' . $this->field['class'] . '" ' . ($w_num ? ' readonly' : '') . '/>' . $remove . '</a></li>';
				}
			} elseif (!empty($this->field['options'])) {
				foreach( $this->field['options'] as $k => $value ) {
					if( $value != '' )
						//echo '<li><input type="text" id="' . $this->field['id'] . '-' . $k . '" name="' . $this->field['name'] . '[' . $this->field['id'] . '][]" value="' . esc_attr( $value ) . '" class="regular-text ' . $this->field['class'] . '" /> <a href="javascript:void(0);" class="deletion redux-multi-text-remove">' . __( 'Remove', 'redux-framework' ) . '</a></li>';
						echo '<li><input type="text" id="' . $this->field['id'] . '-' . $k . '" name="' . $this->field['name'] . '[]' . $this->field['name_suffix'] . '" value="' . esc_attr( $value ) . '" class="regular-text ' . $this->field['class'] . '" /> <a href="javascript:void(0);" class="deletion redux-multi-text-remove">' . __( 'Remove', 'redux-framework' ) . '</a></li>';

				}
			} elseif($this->show_empty == true ) {
				echo '<li><input type="text" id="' . $this->field['id'] . '" name="' . $this->field['name'] . '[]' . $this->field['name_suffix'] . '" value="" class="regular-text ' . $this->field['class'] . '" /> <a href="javascript:void(0);" class="deletion redux-multi-text-remove">' . __( 'Remove', 'redux-framework' ) . '</a></li>';
			}

			echo '<li style="display:none;"><input type="text" id="' . $this->field['id'] . '" name="" value="" class="regular-text" /> <a href="javascript:void(0);" class="deletion redux-multi-text-remove">' . __( 'Remove', 'redux-framework') . '</a></li>';

			echo '</ul>';
			$this->field['add_number'] = ( isset( $this->field['add_number'] ) && is_numeric( $this->field['add_number'] ) ) ? $this->field['add_number'] : 1;
			echo '<i></i><a href="javascript:void(0);" class="button button-primary redux-multi-text-add" data-add_number="'.$this->field['add_number'].'" data-id="' . $this->field['id'] . '-ul" data-name="' . $this->field['name'] . '[]">' . $this->add_text . '</a>';

		}

		/**
		 * Enqueue Function.
		 *
		 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		public function enqueue() {
			wp_enqueue_script(
					'redux-field-multi-text-js',
					ReduxFramework::$_url . 'inc/fields/multi_text/field_multi_text.js',
					array( 'jquery' ),
					time(),
					true
			);

			wp_enqueue_style(
				'redux-field-multi-text-css',
				ReduxFramework::$_url.'inc/fields/multi_text/field_multi_text.css',
				time(),
				true
			);

		}
	}
}