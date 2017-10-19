Ext.onReady(function () {
    changeDomain.config.connector_url = OfficeConfig.actionUrl;

    var grid = new changeDomain.panel.Home();
    grid.render('office-changedomain-wrapper');

    var preloader = document.getElementById('office-preloader');
    if (preloader) {
        preloader.parentNode.removeChild(preloader);
    }
});