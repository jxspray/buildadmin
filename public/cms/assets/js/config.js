var nodeModule = "/cms/assets/node_modules/"
require.config({
    baseUrl: configParams.baseUrl,
    waitSeconds: 200,
    paths: {
        'jquery': nodeModule + 'jquery/dist/jquery.min',
        'wow': nodeModule + 'wow.js/dist/wow',
    },

    shim : {
        modal: {
            deps   : ["jquery", "transition"],
            exports: "modal"
        }

    }

});
require(["jquery", "wow"], function($) {
    $(".box")
    console.log(123);
});