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

		props: {
			tabs: {
				type: Array,
				default: []
			}
		},

		data: function() {
			return {
				editing: false
			};
		},

		mounted: function() {
			this.editing = this.field.editing;
			Vue.delete( this.field, 'editing' );
		},

		methods: {
			toggleEditing: function() {
				this.editing = ! this.editing;
				this.editing ? $( document ).trigger( 'puppyfw_edit_field' ) : $( document ).trigger( 'puppyfw_close_edit_field' );
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
			},
			tabs: {
				type: Array,
				default: []
			}
		},

		mounted: function() {
			this.initSortable();
		},

		methods: {
			initSortable: function() {
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
					handle: '.field__heading',
					cancel: '.field__control'
				});
			},

			addField: function() {
				var field = puppyfw.helper.getDefaultField();
				field.editing = true;
				this.fields.push( field );
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
				var emptyField = puppyfw.helper.getDefaultField();
				field = Vue.util.extend( emptyField, field );
				return field;
			}
		}
	});

	builder.app.$mount( '#puppyfw-builder' );
})( window.puppyfw, Vue, _, jQuery );
