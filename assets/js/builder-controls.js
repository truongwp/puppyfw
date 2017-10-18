( function( puppyfw, Vue, $ ) {
	"use strict";

	var builder = puppyfw.builder;

	builder.api.registerControl( 'checkbox-control', {
		template: '#puppyfw-checkbox-control-tpl',
		props: {
			id: {
				type: String
			},
			label: {
				type: String
			},
			value: {
				type: Boolean,
				default: false
			}
		}
	});

	builder.api.registerControl( 'dependency-control', {
		template: '#puppyfw-dependency-control-tpl',
		props: {
			label: {
				type: String
			},
			addLabel: {
				type: String
			},
			rules: {
				type: Array,
				default: []
			}
		},

		data: function() {
			return {
				stateRules: []
			}
		},

		watch: {
			stateRules: function( newVal ) {
				this.$emit( 'changeValue', newVal );
			}
		},

		beforeMount: function() {
			this.stateRules = this.rules;

			if ( this.stateRules.length ) {
				this.stateRules = puppyfw.helper.injectBaseId( this.stateRules );
				this.stateRules.map( function( rule ) {
					if ( ! rule.operator ) {
						rule.operator = '=';
					}
				});
			}
		},

		methods: {
			addRule: function() {
				this.stateRules.push({
					baseId: puppyfw.helper.generateBaseId(),
					key: '',
					value: '',
					operator: '='
				});
			}
		}
	});

	builder.api.registerControl( 'email-control', {
		template: '#puppyfw-email-control-tpl',

		props: {
			id: {
				type: String
			},
			label: {
				type: String
			},
			value: {
				type: String
			}
		}
	});

	builder.api.registerControl( 'key-value-control', {
		template: '#puppyfw-key-value-control-tpl',

		props: {
			label: {
				type: String
			},
			addLabel: {
				type: String,
				default: '+'
			},
			items: {
				type: Array,
				default: []
			},
			sortable: {
				type: Boolean,
				default: true
			}
		},

		data: function() {
			return {
				stateItems: []
			};
		},

		watch: {
			stateItems: function( newVal ) {
				this.$emit( 'changeValue', newVal );
			}
		},

		beforeMount: function() {
			this.stateItems = this.items;
			this.stateItems = puppyfw.helper.convertObjectToArray( this.stateItems );
		},

		mounted: function() {
			this.initSortable();
		},

		methods: {
			initSortable: function() {
				var _this = this;

				$( this.$el ).find( '.key-value-items' ).sortable({
					cursor: 'move',
					handle: '.key-value-move',
					placeholder: 'key-value-placeholder',
					start: function( e, ui ) {
						ui.placeholder.height( ui.item.height() );
						ui.item.data( 'start', ui.item.index() );
					},
					update: function( event, ui ) {
						var start, end;

						start = ui.item.data( 'start' );
						end = ui.item.index();

						_this.moveItem( start, end );
					},
				});
			},

			moveItem: function( start, end ) {
				var item;
				item = this.stateItems.splice( start, 1 )[0];
				this.stateItems.splice( end, 0, item );
			},

			addItem: function() {
				this.stateItems.push({
					baseId: 'base-id_' + puppyfw.helper.getRandomString(),
					key: '',
					value: ''
				});
			},

			removeItem: function( index ) {
				Vue.delete( this.stateItems, index );
			}
		}
	});

	builder.api.registerControl( 'number-control', {
		template: '#puppyfw-number-control-tpl',

		props: {
			id: {
				type: String
			},
			label: {
				type: String
			},
			value: {
				type: Number
			}
		}
	});

	builder.api.registerControl( 'select-control', {
		template: '#puppyfw-select-control-tpl',

		props: {
			id: {
				type: String
			},
			label: {
				type: String
			},
			value: {
				type: String
			},
			options: {
				type: Object,
				required: true
			}
		},

		data: function() {
			return {
				stateOptions: []
			};
		},

		beforeMount: function() {
			this.stateOptions = this.options;
			this.stateOptions = puppyfw.helper.convertObjectToArray( this.stateOptions );
		}
	});

	builder.api.registerControl( 'text-control', {
		template: '#puppyfw-text-control-tpl',

		props: {
			id: {
				type: String
			},
			label: {
				type: String
			},
			value: {
				type: String
			}
		}
	});

	builder.api.registerControl( 'textarea-control', {
		template: '#puppyfw-textarea-control-tpl',

		props: {
			id: {
				type: String
			},
			label: {
				type: String
			},
			value: {
				type: String
			}
		}
	});

})( window.puppyfw, Vue, jQuery );
