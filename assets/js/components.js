( function( Vue, $ ) {
	"use strict";

	/**
	 * Vue component puppyfw-datepicker-input.
	 */
	Vue.component( 'puppyfw-datepicker-input', {
		render: function( createElement ) {
			var attrs = {};

			attrs.type = 'text';
			if ( this.id ) {
				attrs.id = this.id;
			}
			if ( this.className ) {
				attrs['class'] = this.className;
			}
			if ( this.value ) {
				attrs.value = this.value;
			}

			return createElement(
				'input',
				{
					attrs: attrs
				}
			);
		},

		props: [ 'options', 'value', 'id', 'className' ],

		methods: {
			initDatepicker: function() {
				var options = this.options || {};
				console.log( options );

				// Set date format to yy-mm-dd by default.
				if ( ! options.dateFormat ) {
					options.dateFormat = 'yy-mm-dd';
				}

				options.onSelect = this.onSelect;
				options.beforeShow = this.beforeShow;

				$( this.$el ).datepicker( options );
			},

			/**
			 * Gets stored date from day, month, year.
			 *
			 * @param {Integer|String} day   Day value.
			 * @param {Integer|String} month Month value.
			 * @param {Integer|String} year  Year value.
			 *
			 * @return {String} Stored date in YYYY-MM-DD format.
			 */
			getStoredDate: function( day, month, year ) {
				var dd = day.toString();
				if ( ! dd[1] ) {
					dd = '0' + dd;
				}

				var mm = ( month + 1 ).toString();
				if ( ! mm[1] ) {
					mm = '0' + mm;
				}

				var yyyy = year.toString();

				return yyyy + '-' + mm + '-' + dd;
			},

			beforeShow: function() {
				$( '#ui-datepicker-div' ).wrap( '<div class="puppyfw-datepicker-div" />' );
			},

			onSelect: function( date, instance ) {
				this.$emit( 'changed-date', this.getStoredDate( instance.selectedDay, instance.selectedMonth, instance.selectedYear ) );
			}
		},

		mounted: function() {
			this.initDatepicker();

			if ( this.value ) {
				$( this.$el ).datepicker( 'setDate', new Date( this.value ) );
			}
		},

		beforeDestroy: function() {
			$( this.$el ).datepicker( 'hide' ).datepicker( 'destroy' );
		}
	});


	Vue.component( 'puppyfw-element-map', {
		template: '#puppyfw-element-map-template',

		props: {
			formatted_address: {
				type: String,
				default: ''
			},
			lat: {
				type: Number,
				default: 0
			},
			lng: {
				type: Number,
				default: 0
			}
		},

		data: function() {
			return {
				map: null,
				center: {
					formatted_address: '',
					lat: 0,
					lng: 0
				},
				markers: [],
				searchInput: null,
				error: ''
			};
		},

		watch: {
			center: {
				handler: function( newVal ) {
					this.$emit( 'changeCenter', newVal );
				},
				deep: true
			}
		},

		beforeMount: function() {
			Vue.set( this.center, 'formatted_address', this.formatted_address );
			Vue.set( this.center, 'lat', this.lat );
			Vue.set( this.center, 'lng', this.lng );

			this.triggerResize();
		},

		mounted: function() {
			this.initMap();
			this.initMarkers();
			this.initMapSearch();
		},

		methods: {
			/**
			 * Initialize map.
			 */
			initMap: function() {
				this.map = new google.maps.Map( this.$refs.map, {
					center: this.center,
					zoom: 16
				});
			},

			/**
			 * Initialize map search.
			 */
			initMapSearch: function() {
				var _this = this;

				this.searchInput = new google.maps.places.SearchBox( this.$refs.search );

				this.map.addListener( 'bounds_changed', this.bounds_changed );

				// Listen for the event fired when the user selects a prediction and retrieve
				// more details for that place.
				this.searchInput.addListener( 'places_changed', this.places_changed );
			},

			bounds_changed: function() {
				this.searchInput.setBounds( this.map.getBounds() );
			},

			places_changed: function() {
				var places = this.searchInput.getPlaces(),
					_this = this;

				if ( places.length == 0 ) {
					return;
				}

				this.clearMarkers();

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

					Vue.set( _this.center, 'lat', place.geometry.location.lat() );
					Vue.set( _this.center, 'lng', place.geometry.location.lng() );
					Vue.set( _this.center, 'formatted_address', place.formatted_address );

					if ( place.geometry.viewport ) {
						// Only geocodes have viewport.
						bounds.union( place.geometry.viewport );
					} else {
						bounds.extend( place.geometry.location );
					}
				});

				this.map.fitBounds( bounds );
			},

			/**
			 * Initialize map marker.
			 */
			initMarkers: function() {
				if ( ! this.center.lat || ! this.center.lng ) {
					return;
				}

				this.markers.push( new google.maps.Marker({
					map: this.map,
					title: this.center.formatted_address,
					position: this.center
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
			 * Fix map doesn't show when change from invisible to visible.
			 */
			triggerResize: function() {
				var _this = this;
				$( document ).one( 'puppyfw_changed_tab puppyfw_edit_field', function( ev ) {
					setTimeout( function() {
						google.maps.event.trigger( _this.map, 'resize' );
						_this.map.setCenter( _this.center );
					}, 500 );
				});
			},

			/**
			 * Clear map.
			 */
			clearMap: function() {
				this.clearMarkers();

				Vue.set( this.center, 'lat', 0 );
				Vue.set( this.center, 'lng', 0 );
				Vue.set( this.center, 'formatted_address', '' );

				this.map.setCenter({
					lat: 0,
					lng: 0
				});
			}
		}
	});
})( Vue, jQuery );
