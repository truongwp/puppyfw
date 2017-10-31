( function( Vue, puppyfw ) {
	"use strict";

	var builderApp, toolsApp;
	builderApp = puppyfw.builder.app;

	toolsApp = puppyfw.builder.toolsApp = new Vue({
		data: {
			page: {
				page_title: document.getElementById( 'puppyfw-page-title' ).value,
				menu_title: document.getElementById( 'puppyfw-menu-title' ).value,
				menu_slug: document.getElementById( 'puppyfw-menu-slug' ).value,
				capability: document.getElementById( 'puppyfw-capability' ).value,
				parent_slug: document.getElementById( 'puppyfw-parent-slug' ).value,
				icon_url: document.getElementById( 'puppyfw-icon-url' ).value,
				position: document.getElementById( 'puppyfw-position' ).value,
				option_name: document.getElementById( 'puppyfw-option-name' ).value
			},
			fields: builderApp.fields
		},

		/*beforeMount: function() {
			var _this = this;
			builderApp.$on( 'change_fields', function( fields ) {
				_this.fields = fields;
			});
		},*/

		mounted: function() {
			// Initialize copy to clipboard.
			var codeClb = new Clipboard( '#puppyfw-copy-code', {
				text: function( trigger ) {
					return document.getElementById( 'puppyfw-exported-code' ).value;
				}
			});

			// Handle copy text.
			codeClb.on( 'success', function ( e ) {
				var button, text, altText;
				button = e.trigger;
				text = button.innerHTML;
				altText = button.getAttribute( 'data-alt-text' );

				button.innerHTML = altText;

				setTimeout( function () {
					button.innerHTML = text;
				}, 2000 );
			});
		}
	});

	toolsApp.$mount( '#puppyfw-builder-tools' );

})( Vue, puppyfw );
