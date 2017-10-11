( function( puppyfw, Vue ) {
	"use strict";

	var helper, builder;
	helper = puppyfw.helper = puppyfw.helper || {};
	builder = puppyfw.builder = puppyfw.builder || {};
	builder.defaultField = {
		title: puppyfw.i18n.builder.types.text,
		type: 'text',
		desc: '',
		default: '',
		attrs: [],
		options: [],
		content: '',
		fields: []
	};
	builder.types = {};
	builder.mapping = {};
	builder.controls = {};
	builder.templates = {};
	builder.mixins = {};
	builder.api = {};

	helper.getRandomString = function( length ) {
		if ( ! length ) {
			length = 5;
		}

		var str = '';
		var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

		for ( var i = 0; i < length; i++ ) {
			str += possible.charAt( Math.floor( Math.random() * possible.length ) );
		}

		return str;
	};

	helper.clone = function( obj ) {
		return JSON.parse( JSON.stringify( obj ) );
	};

	helper.isNonEmptyObject = function( obj ) {
		return typeof obj === 'object' && Object.keys( obj ).length && ! obj[0];
	};

	helper.replaceId = function( field ) {
		var rand = helper.getRandomString();
		field.baseId = 'field-' + rand;
		field.id = 'field-' + rand;

		if ( typeof field.fields == 'object' ) {
			_.each( field.fields, function( childField ) {
				helper.replaceId( childField );
			});
		}
	};

	helper.getDefaultField = function() {
		var field, id;
		field = this.clone( builder.defaultField );
		id = 'field-' + helper.getRandomString();
		field.baseId = id;
		field.id = id;
		return field;
	};

	helper.getTypeEditComponent = function( type ) {
		return builder.mapping[ type ] || 'field-edit-text';
	};

	helper.objectToArray = function( obj ) {
		var arr = [];

		for ( var i in obj ) {
			arr.push({
				key: i,
				value: obj[ i ]
			});
		}

		return arr;
	};


	builder.api.registerFieldType = function( type, title ) {
		builder.types[ type ] = title;
	};

	builder.api.registerControl = function( name, component ) {
		builder.controls[ name ] = component;
	};

	builder.api.map = function( type, componentName ) {
		builder.mapping[ type ] = componentName;
	};

	builder.api.addDefaultFieldData = function( name, value ) {
		builder.defaultField[ name ] = value;
	};

	builder.api.registerTemplate = function( type, component ) {
		component.name = 'field-edit-' + type;

		component.mixins = component.mixins || [];
		component.mixins.push( builder.mixins.HasFieldProp );

		component.components = component.components || {};
		component.components = Vue.util.extend( builder.controls, component.components );

		builder.templates[ component.name ] = component;
		builder.api.map( type, component.name );
	};

	builder.mixins.HasFieldProp = {
		props: {
			field: {
				type: Object,
				required: true
			}
		}
	};

	builder.mixins.HasAttrs = {
		beforeMount: function() {
			if ( ! this.field.attrs ) {
				this.field.attrs = [];
			}
		}
	};

	builder.mixins.HasOptions = {
		beforeMount: function() {
			if ( ! this.field.options ) {
				this.field.options = [];
			}
		}
	};

	builder.mixins.HasJsOptions = {
		beforeMount: function() {
			if ( ! this.field.js_options ) {
				this.field.js_options = [];
			}
		}
	};

	puppyfw.builder = builder;
})( window.puppyfw, Vue );
