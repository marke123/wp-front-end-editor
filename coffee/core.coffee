# fetch all 'data-' attributes from a DOM node
extract_data_attr = (el) ->
	data = {}

	for attr in el.attributes
		if attr.specified and attr.name.indexOf('data-') is 0
			value = attr.value

			try
				value = jQuery.parseJSON(value)

			if value is null
				value = ''

			data[ attr.name.substr(5) ] = value

	return data

jQuery.extend(FrontEndEditor, {
	fieldTypes: {}

	overlay: do ->
		$cover = jQuery('<div>', 'class': 'fee-loading')
			.css('background-image', 'url(' + FrontEndEditor.data.spinner + ')')
			.hide()
			.prependTo(jQuery('body'))

		return {
			cover: ($el) ->
				for parent in $el.parents()
					bgcolor = jQuery(parent).css('background-color')
					if bgcolor isnt 'transparent'
						break

				$cover
					.css(
						'width': $el.width()
						'height': $el.height()
						'background-color': bgcolor
					)
					.css($el.offset())
					.show()

			hide: ->
				$cover.hide()
		}

	init_fields: ->
		# Create group instances
		for el in jQuery('.fee-group').not('.fee-initialized')
			$container = jQuery(el)
			$elements = $container.find('.fee-field').removeClass('fee-field')

			if !$elements.length
				continue

			editors =
				for el in $elements
					editor = FrontEndEditor.make_editable(el)
					editor.part_of_group = true
					editor

			fieldType = if $container.hasClass 'status-auto-draft' then 'createPost' else 'group'

			editor = new FrontEndEditor.fieldTypes[fieldType] $container, editors

			editor.init_hover $container

			$container.data 'fee-editor', editor

		# Create field instances
		for el in jQuery('.fee-field').not('.fee-initialized')
			FrontEndEditor.make_editable el, true

	make_editable: (el, single) ->
		$el = jQuery(el)
		data = extract_data_attr(el)

		$el.addClass('fee-initialized')

		fieldType = FrontEndEditor.fieldTypes[data.type]
		if not fieldType
			if console
				console.warn('invalid field type', el)
			return

		editor = new fieldType

		editor.el = $el
		editor.data = data

		if single
			editor.init_hover $el
			$el.data 'fee-editor', editor

		return editor
})
