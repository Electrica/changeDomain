changeDomain.combo.Search = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        xtype: 'twintrigger',
        ctCls: 'x-field-search',
        allowBlank: true,
        msgTarget: 'under',
        emptyText: _('search'),
        name: 'query',
        triggerAction: 'all',
        clearBtnCls: 'x-field-search-clear',
        searchBtnCls: 'x-field-search-go',
        onTrigger1Click: this._triggerSearch,
        onTrigger2Click: this._triggerClear,
    });
    changeDomain.combo.Search.superclass.constructor.call(this, config);
    this.on('render', function () {
        this.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
            this._triggerSearch();
        }, this);
    });
    this.addEvents('clear', 'search');
};
Ext.extend(changeDomain.combo.Search, Ext.form.TwinTriggerField, {

    initComponent: function () {
        Ext.form.TwinTriggerField.superclass.initComponent.call(this);
        this.triggerConfig = {
            tag: 'span',
            cls: 'x-field-search-btns',
            cn: [
                {tag: 'div', cls: 'x-form-trigger ' + this.searchBtnCls},
                {tag: 'div', cls: 'x-form-trigger ' + this.clearBtnCls}
            ]
        };
    },

    _triggerSearch: function () {
        this.fireEvent('search', this);
    },

    _triggerClear: function () {
        this.fireEvent('clear', this);
    },

});
Ext.reg('changedomain-combo-search', changeDomain.combo.Search);
Ext.reg('changedomain-field-search', changeDomain.combo.Search);



changeDomain.combo.Domain = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'domain_id',
        fieldLabel: _('changedomain_get_domain'),
        hiddenName: 'domain_id',
        displayField: 'name',
        valueField: 'id',
        anchor: '99%',
        fields: ['id', 'name'],
        pageSize: 20,
        url: changeDomain.config.connector_url,
        typeAhead: true,
        editable: true,
        allowBlank: true,
        emptyText: _('changedomain_get_domain'),
        baseParams: {
            action: 'mgr/item/getlistresource',
        }
    });
    changeDomain.combo.Domain.superclass.constructor.call(this, config);
};
Ext.extend(changeDomain.combo.Domain, MODx.combo.ComboBox);
Ext.reg('changedomain-combo-domain', changeDomain.combo.Domain);
