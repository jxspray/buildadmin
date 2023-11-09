var nodeModule = "/cms/assets/node_modules/"
var configParams = {
    baseUrl: '/cms/assets/js',
    waitSeconds: 200,
    paths: {
        'jquery': nodeModule + 'jquery/dist/jquery.min',
        'wow': nodeModule + 'wow.js/dist/wow',
        'layui': nodeModule + 'layui/dist/layui',
        'jovo': '/cms/assets/js/jovo',
    },

    shim : {
        jovo: ['layui'],
        modal: {
            deps   : ["jquery", "transition"],
            exports: "modal"
        }

    }
}