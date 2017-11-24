changeDomain.window.CreateOptionsResource = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'changedomain-options-resource-window-create';
    }
    Ext.applyIf(config, {
        title: _('changedomain_options_create'),
        width: 650,
        autoHeight: true,
        url: changeDomain.config.connector_url,
        action: 'mgr/item/options/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    changeDomain.window.CreateOptionsResource.superclass.constructor.call(this, config);
};
Ext.extend(changeDomain.window.CreateOptionsResource, MODx.Window, {


    getFields: function (config) {
        return [{
            xtype: 'hidden',
            //xtype: 'textfield',
            name: 'resource_id'
        },{
            xtype: 'changedomain-combo-domain',
            name: 'domain_id',
            allowBlank: false,
        },{
            xtype: 'textfield',
            fieldLabel: _('changedomain_option_name'),
            name: 'name',
            anchor: '99%',
            allowBlank: false,
        },{
            xtype: 'textfield',
            fieldLabel: _('changedomain_option_key'),
            name: 'key',
            anchor: '99%',
            allowBlank: false,
        },{
            xtype: 'textfield',
            fieldLabel: _('changedomain_option_value'),
            name: 'value',
            anchor: '99%',
            allowBlank: false,
        }]
    },

    loadDropZones: function () {
    }

});
Ext.reg('changedomain-options-resource-window-create', changeDomain.window.CreateOptionsResource);