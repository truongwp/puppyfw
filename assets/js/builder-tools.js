/* global Clipboard */
( function() {
	"use strict";

	var BuilderExport = {
		populateExportData: function() {
			var data = {};
			data.page = {
				page_title: document.getElementById( 'puppyfw-page-title' ).value,
				menu_title: document.getElementById( 'puppyfw-menu-title' ).value,
				menu_slug: document.getElementById( 'puppyfw-menu-slug' ).value,
				capability: document.getElementById( 'puppyfw-capability' ).value,
				parent_slug: document.getElementById( 'puppyfw-parent-slug' ).value,
				icon_url: document.getElementById( 'puppyfw-icon-url' ).value,
				position: document.getElementById( 'puppyfw-position' ).value,
				option_name: document.getElementById( 'puppyfw-option-name' ).value
			};

			var fieldsData = document.getElementById( 'puppyfw-field-save-data' ).value;
			data.fields = fieldsData ? JSON.parse( fieldsData ) : [];

			document.getElementById( 'puppyfw-export-data' ).value = JSON.stringify( data );
		},

		initCopy: function() {
			// Initialize copy to clipboard.
			var codeClb = new Clipboard( '#puppyfw-copy-data', {
				text: function( trigger ) {
					return document.getElementById( 'puppyfw-export-data' ).value;
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
		},

		init: function() {
			this.populateExportData();
			this.initCopy();
		}
	};

	var BuilderImport = {
		import: function( data ) {
			// Populate fields data.
			document.getElementById( 'puppyfw-field-save-data' ).value = JSON.stringify( data.fields );

			// Populate page data.
			document.getElementById( 'puppyfw-page-title' ).value = data.page.page_title;
			document.getElementById( 'puppyfw-menu-title' ).value = data.page.menu_title;
			document.getElementById( 'puppyfw-menu-slug' ).value = data.page.menu_slug;
			document.getElementById( 'puppyfw-capability' ).value = data.page.capability;
			document.getElementById( 'puppyfw-parent-slug' ).value = data.page.parent_slug;
			document.getElementById( 'puppyfw-icon-url' ).value = data.page.icon_url;
			document.getElementById( 'puppyfw-position' ).value = data.page.position;
			document.getElementById( 'puppyfw-option-name' ).value = data.page.option_name;

			// Trigger saving.
			document.getElementById( 'post' ).submit();
		},

		fromInput: function() {
			var button, dataInput, _this = this;
			button = document.getElementById( 'puppyfw-import-data-btn' );
			dataInput = document.getElementById( 'puppyfw-import-data' );

			button.onclick = function() {
				button.disabled = true;
				var data = dataInput.value;

				if ( ! data ) {
					dataInput.focus();
					button.disabled = false;
					return;
				}

				data = JSON.parse( data );
				data.fields = data.fields || [];
				data.page = data.page || {};

				_this.import( data );
			};
		},

		fromFile: function() {
			var fileInput, fileButton;
			fileInput = document.getElementById( 'puppyfw-import-file' );
			fileButton = document.getElementById( 'puppyfw-import-file-btn' );

			function onClickBtn() {
				fileInput.click();
			}

			function handleFiles() {
				fileButton.disabled = true;

				var file = this.files[0];

				if ( ! file ) {
					fileButton.disabled = false;
					return;
				}

				if ( file.type !== 'application/json' ) {
					fileButton.disabled = false;
					return;
				}

				var reader = new FileReader();
				reader.onload = function( ev ) {
					var data = ev.target.result;
					document.getElementById( 'puppyfw-import-data' ).value = data;
					fileButton.disabled = false;
				};

				reader.readAsText( file );
			}

			fileButton.addEventListener( 'click', onClickBtn, false );
			fileInput.addEventListener( 'change', handleFiles, false );
		},

		init: function() {
			this.fromInput();
			this.fromFile();
		}
	};

	window.onload = function() {
		BuilderExport.init();
		BuilderImport.init();
	};

})();
