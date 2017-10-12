( function( puppyfw ) {
	"use strict";

	var builder = puppyfw.builder;


	builder.api.registerFieldType( 'checkbox', puppyfw.i18n.builder.types.checkbox );
	builder.api.registerTemplate( 'checkbox', {
		template: '#puppyfw-field-edit-checkbox-tpl',
		mixins: [ builder.mixins.HasAttrs ],
		beforeMount: function() {
			if ( ! this.field.default ) {
				this.field.default = false;
			}
		}
	});


	builder.api.registerFieldType( 'checkbox_list', puppyfw.i18n.builder.types.checkboxList );
	builder.api.registerTemplate( 'checkbox_list', {
		template: '#puppyfw-field-edit-checkbox-list-tpl',
		mixins: [ builder.mixins.HasOptions ]
	});


	builder.api.registerFieldType( 'colorpicker', puppyfw.i18n.builder.types.colorpicker );
	builder.api.registerTemplate( 'colorpicker', {
		template: '#puppyfw-field-edit-colorpicker-tpl',
		mixins: [ builder.mixins.HasAttrs ]
	});


	builder.api.registerFieldType( 'datepicker', puppyfw.i18n.builder.types.datepicker );
	builder.api.registerTemplate( 'datepicker', {
		template: '#puppyfw-field-edit-datepicker-tpl',
		mixins: [ builder.mixins.HasAttrs, builder.mixins.HasJsOptions ]
	});


	builder.api.registerFieldType( 'editor', puppyfw.i18n.builder.types.editor );
	builder.api.registerTemplate( 'editor', {
		template: '#puppyfw-field-edit-editor-tpl',
		mixins: [ builder.mixins.HasAttrs ],
		beforeMount: function() {
			if ( typeof this.field.quicktags == 'undefined' ) {
				Vue.set( this.field, 'quicktags', true );
			}

			if ( typeof this.field.tinymce == 'undefined' ) {
				Vue.set( this.field, 'tinymce', false );
			}
		}
	});


	builder.api.registerFieldType( 'email', puppyfw.i18n.builder.types.email );
	builder.api.registerTemplate( 'email', {
		template: '#puppyfw-field-edit-email-tpl',
		mixins: [ builder.mixins.HasAttrs ]
	});


	builder.api.registerFieldType( 'group', puppyfw.i18n.builder.types.group );
	builder.api.registerTemplate( 'group', {
		template: '#puppyfw-field-edit-group-tpl'
	});


	builder.api.registerFieldType( 'html', puppyfw.i18n.builder.types.html );
	builder.api.registerTemplate( 'html', {
		template: '#puppyfw-field-edit-html-tpl'
	});


	builder.api.registerFieldType( 'image', puppyfw.i18n.builder.types.image );
	builder.api.registerTemplate( 'image', {
		template: '#puppyfw-field-edit-image-tpl',
		beforeMount: function() {
			if ( this.field.default.id ) {
				Vue.set( this.field, 'default', this.field.default.id );
			} else if ( this.field.default.url ) {
				Vue.set( this.field, 'default', this.field.default.url );
			} else if ( typeof this.field.default == 'object' ) {
				Vue.set( this.field, 'default', '' );
			}
		}
	});


	builder.api.registerFieldType( 'images', puppyfw.i18n.builder.types.images );
	builder.api.registerTemplate( 'images', {
		template: '#puppyfw-field-edit-images-tpl'
	});


	builder.api.registerFieldType( 'number', puppyfw.i18n.builder.types.number );
	builder.api.registerTemplate( 'number', {
		template: '#puppyfw-field-edit-number-tpl',
		mixins: [ builder.mixins.HasAttrs ]
	});


	builder.api.registerFieldType( 'tel', puppyfw.i18n.builder.types.tel );
	builder.api.registerTemplate( 'tel', {
		template: '#puppyfw-field-edit-tel-tpl',
		mixins: [ builder.mixins.HasAttrs ]
	});


	builder.api.registerFieldType( 'text', puppyfw.i18n.builder.types.text );
	builder.api.registerTemplate( 'text', {
		template: '#puppyfw-field-edit-text-tpl',
		mixins: [ builder.mixins.HasAttrs ]
	});

})( window.puppyfw );
