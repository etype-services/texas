<?php
class views_field_split_plugin_style extends views_plugin_style {
	function option_definition() {
		// Options definition
		$options['num_rows'] = array('default' => 1);
		$options['choose_fields'] = array('default' => array());
		$options['choose_fields_others'] = array('default' => array());

		return $options;
	}

	function options_form(&$form, &$form_state) {
		$options_field = $this->display->handler->get_field_labels();;

		$form['num_rows'] = array(
			'#title' => t('Number of rows display'),
			'#type' => 'textfield',
			'#size' => 10,
			'#default_value' => $this->options['num_rows'],
		);

		$form['choose_fields'] = array(
			'#title' => t('Choose fields:'),
			'#type' => 'checkboxes',
			'#options' => $options_field,
			'#default_value' => $this->options['choose_fields'],
		);

		$form['choose_fields_others'] = array(
			'#title' => t('Choose fields for other rows:'),
			'#type' => 'checkboxes',
			'#options' => $options_field,
			'#default_value' => $this->options['choose_fields_others'],
		);
	}

	function render() {
		$num_first_row = $this->options['num_rows'];
		$org_field = $this->view->field;

		// Get views_handler_field for first rows and others
		$first_rows_selected_fields = $this->selectedFields($this->options['choose_fields'], $org_field);
		$others_seleted_fields = $this->selectedFields($this->options['choose_fields_others'], $org_field);

		// Render first rows
		$this->view->field = $first_rows_selected_fields;
		$sets = $this->render_grouping(
      $this->view->result,
      $this->options['grouping'],
      TRUE
    );
		$first_rows_data = '<div class="rows-first">' . $this->render_grouping_sets($sets, $num_first_row) . '</div>';

		// Render others rows
		$this->view->field = $others_seleted_fields;
		$sets = $this->render_grouping(
				$this->view->result,
				$this->options['grouping'],
				TRUE
		);
		$others_rows_data = '<div class="rows-others">' . $this->render_grouping_sets($sets, $num_first_row, 'others') . '</div>';

		return $first_rows_data . $others_rows_data;
	}

	function render_grouping_sets($sets, $num_rows_first = 1,  $row_type = 'rows_first', $level = 0) {
		$output = '';
		foreach ($sets as $set) {
			// Render as a record set.
			if ($this->uses_row_plugin()) {
				switch ($row_type) {
					// Render first rows
					case 'rows_first':
						foreach ($set['rows'] as $index => $row) {
							if ($index < $num_rows_first) {
								$this->view->row_index = $index;
								$set['rows'][$index] = $this->row_plugin->render($row);
							}
							else{
								unset($set['rows'][$index]);
							}
						}
						break;

					// Render others
					case 'others':
						foreach ($set['rows'] as $index => $row) {
							if ($index >= $num_rows_first) {
								$this->view->row_index = $index;
								$set['rows'][$index] = $this->row_plugin->render($row);
							}
							else{
								unset($set['rows'][$index]);
							}
						}
						break;
				}
			}

			$output .= theme($this->theme_functions(),
					array(
							'view' => $this->view,
							'options' => $this->options,
							'grouping_level' => $level,
							'rows' => $set['rows'],
							'title' => $set['group'])
			);
		}
		unset($this->view->row_index);
		return $output;
	}

	/**
	 *
	 * @param array $choosedFields
	 * @param array $orgFields
	 * @return array views_handler_field
	 */
	function selectedFields($choosedFields, $orgFields) {
		$selected_fields = array();

		foreach ($choosedFields as $key => $field) {
			if (is_string($field)) {
				$selected_fields[$key] = $orgFields[$key];
			}
		}

		return $selected_fields;
	}
}