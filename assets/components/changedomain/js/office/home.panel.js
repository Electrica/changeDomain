changeDomain.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'changedomain-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: false,
            hideMode: 'offsets',
            items: [{
                title: _('changedomain_items'),
                layout: 'anchor',
                items: [{
                    html: _('changedomain_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'changedomain-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    changeDomain.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(changeDomain.panel.Home, MODx.Panel);
Ext.reg('changedomain-panel-home', changeDomain.panel.Home);
