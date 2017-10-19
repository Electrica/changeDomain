changeDomain.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'changedomain-panel-home',
            renderTo: 'changedomain-panel-home-div'
        }]
    });
    changeDomain.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(changeDomain.page.Home, MODx.Component);
Ext.reg('changedomain-page-home', changeDomain.page.Home);