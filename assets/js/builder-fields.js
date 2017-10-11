( function( puppyfw ) {
	"use strict";

	var builder = puppyfw.builder;


	builder.api.registerFieldType( 'checkbox', puppyfw.i18n.builder.types.checkbox );
	builder.api.registerTemplate( 'checkbox', {
		template: '#puppyfw-field-edit-checkbox-tpl',
		beforeMount: function() {
			if ( ! this.field.default ) {
				this.field.default = false;
			}
		}
	});


	builder.api.registerFieldType( 'checkbox_list', puppyfw.i18n.builder.types.checkboxList );
	builder.api.registerTemplate( 'checkbox_list', {
		template: '#puppyfw-field-edit-checkbox-list-tpl'
	});


	builder.api.registerFieldType( 'email', puppyfw.i18n.builder.types.email );
	builder.api.registerTemplate( 'email', {
		template: '#puppyfw-field-edit-email-tpl'
	});


	builder.api.registerFieldType( 'number', puppyfw.i18n.builder.types.number );
	builder.api.registerTemplate( 'number', {
		template: '#puppyfw-field-edit-number-tpl'
	});


	builder.api.registerFieldType( 'tel', puppyfw.i18n.builder.types.tel );
	builder.api.registerTemplate( 'tel', {
		template: '#puppyfw-field-edit-tel-tpl'
	});


	builder.api.registerFieldType( 'text', puppyfw.i18n.builder.types.text );
	builder.api.registerTemplate( 'text', {
		template: '#puppyfw-field-edit-text-tpl'
	});

})( window.puppyfw );
