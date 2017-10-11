( function( puppyfw, Vue, _, $ ) {
	"use strict";

	var builder = puppyfw.builder = puppyfw.builder || {};
	builder.mixins = builder.mixins || {};
	builder.components = builder.components || {};


	builder.components.FieldItemHeading = {
		template: '#puppyfw-field-item-heading-tpl',

		mixins: [ builder.mixins.HasFieldProp ]
	};

	builder.templates['field-item-heading'] = builder.components.FieldItemHeading;

	builder.components.FieldItem = {
		name: 'field-item',

		template: '#puppyfw-field-item-tpl',

		components: builder.templates,

		mixins: [ builder.mixins.HasFieldProp ],

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
			'field-item': builder.components.FieldItem
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
	builder.app = new Vue({
		data: {
			fields: []
		},

		beforeMount: function() {
			var fields = document.getElementById( 'field-data' ).value;

			fields = JSON.parse( fields );

			if ( ! fields ) {
				return;
			}

			for ( var i = 0; i < fields.length; i++ ) {
				fields[ i ] = this.parseField( fields[ i ] );
			}

			this.fields = fields;
		},

		methods: {
			parseField: function( field ) {
				var emptyField = puppyfw.helper.getEmptyField();

				field = Vue.util.extend( emptyField, field );

				if ( puppyfw.helper.isNonEmptyObject( field.options ) ) {
					field.options = puppyfw.helper.objectToArray( field.options );
				}

				return field;
			}
		}
	});

	builder.app.$mount( '#puppyfw-builder' );
})( window.puppyfw, Vue, _, jQuery );
