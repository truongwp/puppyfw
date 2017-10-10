( function( puppyfw, Vue, _, $ ) {
	"use strict";

	puppyfw.builder = puppyfw.builder || {};
	puppyfw.builder.mixins = puppyfw.builder.mixins || {};
	puppyfw.builder.components = puppyfw.builder.components || {};

	/*---------------------------------
	 *          M I X I N S
	 *--------------------------------*/
	var HasFieldProp = puppyfw.builder.mixins.HasFieldProp;

	/*---------------------------------
	 *       C O M P O N E N T S
	 *--------------------------------*/

	var Components = {
		Controls: {},
		Templates: {},
		Builder: {}
	};




	// Template components
	Components.Templates.FieldItemEdit = {
		name: 'field-item-edit',
		template: '#puppyfw-field-item-edit-tpl',

		mixins: [ HasFieldProp ],

		components: puppyfw.builder.controls,

		methods: {
			addAttr: function() {
				this.field.attrs.push({
					key: '',
					value: ''
				});
			},

			removeAttr: function( index ) {
				Vue.delete( this.field.attrs, index );
			}
		}
	};

	Components.Templates.FieldItemEditNumber = {
		name: 'field-item-edit-number',
		template: '#puppyfw-field-item-edit-number-tpl',
		mixins: [ Components.Templates.FieldItemEdit ]
	};

	Components.Templates.FieldItemEditHtml = {
		name: 'field-item-edit-html',
		template: '#puppyfw-field-item-edit-html-tpl',
		mixins: [ Components.Templates.FieldItemEdit ]
	};

	Components.Templates.FieldItemEditCheckbox = {
		name: 'field-item-edit-checkbox',
		template: '#puppyfw-field-item-edit-checkbox-tpl',
		mixins: [ Components.Templates.FieldItemEdit ]
	};

	Components.Templates.FieldItemEditChoice = {
		name: 'field-item-edit-choice',
		template: '#puppyfw-field-item-edit-choice-tpl',
		mixins: [ Components.Templates.FieldItemEdit ]
	};


	puppyfw.builder.components.FieldItemHeading = {
		template: '#puppyfw-field-item-heading-tpl',

		mixins: [ HasFieldProp ]
	};

	puppyfw.builder.templates['field-item-heading'] = puppyfw.builder.components.FieldItemHeading;

	puppyfw.builder.components.FieldItem = {
		name: 'field-item',

		template: '#puppyfw-field-item-tpl',

		components: puppyfw.builder.templates,

		mixins: [ HasFieldProp ],

		data: function() {
			return {
				editing: false
			};
		},

		methods: {
			toggleEditing: function() {
				this.editing = ! this.editing;
			}
		}
	};

	Vue.component( 'fields-builder', {
		name: 'fields-builder',

		template: '#puppyfw-fields-builder-tpl',

		components: {
			'field-item': puppyfw.builder.components.FieldItem
		},

		props: {
			fields: {
				type: Array,
				required: true
			}
		},

		mounted: function() {
			var _this = this;

			$( this.$el ).sortable({
				placeholder: 'field-placeholder',
				start: function( e, ui ) {
					ui.placeholder.height( ui.item.height() );
					ui.item.data( 'start', ui.item.index() );
				},
				update: function( event, ui ) {
					var start, end;

					start = ui.item.data( 'start' );
					end = ui.item.index();

					_this.moveField( start, end );
				},
				cancel: '.field__edit'
			});
		},

		methods: {
			addField: function() {
				this.fields.push( puppyfw.helper.getEmptyField() );
			},

			moveField: function( start, end ) {
				var item;
				item = this.fields.splice( start, 1 )[0];
				this.fields.splice( end, 0, item );
			},

			removeField: function( field ) {
				var index = this.fields.indexOf( field );

				if ( index >= 0 ) {
					this.fields.splice( index, 1 );
				}
			},

			cloneField: function( field ) {
				var newField, index;

				index = this.fields.indexOf( field );

				if ( index < 0 ) {
					return;
				}

				newField = puppyfw.helper.clone( field );

				puppyfw.helper.replaceId( newField );

				this.fields.splice( index + 1, 0, newField );
			}
		}
	});

	/*---------------------------------
	 *     A P P L I C A T I O N
	 *--------------------------------*/
	puppyfw.builder.app = new Vue({
		data: {
			fields: []
		},

		beforeMount: function() {
			var fields = document.getElementById( 'field-data' ).value;
			fields = JSON.parse( fields );

			for ( var i = 0; i < fields.length; i++ ) {
				fields[ i ] = this.parseField( fields[ i ] );
			}

			this.fields = fields;
		},

		methods: {
			parseField: function( field ) {
				var emptyField = puppyfw.helper.getEmptyField();

				field = Vue.util.extend( emptyField, field );

				if ( puppyfw.helper.isNonEmptyObject( field.attrs ) ) {
					field.attrs = puppyfw.helper.objectToArray( field.attrs );
				}

				if ( puppyfw.helper.isNonEmptyObject( field.options ) ) {
					field.options = puppyfw.helper.objectToArray( field.options );
				}

				return field;
			}
		}
	});

	puppyfw.builder.app.$mount( '#puppyfw-builder' );
})( window.puppyfw, Vue, _, jQuery );
