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
})( Vue, jQuery );
