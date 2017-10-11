( function( puppyfw, Vue ) {
	"use strict";

	var helper, builder;
	helper = puppyfw.helper = puppyfw.helper || {};
	builder = puppyfw.builder = puppyfw.builder || {};
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

	helper.getEmptyField = function() {
		var rand = helper.getRandomString();
		return {
			baseId: 'field-' + rand,
			id: 'field-' + rand,
			title: 'Field title',
			type: 'text',
			desc: '',
			default: '',
			attrs: [],
			options: [],
			content: '',
			fields: []
		};
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

	builder.api.registerTemplate = function( type, component ) {
		component.name = 'field-edit-' + type;

		component.mixins = component.mixins || [];
		component.mixins.push( builder.mixins.HasFieldProp );
		component.mixins.push( builder.mixins.HasAttrs );
		component.mixins.push( builder.mixins.HasOptions );

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
			if ( puppyfw.helper.isNonEmptyObject( this.field.attrs ) ) {
				Vue.set( this.field, 'attrs', puppyfw.helper.objectToArray( this.field.attrs ) );
			}
		},

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

	builder.mixins.HasOptions = {
		methods: {
			addOption: function() {
				this.field.options.push({
					key: '',
					value: ''
				});
			},

			removeOption: function( index ) {
				Vue.delete( this.field.options, index );
			}
		}
	};

	puppyfw.builder = builder;
})( window.puppyfw, Vue );
