changeDomain.panel.Resources = function (config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'changedomain-panel-resource'
        ,autoHeight: true
        ,layout: 'form'
        ,anchor: '99%'
        ,items: [{
            xtype: 'changedomain-options-resource'
            ,cls: 'main-wrapper'
            // ,preventRender: true
            ,record: config.record
        }]
    });
    changeDomain.panel.Resources.superclass.constructor.call(this, config);
};
Ext.extend(changeDomain.panel.Resources, MODx.Panel);
Ext.reg('changedomain-panel-resource', changeDomain.panel.Resources);
