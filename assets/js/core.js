( function( $ ) {
	"use strict";

	var Field = PuppyFW.Field = {
		props: ['field'],

		computed: {
			value: function() {
				return this.field.value;
			}
		},

		watch: {
			value: function( newVal, oldVal ) {
				if ( newVal == oldVal ) {
					return;
				}
				PuppyFW.App.$emit( 'puppyfw_changed_' + this.field.id_attr, newVal, oldVal );
			}
		},

		methods: {
			/**
			 * Handle dependency.
			 */
			dependency: function() {
				if ( ! this.field.dependency || ! this.field.dependency.length ) {
					return;
				}

				var dependencies = [],
					_this = this;

				if ( typeof this.field.dependency[0] == 'string' ) {
					// Single dependency.
					dependencies.push( this.parseDependency( this.field.dependency ) );
				} else {
					// Multiple dependencies.
					_.each( this.field.dependency, function( dependency ) {
						dependencies.push( _this.parseDependency( dependency ) );
					});
				}

				Vue.set( this.field, 'visible', this.getVisible( _.clone( dependencies ) ) );
				this.handleVisibilityOnChange( _.clone( dependencies ) );
			},

			/**
			 * Parse dependency,
			 *
			 * @param  {Array} dependency Dependency data.
			 * @return {Object}           Parsed dependency object.
			 */
			parseDependency: function( dependency ) {
				var fieldId, operator, fieldVal;

				fieldId = dependency[0];

				if ( dependency.length == 1 ) {
					operator == 'NOT EMPTY';
				} else if ( dependency.length == 2 ) {
					operator = '==';
					fieldVal = dependency[1];
				} else {
					operator = dependency[1];
					fieldVal = dependency[2];
				}

				return {
					id: fieldId,
					operator: operator,
					value: fieldVal
				};
			},

			/**
			 * Get visibility of this field.
			 *
			 * @param  {Array} dependencies List dependencies.
			 * @return {Boolean}
			 */
			getVisible: function( dependencies ) {
				var _this = this,
					result = true;

				_.each( dependencies, function( dependency, index ) {
					if ( ! result ) {
						return false;
					}

					if ( ! dependency ) {
						return true;
					}

					// Handle visibility on first load.
					var fieldVal = PuppyFW.App.getValueFromIdAttr( 'puppyfw-' + dependency.id );
					var visible = _this.isVisible( dependency, fieldVal );

					// Combine with other dependencies.
					var otherDependencies = _.clone( dependencies );
					Vue.delete( otherDependencies, index );
					Vue.set( _this.field, 'visible', visible && _this.getVisible( otherDependencies ) );

					if ( ! visible ) {
						result = false;
					}
				});

				return result;
			},

			/**
			 * Handle visibility when a field value changed.
			 *
			 * @param {Array} dependencies List dependencies.
			 */
			handleVisibilityOnChange: function( dependencies ) {
				var _this = this;

				_.each( dependencies, function( dependency, index ) {
					if ( ! dependency ) {
						return;
					}

					PuppyFW.App.$on( 'puppyfw_changed_puppyfw-' + dependency.id, function( newVal ) {
						var visible = _this.isVisible( dependency, newVal );

						// Combine with other dependencies.
						var otherDependencies = _.clone( dependencies );
						Vue.delete( otherDependencies, index );
						Vue.set( _this.field, 'visible', visible && _this.getVisible( otherDependencies ) );
					});
				});
			},

			/**
			 * Check visibility.
			 *
			 * @param  {Object}  dependency Dependency object.
			 * @param  {mixed}   value      Field value.
			 * @return {Boolean}
			 */
			isVisible: function( dependency, value ) {
				if ( '==' == dependency.operator ) {
					return value == dependency.value;
				}

				if ( '!=' == dependency.operator ) {
					return value != dependency.value;
				}

				if ( '>' == dependency.operator ) {
					return value > dependency.value;
				}

				if ( '<' == dependency.operator ) {
					return value < dependency.value;
				}

				if ( '>=' == dependency.operator ) {
					return value >= dependency.value;
				}

				if ( '<=' == dependency.operator ) {
					return value <= dependency.value;
				}

				if ( 'NOT EMPTY' == dependency.operator ) {
					return value;
				}

				if ( 'CONTAIN' == dependency.operator ) {
					if( typeof dependency.value == 'string' ) {
						return value.indexOf( dependency.value ) >= 0;
					}

					// CONTAIN operator support array of value, use as OR operator.
					var result = false;
					_.each( dependency.value, function( depVal ) {
						if ( result ) {
							return;
						}

						if ( value.indexOf( depVal ) >= 0 ) {
							result = true;
							return;
						}
					});
					return result;
				}

				if ( 'NOT CONTAIN' == dependency.operator ) {
					return value.indexOf( dependency.value ) < 0;
				}

				if ( 'IN' == dependency.operator ) {
					return dependency.value.indexOf( value ) >= 0;
				}

				if ( 'NOT IN' == dependency.operator ) {
					return dependency.value.indexOf( value ) < 0;
				}

				return true;
			}
		},

		beforeMount: function() {
			this.dependency();
		}
	};

	var ParentField = PuppyFW.ParentField = {
		methods: {
			getComponentName: function( type ) {
				if ( PuppyFW.mapping[ type ] ) {
					type = PuppyFW.mapping[ type ];
				}

				return 'puppyfw-' + type;
			}
		}
	};

	PuppyFW.App = new Vue({
		el: '#puppyfw-app',

		mixins: [ PuppyFW.ParentField ],

		data: {
			fields: [],
			fieldRegistry: {},
			notice: {
				type: 'error',
				message: ''
			}
		},

		methods: {
			/**
			 * Fetch fields.
			 */
			fetchFields: function() {
				var _this = this;

				this.fields = PuppyFW.fields;

				_.each( PuppyFW.fields, function( field ) {
					_this.addFieldToRegistry( field );
				});
			},

			/**
			 * Add a field to field registry,
			 *
			 * @param {Object} field Field object,
			 */
			addFieldToRegistry: function( field ) {
				var _this = this;

				switch ( field.type ) {
					case 'tab':
						_.each( field.fields, function( childField ) {
							_this.addFieldToRegistry( childField );
						});
						break;

					case 'group':
						var sep = '---';
						_.each( field.fields, function( childField ) {
							childField.id_attr = field.id_attr + sep + childField.id;
							_this.addFieldToRegistry( childField );
						});

						break;

					default:
						_this.fieldRegistry[ field.id_attr ] = field;
				}
			},

			/**
			 * Get field value from ID attribute.
			 *
			 * @param  {String} idAttr Field ID attribute.
			 * @return {mixed}         Field value.
			 */
			getValueFromIdAttr: function( idAttr ) {
				if ( ! this.fieldRegistry[ idAttr ] ) {
					return null;
				}

				return this.fieldRegistry[ idAttr ].value;
			},

			/**
			 * Get save data.
			 *
			 * @return {Array}
			 */
			getSaveData: function() {
				/*
				 * Loop through fields, build field data and send.
				 * Repeatable fields will be store as numeric array.
				 * Group fields will be store as [nested] assoc array.
				 */
				var saveData = [],
					_this = this;

				/**
				 * Get value of field (include child fields).
				 *
				 * @param  {Object} field Field object.
				 * @return {mixed}
				 */
				var getValue = function( field ) {
					var _this = this;

					if ( 'editor' === field.type ) {
						return wp.editor.getContent( field.id_attr );
					}

					if ( 'group' === field.type ) {
						var value = {};

						_.each( field.fields, function( childField ) {
							value[ childField.id ] = getValue( childField );
						});

						return value;
					}

					if ( 'repeatable' === field.type ) {
						var value = [];
						_.each( field.repeatFields, function( repeatField ) {
							value.push( getValue( repeatField ) );
						});
						return value;
					}

					return field.value;
				};

				/**
				 * Build save data.
				 *
				 * @param {Object} field Field object.
				 */
				var buildData = function( field ) {
					switch ( field.type ) {
						case 'tab':
							_.each( field.fields, function( childField ) {
								buildData( childField );
							});
							break;

						default:
							saveData.push({
								id: field.id,
								value: getValue( field ),
								type: field.type
							});
					};
				};

				_.each( _this.fields, function( field ) {
					buildData( field );
				});

				return saveData;
			},

			/**
			 * Clear notice.
			 */
			clearNotice: function() {
				this.notice = {
					type: 'error',
					message: ''
				};
			},

			/**
			 * Set success message.
			 *
			 * @param {String} message Message.
			 */
			success: function( message ) {
				Vue.set( this.notice, 'type', 'success' );
				Vue.set( this.notice, 'message', message );
			},

			/**
			 * Set error message.
			 *
			 * @param {String} message Message.
			 */
			error: function( message) {
				Vue.set( this.notice, 'type', 'error' );
				Vue.set( this.notice, 'message', message );
			},

			/**
			 * Handle saving.
			 */
			save: function( ev ) {
				var _this = this;

				$.ajax({
					url: PuppyFW.endpoint,
					type: 'post',
					data: {
						field_data: this.getSaveData(),
						page_data: PuppyFW.pageData,
						_wpnonce: PuppyFW.restNonce
					},
					success: function( response ) {
						if ( response.updated ) {
							_this.success( response.message );
						} else {
							var message = response.message || PuppyFW.i18n.saveError;
							_this.error( message );
						}

						$( 'body, html' ).animate({
							scrollTop: 0
						});
					},

					error: function( response ) {
						console.log( response );
						_this.error( response.responseJSON.message );
					}
				});
			}
		},

		mounted: function() {
			this.fetchFields();
		}
	});

	Vue.component( 'puppyfw-input', {
		template: '#puppyfw-field-template-input',
		mixins: [ Field ]
	});

	Vue.component('puppyfw-textarea', {
		template: '#puppyfw-field-template-textarea',
		mixins: [ Field ]
	});

	Vue.component('puppyfw-checkbox', {
		template: '#puppyfw-field-template-checkbox',
		mixins: [ Field ],

		beforeMount: function() {
			if ( ! this.field.value || this.field.value == 'false' ) {
				this.field.value = 0;
			} else {
				this.field.value = 1;
			}
		}
	});

	Vue.component('puppyfw-checkbox_list', {
		template: '#puppyfw-field-template-checkbox-list',
		mixins: [ Field ],

		beforeMount: function() {
			if ( ! this.field.value ) {
				Vue.set( this.field, 'value', [] );
			}
		}
	});

	Vue.component('puppyfw-radio', {
		template: '#puppyfw-field-template-radio',
		mixins: [ Field ]
	});

	Vue.component('puppyfw-select', {
		template: '#puppyfw-field-template-select',
		mixins: [ Field ],

		methods: {
			initValue: function() {
				if ( this.field.value ) {
					return;
				}

				if ( this.field.multiple ) {
					Vue.set( this.field, 'value', [] );
				} else {
					Vue.set( this.field, 'value', '' );
				}
			}
		},

		beforeMount: function() {
			this.initValue();
		}
	});

	Vue.component('puppyfw-image', {
		template: '#puppyfw-field-template-image',
		mixins: [ Field ],

		data: function() {
			return {
				_frame: null
			};
		},

		methods: {
			/**
			 * Get media frame.
			 *
			 * @return {Object}
			 */
			frame: function() {
				if ( this._frame ) {
					return this._frame;
				}

				this._frame = wp.media( {
					title: wp.media.view.l10n.addMedia,
					multiple: false,
					library: {
						type: 'image'
					}
				} );

				this._frame.on( 'open', this.open );
				this._frame.on( 'select', this.select );

				return this._frame;
			},

			/**
			 * Handle opening frame.
			 */
			open: function() {
				if ( ! this.field.value.id ) {
					return;
				}

				var selection = this.frame().state().get('selection');
				var attachment = wp.media.attachment( this.field.value.id );
				selection.add( attachment );
			},

			/**
			 * Handle when select item.
			 */
			select: function() {
				var image = this.frame().state().get( 'selection' ).first().toJSON();
				Vue.set( this.field, 'value', {
					id: image.id,
					url: image.url
				});
			},

			/**
			 * Handle when click upload button.
			 */
			upload: function() {
				this.frame().open();
			},

			/**
			 * Remove uploaded item.
			 */
			remove: function() {
				this.field.value = {
					id: '',
					url: ''
				};
			}
		},

		beforeMount: function() {
			if ( typeof this.field.value === 'undefined' || this.field.value === null ) {
				this.field.value = {
					id: '',
					url: ''
				};
			}
		}
	});

	Vue.component('puppyfw-images', {
		template: '#puppyfw-field-template-images',
		mixins: [ Field ],

		data: function() {
			return {
				_frame: null
			};
		},

		methods: {
			/**
			 * Get media frame.
			 *
			 * @return {Object}
			 */
			frame: function() {
				if ( this._frame ) {
					return this._frame;
				}

				this._frame = wp.media( {
					title: wp.media.view.l10n.addMedia,
					multiple: true,
					library: {
						type: 'image'
					}
				} );

				this._frame.on( 'open', this.open );
				this._frame.on( 'select', this.select );

				return this._frame;
			},

			/**
			 * Handle opening frame.
			 */
			open: function() {
				if ( this.field.value == {} ) {
					return;
				}

				var selection = this.frame().state().get('selection');

				_.each( this.field.value, function( item ) {
					var attachment = wp.media.attachment( item.id );
					selection.add( attachment );
				});
			},

			/**
			 * Handle when select item.
			 */
			select: function() {
				var images = this.frame().state().get( 'selection' ).toJSON(),
					value = [];

				_.each( images, function( image ) {
					value.push({
						id: image.id,
						url: image.url
					});
				});

				Vue.set( this.field, 'value', value );
			},

			/**
			 * Handle when click upload button.
			 */
			upload: function() {
				this.frame().open();
			},

			/**
			 * Remove item.
			 */
			remove: function( index ) {
				Vue.delete( this.field.value, index );
			},

			/**
			 * Remove all uploaded items.
			 */
			removeAll: function() {
				this.field.value = {};
			},

			initSortable: function() {
				var $preview = $( this.$el ).find( '.puppyfw-images__preview' ),
					_this = this,
					value = this.field.value;

				$preview.sortable({
					placeholder: 'puppyfw-images__item-placeholder',
					dropOnEmpty: false,
					cancel: '.puppyfw-images__remove',
					start: function ( event, ui ) {
						ui.placeholder.height( ui.item.outerHeight() );
						ui.item.data( 'start', ui.item.index() );
					},
					update: function( event, ui ) {
						var start, end;

						start = ui.item.data( 'start' );
						end = ui.item.index();

						_this.updateAfterSorting( start, end );
					}
				});
			},

			updateAfterSorting: function( start, end ) {
				var item, value;
				value = this.field.value;
				item = value.splice( start, 1 )[0];
				value.splice( end, 0, item );
				Vue.set( this.field, 'value', value );
			}
		},

		beforeMount: function() {
			if ( typeof this.field.value === 'undefined' || this.field.value === null ) {
				this.field.value = [];
			}
		},

		mounted: function() {
			this.initSortable();
		}
	});

	Vue.component( 'puppyfw-editor', {
		template: '#puppyfw-field-template-editor',
		mixins: [ Field ],

		mounted: function() {
			var _this = this;
			setTimeout( function() {
				wp.editor.initialize( _this.field.id_attr, {
					tinymce: _this.field.tinymce,
					quicktags: _this.field.quicktags
				} );
			}, 500 );
		}
	});

	Vue.component('puppyfw-map', {
		template: '#puppyfw-field-template-map',

		mixins: [ Field ],

		data: function() {
			return {
				map: null,
				center: {},
				searchInput: null,
				markers: [],
				error: ''
			};
		},

		methods: {
			/**
			 * Initialize center value.
			 */
			initCenter: function() {
				if ( ! this.field.value || ! this.field.value.lat ) {
					this.center = {
						lat: -34.397,
						lng: 150.644
					};
				} else {
					this.center = {
						lat: parseFloat( this.field.value.lat ),
						lng: parseFloat( this.field.value.lng )
					};
				}
			},

			/**
			 * Initialize map.
			 */
			initMap: function() {
				var _this = this;

				// Init map.
				this.map = new google.maps.Map( this.$refs.map, {
					center: _this.center,
					zoom: 17
				});
			},

			/**
			 * Initialize map search.
			 */
			initMapSearch: function() {
				var _this = this;

				this.searchInput = new google.maps.places.SearchBox( this.$refs.searchInput );

				this.map.addListener( 'bounds_changed', function() {
					_this.searchInput.setBounds( _this.map.getBounds() );
				});

				// Listen for the event fired when the user selects a prediction and retrieve
				// more details for that place.
				this.searchInput.addListener( 'places_changed', function() {
					var places = _this.searchInput.getPlaces();

					if ( places.length == 0 ) {
						return;
					}

					_this.clearMarkers();

					// For each place, get the icon, name and location.
					var bounds = new google.maps.LatLngBounds();

					places.forEach( function( place ) {
						if ( ! place.geometry ) {
							console.log( 'Returned place contains no geometry' );
							return;
						}

						// Create a marker for each place.
						_this.markers.push( new google.maps.Marker({
							map: _this.map,
							// icon: icon,
							title: place.name,
							position: place.geometry.location
						}));

						Vue.set( _this.field, 'value', {
							lat: place.geometry.location.lat(),
							lng: place.geometry.location.lng(),
							formatted_address: place.formatted_address
						});

						if ( place.geometry.viewport ) {
							// Only geocodes have viewport.
							bounds.union( place.geometry.viewport );
						} else {
							bounds.extend( place.geometry.location );
						}
					});

					_this.map.fitBounds( bounds );
				});
			},

			/**
			 * Initialize map marker.
			 */
			initMarkers: function() {
				if ( ! this.field.value || ! this.field.value.lat ) {
					return;
				}

				var _this = this;
				this.markers.push( new google.maps.Marker({
					map: _this.map,
					// icon: icon,
					title: _this.field.value.formatted_address,
					position: _this.center
				}));
			},

			/**
			 * Clear out the old markers.
			 */
			clearMarkers: function() {
				this.markers.forEach( function( marker ) {
					marker.setMap( null );
				});
				this.markers = [];
			},

			/**
			 * Fix map not work with tab.
			 */
			fixTab: function() {
				var _this = this;
				$( document ).one( 'puppyfw_changed_tab', function( ev, tab ) {
					google.maps.event.trigger( _this.map, 'resize' );
					_this.map.setCenter( _this.center );
				});
			},

			/**
			 * Clear map.
			 */
			clearMap: function() {
				this.clearMarkers();
				this.field.value = {
					lat: '',
					lng: '',
					formatted_address: ''
				};
				this.map.setCenter({
					lat: -34.397,
					lng: 150.644
				});
			}
		},

		beforeMount: function() {
			this.initCenter();
		},

		mounted: function() {
			if ( google === undefined ) {
				this.error = 'Can\' load google map api.';
				return;
			}

			this.initMap();
			this.initMapSearch();
			this.initMarkers();
			this.fixTab();
		}
	});

	Vue.component('puppyfw-group', {
		template: '#puppyfw-field-template-group',
		mixins: [ Field, ParentField ],

		methods: {
			/**
			 * Populate group data to child fields.
			 */
			populateData: function() {
				var _this = this,
					sep = '---';

				/**
				 * Populate data for a field.
				 * @param {Object} field Field object,
				 */
				var populate = function( field ) {
					_.each( field.fields, function( childField ) {
						childField.id_attr = field.id_attr + sep + childField.id;

						if ( ! field.value ) {
							return;
						}

						if ( field.value ) {
							childField.value = field.value[ childField.id ];
						}

						if ( childField.type === 'group' ) {
							childField.value = populate( childField );
							return;
						}
					});
				}

				populate( this.field );
			}
		},

		beforeMount: function() {
			this.populateData();
		}
	});

	Vue.component('puppyfw-tab', {
		template: '#puppyfw-field-template-tab',
		mixins: [ Field, ParentField ],

		data: function() {
			return {
				currentTab: '',
				tabChanged: false
			};
		},

		methods: {
			/**
			 * Set default active tab.
			 */
			setDefaultTab: function() {
				var tabs = this.field.tabs || {},
					tabIds = Object.keys(tabs);

				if (typeof tabIds[0] === 'undefined') {
					return;
				}

				this.currentTab = tabIds[0];
			},

			/**
			 * Get tab ID attribute.
			 *
			 * @param  {String} tabId Field tab ID.
			 * @return {String}
			 */
			getTabId: function(tabId) {
				return this.field.id_attr + '-tab-' + tabId;
			},

			/**
			 * Activate a tab.
			 *
			 * @param {String} tabId Tab ID.
			 */
			activeTab: function(tabId) {
				this.currentTab = tabId;
				this.tabChanged = true;
				$( document ).trigger( 'puppyfw_change_tab', this );
			}
		},

		mounted: function() {
			this.setDefaultTab();
		},

		updated: function( a, b ) {
			if ( this.tabChanged ) {
				$( document ).trigger( 'puppyfw_changed_tab', this );
				this.tabChanged = false;
			}
		}
	});

	Vue.component('puppyfw-repeatable', {
		template: '#puppyfw-field-template-repeatable',

		mixins: [ Field, ParentField ],

		data: function() {
			return {
				repeatField: null,
				delimiter: '---'
			};
		},

		methods: {
			addItem: function() {
				var field = this.cloneDeep( this.repeatField ),
					fields = this.cloneDeep( this.field.repeatFields );
				field.id_attr = this.field.id_attr + this.delimiter + parseInt( Math.random() * 1000 );
				fields.push( field );
				Vue.set( this.field, 'repeatFields', fields );
			},

			removeItem: function( index ) {
				var fields = this.field.repeatFields,
					value = this.field.value;

				Vue.delete( fields, index );
				Vue.delete( value, index );

				Vue.set( this.field, 'repeatFields', fields );
				Vue.set( this.field, 'value', value );
			},

			initValue: function() {
				if ( ! this.field.value ) {
					Vue.set( this.field, 'value', [ null ] );
				}
			},

			initRepeatField: function() {
				var repeatField = this.cloneDeep( this.field );
				repeatField.type = repeatField.repeat_field_type;
				repeatField.value = null;
				this.repeatField = repeatField;
			},

			initRepeatFields: function() {
				var fields = [],
					_this = this;

				_.each( this.field.value, function( value, index ) {
					var field = _this.cloneDeep( _this.repeatField );
					field.value = value;
					field.id_attr = _this.field.id_attr + _this.delimiter + index;
					fields.push( field );
				});

				Vue.set( this.field, 'repeatFields', fields );
			},

			cloneDeep: function( obj ) {
				return JSON.parse( JSON.stringify( obj ) );
			}
		},

		beforeMount: function() {
			this.initValue();
			this.initRepeatField();
			this.initRepeatFields();
		}
	});

})( jQuery );
