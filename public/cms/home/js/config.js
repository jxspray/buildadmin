var baseUrl = '/cms/assets/node_modules';
require.config({
    baseUrl: "/cms/assets/js",
    waitSeconds: 200,
    paths: {
        'jquery': baseUrl + '/jquery/dist/jquery.min',
    },

    shim : {
        modal: {
            deps   : ["jquery", "transition"],
            exports: "modal"
        }

    }

});
require(["jquery"], function($) {
    $(".box")
    console.log(123);
});