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

	/*builder.api.registerControl( 'choice-control', {
		template: '#puppyfw-choice-control-tpl',
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
				type: Array,
				default: []
			}
		}
	});*/

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
			options: {
				type: Array,
				default: []
			},
			sortable: {
				type: Boolean,
				default: true
			}
		},

		mounted: function() {
			this.initSortable();
		},

		methods: {
			initSortable: function() {
				var _this = this;

				$( this.$el ).find( '.key-value-options' ).sortable({
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

						_this.moveOption( start, end );
					},
				});
			},

			moveOption: function( start, end ) {
				var item;
				item = this.options.splice( start, 1 )[0];
				this.options.splice( end, 0, item );
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
				type: Array,
				required: true
			}
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
