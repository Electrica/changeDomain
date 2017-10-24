changeDomain.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'changedomain-item-window-create';
    }
    config.record = config.record || {object: {id: 0}}
    console.log(config.record);
    Ext.applyIf(config, {
        title: _('changedomain_item_create'),
        width: 650,
        autoHeight: true,
        url: changeDomain.config.connector_url,
        action: 'mgr/item/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    changeDomain.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(changeDomain.window.CreateItem, MODx.Window, {


    getFields: function (config) {
        var tabs = [{
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items:[{
                title: _('changedomain_details'),
                layout: 'anchor',
                items:[{
                    html: _('changedomain_details_intro'),
                    cls: 'panel-desc'
                },{
                    layout: 'column',
                    border: 'false',
                    anchor: '100%',
                    items:[{
                        columnWidth: 1
                        ,layout: 'form',
                        defaults: {msTarget: 'under'},
                        border: 'false',
                        items: [{
                            xtype: 'textfield',
                            fieldLabel: _('changedomain_city_name'),
                            name: 'name',
                            anchor: '99%',
                            allowBlank: false,
                        }, {
                            xtype: 'textfield',
                            fieldLabel: _('changedomain_domain'),
                            name: 'domain',
                            anchor: '99%',
                            allowBlank: false,
                        },{
                            xtype: 'textarea',
                            fieldLabel: _('changedomain_description'),
                            name: 'description',
                            anchor: '99%',
                            allowBlank: false,
                        },{
                            xtype: 'textarea',
                            fieldLabel: _('changedomain_keywords'),
                            name: 'keywords',
                            anchor: '99%',
                            allowBlank: false,
                        },{
                            xtype: 'textarea',
                            fieldLabel: _('changedomain_maps'),
                            name: 'maps',
                            height: 150,
                            anchor: '99%'
                        },{
                            xtype: 'textarea',
                            fieldLabel: _('changedomain_yandex'),
                            name: 'yandex',
                            height: 150,
                            anchor: '99%'
                        },{
                            xtype: 'xcheckbox',
                            boxLabel: _('changedomain_active'),
                            name: 'active',
                            checked: true,
                        }]
                    }]
                }]
            },{
                title: _('changedomain_options'),
                layout: 'anchor',
                items:[{
                    html: _('changedomain_options_intro'),
                    cls: 'panel-desc'
                }]
            }]
        }];
        return tabs;
    },

    loadDropZones: function () {
    }

});
Ext.reg('changedomain-item-window-create', changeDomain.window.CreateItem);


changeDomain.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'changedomain-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('changedomain_item_update'),
        width: 550,
        autoHeight: true,
        url: changeDomain.config.connector_url,
        action: 'mgr/item/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    changeDomain.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(changeDomain.window.UpdateItem, MODx.Window, {

    getFields: function (config) {

        var tabs = [{
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items:[{
                title: _('changedomain_details'),
                layout: 'anchor',
                items:[{
                    html: _('changedomain_details_intro'),
                    cls: 'panel-desc'
                },{
                    layout: 'column',
                    border: 'false',
                    anchor: '100%',
                    items:[{
                        columnWidth: 1
                        ,layout: 'form',
                        defaults: {msTarget: 'under'},
                        border: 'false',
                        items: [{
                            xtype: 'hidden',
                            name: 'id'
                        },{
                            xtype: 'textfield',
                            fieldLabel: _('changedomain_city_name'),
                            name: 'name',
                            anchor: '99%',
                            allowBlank: false,
                        }, {
                            xtype: 'textfield',
                            fieldLabel: _('changedomain_domain'),
                            name: 'domain',
                            anchor: '99%',
                            allowBlank: false,
                        },{
                            xtype: 'textarea',
                            fieldLabel: _('changedomain_description'),
                            name: 'description',
                            anchor: '99%',
                            allowBlank: false,
                        },{
                            xtype: 'textarea',
                            fieldLabel: _('changedomain_keywords'),
                            name: 'keywords',
                            anchor: '99%',
                            allowBlank: false,
                        },{
                            xtype: 'textarea',
                            fieldLabel: _('changedomain_maps'),
                            name: 'maps',
                            height: 150,
                            anchor: '99%'
                        },{
                            xtype: 'textarea',
                            fieldLabel: _('changedomain_yandex'),
                            name: 'yandex',
                            height: 150,
                            anchor: '99%'
                        },{
                            xtype: 'xcheckbox',
                            boxLabel: _('changedomain_active'),
                            name: 'active',
                            checked: true,
                        }]
                    }]
                }]
            },{
                title: _('changedomain_options'),
                layout: 'anchor',
                items:[{
                    html: _('changedomain_options_intro'),
                    cls: 'panel-desc'
                },{
                    layout: 'column',
                    border: 'false',
                    anchor: '100%',
                    items:[{
                        xtype: 'changedomain-options-items',
                        preventRender: true,
                        record: config.record.object
                    }]
                }]
            }]
        }];
        return tabs;
    },

    loadDropZones: function () {
    }

});
Ext.reg('changedomain-item-window-update', changeDomain.window.UpdateItem);