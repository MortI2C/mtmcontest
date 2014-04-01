	   requirejs.config({
			baseUrl: "https://mtmcontest.cat/bundles/ibmmtm/js",
			paths: {
				jquery: '../vendor/jquery/dist/jquery.min',
				bootstrap: '../vendor/bootstrap/dist/js/bootstrap.min',
				html5shiv: '../vendor/html5shiv/dist/html5shiv',
				modernizr: '../vendor/modernizr/modernizr',
				placeholder: '../vendor/placeholder-shim/jquery.placeholder-shim',
				respond: '../vendor/respond/dest/respond.min',
			},
			shim: {
				bootstrap: ['jquery'],
			}
		 });